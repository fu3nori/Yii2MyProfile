<?php

use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var string $message */
/** @var app\models\User $user */
/** @var app\models\Profile $profile */

$this->title = 'ユーザーチェック';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="admin-check">
    <h1><?= Html::encode($this->title) ?></h1>

    <div style="margin-bottom: 20px;">
        <?= Html::a('戻る', ['admin/index'], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('ユーザー削除', ['admin/delete', 'id' => $user->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'このユーザーを削除してもよろしいですか？',
                'method' => 'post',
            ],
        ]) ?>
    </div>

    <?php if ($message): ?>
        <div class="alert alert-warning">
            <?= Html::encode($message) ?>
        </div>
    <?php else: ?>
        <h2>ユーザー名: <?= Html::encode($user->username) ?></h2>

        <h3>自己紹介文</h3>
        <p><?= nl2br(Html::encode($profile->self_introduction)) ?></p>

        <h3>サービス</h3>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>サービス名</th>
                <th>サービスURL</th>
            </tr>
            </thead>
            <tbody>
            <?php for ($i = 1; $i <= 10; $i++): ?>
                <?php
                $service = $profile["service{$i}"];
                $url = $profile["service{$i}_url"];
                if (!empty($service) && !empty($url)):
                    ?>
                    <tr>
                        <td><?= Html::encode($service) ?></td>
                        <td><?= Html::encode($url) ?></td>
                    </tr>
                <?php endif; ?>
            <?php endfor; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>
