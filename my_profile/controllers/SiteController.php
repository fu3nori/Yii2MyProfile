<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use yii\authclient\AuthAction;
use app\models\User;
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
            'auth' => [
                'class' => AuthAction::class,
                'successCallback' => [$this, 'onAuthSuccess'],
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        // Process PayPal payment if returning from PayPal
        if (isset($_GET['paymentId']) && isset($_GET['PayerID'])) {
            $this->processPayPalPayment($_GET['paymentId'], $_GET['PayerID']);
        }

        return $this->render('index');
    }

    /**
     * Process PayPal payment after user returns from PayPal
     * 
     * @param string $paymentId PayPal payment ID
     * @param string $payerId PayPal payer ID
     * @return bool Whether the payment was processed successfully
     */
    protected function processPayPalPayment($paymentId, $payerId)
    {
        if (!Yii::$app->user->isGuest) {
            try {
                // Execute the payment
                $result = Yii::$app->paypal->executePayment($paymentId, $payerId);

                // If payment execution was successful
                if (isset($result['state']) && $result['state'] === 'approved') {
                    $userId = Yii::$app->user->id;

                    // Update user role to premium (3)
                    $user = User::findOne($userId);
                    if ($user) {
                        $user->role = 3;
                        $user->transaction_id = $paymentId;
                        $user->payment_status = 'COMPLETED';

                        if ($user->save()) {
                            Yii::$app->session->setFlash('success', 'Payment processed successfully. You now have premium access!');
                            return true;
                        } else {
                            Yii::error('Failed to update user after payment: ' . json_encode($user->errors));
                            Yii::$app->session->setFlash('error', 'Payment was successful but we could not update your account. Please contact support.');
                        }
                    }
                } else {
                    Yii::error('PayPal payment execution failed: ' . json_encode($result));
                    Yii::$app->session->setFlash('error', 'Payment processing failed. Please try again or contact support.');
                }
            } catch (\Exception $e) {
                Yii::error('Error processing PayPal payment: ' . $e->getMessage());
                Yii::$app->session->setFlash('error', 'An error occurred while processing your payment. Please try again or contact support.');
            }
        }

        return false;
    }

    /**
     * Handles PayPal webhook notifications.
     *
     * @return Response
     */
    public function actionWebhook()
    {
        Yii::$app->response->format = Response::FORMAT_RAW;

        // Get PayPal webhook data
        $raw_post_data = file_get_contents('php://input');
        $decoded_data = json_decode($raw_post_data, true);

        // Verify webhook signature
        $headers = Yii::$app->request->headers;
        $paypalHeaders = [
            'PAYPAL-AUTH-ALGO' => $headers->get('PAYPAL-AUTH-ALGO'),
            'PAYPAL-CERT-URL' => $headers->get('PAYPAL-CERT-URL'),
            'PAYPAL-TRANSMISSION-ID' => $headers->get('PAYPAL-TRANSMISSION-ID'),
            'PAYPAL-TRANSMISSION-SIG' => $headers->get('PAYPAL-TRANSMISSION-SIG'),
            'PAYPAL-TRANSMISSION-TIME' => $headers->get('PAYPAL-TRANSMISSION-TIME'),
        ];

        $isValid = Yii::$app->paypal->verifyWebhookSignature($raw_post_data, $paypalHeaders);

        if (!$isValid) {
            Yii::error('Invalid PayPal webhook signature');
            return 'Invalid signature';
        }

        // Process webhook data
        if (isset($decoded_data['resource'])) {
            // Get necessary information
            $user_id = $decoded_data['resource']['custom_id'] ?? null; // Custom ID set during payment
            $transaction_id = $decoded_data['resource']['id'] ?? null; // PayPal transaction ID
            $payment_status = $decoded_data['resource']['status'] ?? null; // Payment status

            if ($user_id && $transaction_id && $payment_status) {
                // Update user record
                $user = User::findOne($user_id);
                if ($user) {
                    $user->transaction_id = $transaction_id;
                    $user->payment_status = $payment_status;

                    // If payment is completed, update user role to premium (3)
                    if ($payment_status === 'COMPLETED') {
                        $user->role = 3;
                    }

                    if (!$user->save()) {
                        Yii::error('Failed to update user: ' . json_encode($user->errors));
                        return 'Error updating user';
                    }

                    return 'Webhook processed successfully';
                }
            }
        }

        Yii::error('Invalid PayPal webhook data');
        return 'Invalid data';
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
    /**
     * google login
     */
    public function onAuthSuccess($client)
    {
        $attributes = $client->getUserAttributes();

        $googleId = $attributes['id'];
        $email = $attributes['email'];
        $name = $attributes['name'];

        $user = User::find()->where(['google_id' => $googleId])->one();
        if (!$user) {
            // ユーザーが存在しない場合、新しいユーザーを作成
            $user = new User();
            $user->google_id = $googleId;
            $user->mail = $email;
            $user->username = $name;
            $user->auth_provider = 'google';
            $user->save(false);  // 必要に応じて検証を追加
        }

        Yii::$app->user->login($user);
    }
}
