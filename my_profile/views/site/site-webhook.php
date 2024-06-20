<?php
use yii\db\mssql\PDO;

// PayPalからのPOSTデータを取得
$raw_post_data = file_get_contents('php://input');
$decoded_data = json_decode($raw_post_data, true);

// PayPalからのデータを確認
if (isset($decoded_data['resource'])) {
    // 必要な情報を取得（例：ユーザーID、トランザクションIDなど）
    $user_id = $decoded_data['resource']['custom_id']; // 事前に設定したカスタムフィールドから取得
    $transaction_id = $decoded_data['resource']['id']; // PayPalのトランザクションID
    $payment_status = $decoded_data['resource']['status']; // 支払いステータス

    // データベースに保存または更新
    // PDOを使った例
    $dsn = 'mysql:host=localhost;dbname=myprofile_apps';
    $username = 'myprofile_apps';
    $password = 'EWbJDASwRBU28B8W3QpW';

    try {
        $dbh = new PDO($dsn, $username, $password);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $dbh->prepare("UPDATE user SET transaction_id = :transaction_id, payment_status = :payment_status WHERE user_id = :user_id");
        $stmt->bindParam(':transaction_id', $transaction_id);
        $stmt->bindParam(':payment_status', $payment_status);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
    } catch (PDOException $e) {
        echo 'Connection failed: ' . $e->getMessage();
    }
} else {
    // エラーログなどを記録しておく
    error_log('Invalid PayPal Webhook Data');
}
?>