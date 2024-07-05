<?php

/** @var yii\web\View $this */

use yii\helpers\Html;
use yii\helpers\Url;
use app\models\Profile;
use yii\db\mssql\PDO;

$this->title = 'My Profile';
$userId = Yii::$app->user->id;
$profileExists = !Yii::$app->user->isGuest && Profile::find()->where(['user_id' => $userId])->exists();
?>

<?php
// PayPalのリダイレクトから戻った場合の処理
if (isset($_GET['paymentId']) && isset($_GET['PayerID'])) {
    // ユーザーIDを取得
    $userId = Yii::$app->user->id;
    $user_id = $userId;

    // データベースを更新
    // config/db.phpから設定を取得
    $db = Yii::$app->db;
    $dsn = $db->dsn;
    $username = $db->username;
    $password = $db->password;

    try {
        $dbh = new PDO($dsn, $username, $password);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $dbh->prepare("UPDATE user SET role = '3' WHERE id = :user_id");
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
    } catch (PDOException $e) {
        echo 'Connection failed: ' . $e->getMessage();
    }
}
?>

<div class="site-index">

    <div class="jumbotron text-center bg-transparent mt-5 mb-5">
        <h1 class="display-4">ダッシュボード</h1>
        <div class="heading-underline mb-4 mx-auto"></div>
        <p class="lead">ここであなたのアカウントとプロフィールを管理して下さい</p>
    </div>

    <div class="body-content">
        <?php if (Yii::$app->user->isGuest): ?>
            <div class="d-inline-block m-2">
                <?= Html::a('アカウントを登録する', Url::to(['user/regist']), ['class' => 'btn btn-primary btn-lg']) ?>
            </div>
            <div class="d-inline-block m-2">
                <?= Html::a('ログインする', Url::to(['user/login']), ['class' => 'btn btn-primary btn-lg']) ?>
            </div>
        <?php else: ?>
            <div class="d-inline-block m-2">
                <?= Html::a('アカウント確認・編集', Url::to(['user/edit', 'id' => $userId]), ['class' => 'btn btn-primary btn-lg']) ?>
            </div>

            <?php if ($profileExists): ?>
                <div class="d-inline-block m-2">
                    <?= Html::a('プロフィールを編集する', Url::to(['profile/edit', 'id' => $userId]), ['class' => 'btn btn-primary btn-lg']) ?>
                </div>
                <div class="d-inline-block m-2">
                    <?= Html::a('プロフィールを確認・シェアする', Url::to(['profile/view', 'id' => $userId]), ['class' => 'btn btn-primary btn-lg']) ?>
                </div>
            <?php else: ?>
                <div class="d-inline-block m-2">
                    <?= Html::a('プロフィールを登録する', Url::to(['profile/regist']), ['class' => 'btn btn-primary btn-lg']) ?>
                </div>
            <?php endif; ?>

            <?php if (Yii::$app->user->identity->role == 1): ?>
                <div class="d-inline-block m-2">
                    <?= Html::a('管理画面を表示', Url::to(['admin/index']), ['class' => 'btn btn-danger btn-lg']) ?>
                </div>
            <?php endif; ?>
            <?php if (Yii::$app->user->identity->role != 1): ?>
                <div class="d-inline-block m-2">
                    <?= Html::a('退会する', Url::to(['withdrawal/index', 'id' => $userId]), ['class' => 'btn btn-danger btn-lg']) ?>
                </div>
            <?php endif; ?>
        <?php endif; ?>
        <div style="clear: both;"></div>

        <br><br><br><br>
        <?php if ($userId && Yii::$app->user->identity->role != 1 && Yii::$app->user->identity->role != 3): ?>
            <div id="paypal">
                <p>Donationして永久有効の画像ポートフォリオのアップロード権を手に入れませんか？(最大5枚)</p>
                <div id="paypal-button-container"></div>
                <?php $userId = Yii::$app->user->id; ?>
                <script>
                    paypal.Buttons({
                        createOrder: function(data, actions) {
                            return actions.order.create({
                                purchase_units: [{
                                    amount: {
                                        value: '1500', // 支払い金額（日本円）
                                        currency_code: 'JPY' // 通貨コードをJPYに設定
                                    },
                                    custom_id: '<?php echo $userId; ?>' // ユーザーIDを取得
                                }]
                            });
                        },
                        onApprove: function(data, actions) {
                            return actions.order.capture().then(function(details) {
                                // 支払い完了後の処理
                                window.location.href = "https://my-profile.biz/web/site/index/?paymentId=" + data.orderID + "&PayerID=" + data.payerID;
                            });
                        }
                    }).render('#paypal-button-container');
                </script>
            </div>
        <?php endif; ?>
    </div>
</div>

<style>
    .display-4 {
        font-size: 2.5rem;
    }
    .heading-underline {
        border-bottom: 2px solid #007BFF;
        width: 50px;
    }
</style>
