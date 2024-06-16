<?php

/** @var yii\web\View $this */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'My Profile';
?>
<div class="site-index">

    <div class="jumbotron text-center bg-transparent mt-5 mb-5">
        <h1 class="display-4">ダッシュボード</h1>

        <p class="lead">ここであなたのアカウントとプロフィールを管理して下さい</p>

    </div>

    <div class="body-content">
        <?php if (!Yii::$app->user->isGuest): ?>
            <div class="text-center mt-4">
                <?= Html::a('アカウント確認・編集', Url::to(['user/edit', 'id' => Yii::$app->user->id]), ['class' => 'btn btn-primary btn-lg']) ?>
            </div>
        <?php endif; ?>
    </div>
</div>
