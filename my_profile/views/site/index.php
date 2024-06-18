<?php

/** @var yii\web\View $this */

use yii\helpers\Html;
use yii\helpers\Url;
use app\models\Profile;

$this->title = 'My Profile';
$userId = Yii::$app->user->id;
$profileExists = !Yii::$app->user->isGuest && Profile::find()->where(['user_id' => $userId])->exists();
?>
<div class="site-index">

    <div class="jumbotron text-center bg-transparent mt-5 mb-5">
        <h1 class="display-4">ダッシュボード</h1>
        <p class="lead">ここであなたのアカウントとプロフィールを管理して下さい</p>
    </div>

    <div class="body-content">
        <?php if (Yii::$app->user->isGuest): ?>
            <div style="float: left; padding: 5px;">
                <?= Html::a('アカウントを登録する', Url::to(['user/regist']), ['class' => 'btn btn-primary btn-lg']) ?>
            </div>
            <div style="float: left; padding: 5px;">
                <?= Html::a('ログインする', Url::to(['user/login']), ['class' => 'btn btn-primary btn-lg']) ?>
            </div>
        <?php else: ?>
            <div style="float: left; padding: 5px;">
                <?= Html::a('アカウント確認・編集', Url::to(['user/edit', 'id' => $userId]), ['class' => 'btn btn-primary btn-lg']) ?>
            </div>

            <?php if ($profileExists): ?>
                <div style="float: left; padding: 5px;">
                    <?= Html::a('プロフィールを編集する', Url::to(['profile/edit', 'id' => $userId]), ['class' => 'btn btn-primary btn-lg']) ?>
                </div>
                <div style="float: left; padding: 5px;">
                    <?= Html::a('プロフィールを確認・シェアする', Url::to(['profile/view', 'id' => $userId]), ['class' => 'btn btn-primary btn-lg']) ?>
                </div>
            <?php else: ?>
                <div style="float: left; padding: 5px;">
                    <?= Html::a('プロフィールを登録する', Url::to(['profile/regist']), ['class' => 'btn btn-primary btn-lg']) ?>
                </div>
            <?php endif; ?>

            <?php if (Yii::$app->user->identity->role == 1): ?>
                <div style="float: left; padding: 5px;">
                    <?= Html::a('管理画面を表示', Url::to(['admin/index']), ['class' => 'btn btn-danger btn-lg']) ?>
                </div>
            <?php endif; ?>
        <?php endif; ?>
        <div style="clear: both;"></div>
    </div>
</div>
