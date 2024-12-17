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
<?php
$userId = Yii::$app->user->id;

if (!$userId) {
    echo '<div class="jumbotron text-center bg-transparent mt-5 mb-5">
        <h1 class="display-4">ログイン＆アカウント取得｜Login & Get Account</h1>
        <div class="heading-underline mb-4 mx-auto"></div>
        <p class="lead">アカウントをお持ちの方はログインを、お持ちでない方はアカウントを取得して下さい<br>If you have an account, please log in, if not, please get an account.</p>
    </div>';
}elseif ("0" === Yii::$app->user->user_language) {
    echo '    <div class="jumbotron text-center bg-transparent mt-5 mb-5">
        <h1 class="display-4">ダッシュボード｜Dashboard</h1>
        <div class="heading-underline mb-4 mx-auto"></div>
        <p class="lead">あなたの使用する言語を【アカウント確認・編集】で設定して下さい｜Please set your preferred language in [Check/Edit Account].</p>
    </div>
';
}else {
    echo '    <div class="jumbotron text-center bg-transparent mt-5 mb-5">
        <h1 class="display-4">ダッシュボード｜Dashboard</h1>
        <div class="heading-underline mb-4 mx-auto"></div>
        <p class="lead">ここであなたのアカウントとプロフィールを管理して下さい｜Manage your account and profile here</p>
    </div>';
}
?>


    <div class="body-content">
        <?php if (Yii::$app->user->isGuest): ?>
            <div class="d-inline-block m-2">
                <?= Html::a('アカウントを登録する｜Register an account ', Url::to(['user/regist']), ['class' => 'btn btn-primary btn-lg']) ?>
            </div>
            <div class="d-inline-block m-2">
                <?= Html::a('ログインする｜Login', Url::to(['user/login']), ['class' => 'btn btn-primary btn-lg']) ?>
            </div>
        <?php else: ?>
            <div class="d-inline-block m-2">
                <?= Html::a('アカウント確認・編集｜Check/Edit Account', Url::to(['user/edit', 'id' => $userId]), ['class' => 'btn btn-primary btn-lg']) ?>
            </div>

            <?php if ($profileExists): ?>
                <div class="d-inline-block m-2">
                    <?= Html::a('プロフィールを編集する｜Edit Profile', Url::to(['profile/edit', 'id' => $userId]), ['class' => 'btn btn-primary btn-lg']) ?>
                </div>
                <div class="d-inline-block m-2">
                    <?= Html::a('プロフィールを確認・シェアする｜View and share your profile', Url::to(['profile/view', 'id' => $userId]), ['class' => 'btn btn-primary btn-lg']) ?>
                </div>
            <?php else: ?>
                <div class="d-inline-block m-2">
                    <?= Html::a('プロフィールを登録する｜Register a profile', Url::to(['profile/regist']), ['class' => 'btn btn-primary btn-lg']) ?>
                </div>
            <?php endif; ?>

            <?php if (Yii::$app->user->identity->role == 1): ?>
                <div class="d-inline-block m-2">
                    <?= Html::a('管理画面を表示', Url::to(['admin/index']), ['class' => 'btn btn-danger btn-lg']) ?>
                </div>
            <?php endif; ?>
            <?php if (Yii::$app->user->identity->role != 1): ?>
                <div class="d-inline-block m-2">
                    <?= Html::a('退会する｜Delete Account', Url::to(['withdrawal/index', 'id' => $userId]), ['class' => 'btn btn-danger btn-lg']) ?>
                </div>
            <?php endif; ?>
        <?php endif; ?>
        <div style="clear: both;"></div>



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
