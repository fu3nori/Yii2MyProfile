<?php

namespace app\components;

use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;
use yii\helpers\Json;

/**
 * PaypalComponent handles PayPal API interactions.
 */
class PaypalComponent extends Component
{
    /**
     * @var string PayPal client ID
     */
    public $clientId;

    /**
     * @var string PayPal client secret
     */
    public $clientSecret;

    /**
     * @var bool Whether to use sandbox environment
     */
    public $sandbox = true;

    /**
     * @var string PayPal API base URL
     */
    private $_apiBaseUrl;

    /**
     * @var string PayPal access token
     */
    private $_accessToken;

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        if (empty($this->clientId)) {
            throw new InvalidConfigException('PayPal client ID must be set.');
        }

        if (empty($this->clientSecret)) {
            throw new InvalidConfigException('PayPal client secret must be set.');
        }

        $this->_apiBaseUrl = $this->sandbox
            ? 'https://api-m.sandbox.paypal.com'
            : 'https://api-m.paypal.com';
    }

    /**
     * Get PayPal access token
     * 
     * @return string Access token
     */
    public function getAccessToken()
    {
        if ($this->_accessToken === null) {
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, $this->_apiBaseUrl . '/v1/oauth2/token');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, 'grant_type=client_credentials');
            curl_setopt($ch, CURLOPT_USERPWD, $this->clientId . ':' . $this->clientSecret);

            $headers = array();
            $headers[] = 'Accept: application/json';
            $headers[] = 'Accept-Language: en_US';
            $headers[] = 'Content-Type: application/x-www-form-urlencoded';
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            $result = curl_exec($ch);
            if (curl_errno($ch)) {
                throw new \Exception('Error:' . curl_error($ch));
            }
            curl_close($ch);

            $response = Json::decode($result);
            $this->_accessToken = $response['access_token'];
        }

        return $this->_accessToken;
    }

    /**
     * Verify PayPal webhook signature
     * 
     * @param string $requestBody The raw request body
     * @param array $headers The request headers
     * @return bool Whether the webhook signature is valid
     */
    public function verifyWebhookSignature($requestBody, $headers)
    {
        $webhookId = Yii::$app->params['paypalWebhookId'] ?? '';
        if (empty($webhookId)) {
            Yii::error('PayPal webhook ID is not configured');
            return false;
        }

        $accessToken = $this->getAccessToken();

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $this->_apiBaseUrl . '/v1/notifications/verify-webhook-signature');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);

        $data = [
            'auth_algo' => $headers['PAYPAL-AUTH-ALGO'] ?? '',
            'cert_url' => $headers['PAYPAL-CERT-URL'] ?? '',
            'transmission_id' => $headers['PAYPAL-TRANSMISSION-ID'] ?? '',
            'transmission_sig' => $headers['PAYPAL-TRANSMISSION-SIG'] ?? '',
            'transmission_time' => $headers['PAYPAL-TRANSMISSION-TIME'] ?? '',
            'webhook_id' => $webhookId,
            'webhook_event' => Json::decode($requestBody)
        ];

        curl_setopt($ch, CURLOPT_POSTFIELDS, Json::encode($data));

        $headers = array();
        $headers[] = 'Content-Type: application/json';
        $headers[] = 'Authorization: Bearer ' . $accessToken;
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            Yii::error('Error verifying webhook signature: ' . curl_error($ch));
            return false;
        }
        curl_close($ch);

        $response = Json::decode($result);
        return isset($response['verification_status']) && $response['verification_status'] === 'SUCCESS';
    }

    /**
     * Process a PayPal payment
     * 
     * @param string $paymentId The PayPal payment ID
     * @param string $payerId The PayPal payer ID
     * @return array The payment execution response
     */
    public function executePayment($paymentId, $payerId)
    {
        $accessToken = $this->getAccessToken();

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $this->_apiBaseUrl . '/v1/payments/payment/' . $paymentId . '/execute');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, Json::encode(['payer_id' => $payerId]));

        $headers = array();
        $headers[] = 'Content-Type: application/json';
        $headers[] = 'Authorization: Bearer ' . $accessToken;
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            throw new \Exception('Error executing payment: ' . curl_error($ch));
        }
        curl_close($ch);

        return Json::decode($result);
    }
}