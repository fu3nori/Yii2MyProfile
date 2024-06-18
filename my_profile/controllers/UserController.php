<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use app\models\User;
use yii\base\DynamicModel;
use Endroid\QrCode\Builder\Builder;
class UserController extends Controller
{
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new \app\models\LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        return $this->render('user-login', [
            'model' => $model,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }

    public function actionRegist()
    {
        $model = new User();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->setPassword($model->password);
            $model->role = User::find()->count() === 0 ? 1 : 0; // 最初のユーザーのみ role を 1 にする
            $model->save(false);
            Yii::$app->user->login($model);
            return $this->redirect(['site/index']);
        }

        return $this->render('user-regist', [
            'model' => $model,
        ]);
    }

    public function actionEdit($id)
    {
        $currentUserId = Yii::$app->user->id;
        $currentUserRole = Yii::$app->user->identity->role;

        if ($currentUserRole != 1 && $currentUserId != $id) {
            throw new ForbiddenHttpException('アクセスが拒否されました');
        }

        $model = User::findOne($id);
        if (!$model) {
            throw new \yii\web\NotFoundHttpException('ユーザーが見つかりません');
        }

        $oldPassword = $model->password;

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if (!empty($model->password)) {
                $model->setPassword($model->password);
            } else {
                $model->password = $oldPassword;
            }
            $model->save(false);
            return $this->redirect(['site/index']);
        }

        $model->password = ''; // パスワードフィールドを空にしておく

        return $this->render('user-edit', [
            'model' => $model,
        ]);
    }


    public function actionList()
    {
        if (Yii::$app->user->isGuest || Yii::$app->user->identity->role != 1) {
            throw new ForbiddenHttpException('アクセスが拒否されました');
        }

        $users = User::find()->all();

        return $this->render('user-list', [
            'users' => $users,
        ]);
    }

    public function actionForget()
    {
        $token = Yii::$app->security->generateRandomString(32);

        $model = new DynamicModel(['mail', 'token']);
        $model->addRule(['mail'], 'email');
        $model->addRule(['mail'], 'required');
        $model->addRule(['token'], 'string');

        $submittedMail = null;
        $submittedToken = null;

        if (Yii::$app->request->isPost) {
            $model->load(Yii::$app->request->post());
            $submittedMail = $model->mail;
            $submittedToken = $model->token;

            // メールアドレスを持つユーザーを特定
            $user = User::findOne(['mail' => $submittedMail]);

            if ($user) {
                // トークンを更新
                $user->token = $submittedToken;
                if ($user->save(false)) {
                    // 再検索して全カラムの値を取得
                    $user = User::findOne(['mail' => $submittedMail]);
                    $allAttributes = $user->attributes;
                    $userToken = $allAttributes['token'];

                    // メール送信
                    $resetLink = Yii::$app->urlManager->createAbsoluteUrl(['user/reset', 'token' => $userToken]);
                    Yii::$app->mailer->compose()
                        ->setTo($submittedMail)
                        ->setFrom([Yii::$app->params['adminEmail'] => Yii::$app->name])
                        ->setSubject('パスワードリセット')
                        ->setTextBody("以下のリンクをクリックしてパスワードをリセットしてください: $resetLink")
                        ->send();

                    Yii::$app->session->setFlash('success', '有効なメールアドレスです。トークンが更新されました。パスワードリセットのリンクをメールで送信しました。');
                } else {
                    Yii::$app->session->setFlash('error', 'トークンの更新に失敗しました。');
                }
            } else {
                Yii::$app->session->setFlash('error', '無効なメールアドレスです');
            }
        }

        return $this->render('user-forget', [
            'model' => $model,
            'token' => $token,
            'submittedMail' => $submittedMail,
            'submittedToken' => $submittedToken,
        ]);
    }

    // 追加アクション
    public function actionReset($token)
    {
        $user = User::findOne(['token' => $token]);

        if (!$user) {
            throw new \yii\web\NotFoundHttpException('不正なパスワードリセットトークンです。');
        }

        $mail = $user->mail;

        $model = new DynamicModel(['password']);
        $model->addRule(['password'], 'required');
        $model->addRule(['password'], 'string', ['min' => 6]);

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $user->setPassword($model->password);
            $user->token = null; // トークンを無効化
            if ($user->save(false)) {
                Yii::$app->session->setFlash('success', 'パスワードが正常にリセットされました。');
                return $this->redirect(['user/login']);
            } else {
                Yii::$app->session->setFlash('error', 'パスワードのリセットに失敗しました。');
            }
        }

        return $this->render('user-reset', [
            'model' => $model,
            'mail' => $mail,
            'token' => $token,
        ]);
    }
}
