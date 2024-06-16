<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Profile $profile */

$this->title = 'プロフィール';
$this->params['breadcrumbs'][] = $this->title;

$profileUrl = Yii::$app->urlManager->createAbsoluteUrl(['profile/view', 'id' => $profile->user_id]);
?>

<div class="profile-view">
    <h1><?= Html::encode($this->title) ?></h1>

    <div>
        <p>URL: <?= Html::a($profileUrl, $profileUrl) ?></p>
        <?= Html::button('URLをコピーする', ['class' => 'btn btn-primary', 'onclick' => 'copyToClipboard()']) ?>
    </div>

    <div>
        <p>プロフィールをシェアする:</p>
        <a href="https://twitter.com/intent/tweet?url=<?= urlencode($profileUrl) ?>&text=<?= urlencode('これが私のプロフィールです') ?>" class="btn btn-black text-white" target="_blank">
            X(Twitterでシェア)
        </a>
    </div>

    <h2>ユーザー名</h2>
    <p><?= Html::encode(Yii::$app->user->identity->username) ?></p>

    <h2>自己紹介文</h2>
    <p><?= nl2br(Html::encode($profile->self_introduction)) ?></p>

    <h2>サービス</h2>
    <table class="table">
        <thead>
        <tr>
            <th>サービス名</th>
            <th>サービスURL</th>
        </tr>
        </thead>
        <tbody>
        <?php for ($i = 1; $i <= 10; $i++): ?>
            <?php if (!empty($profile["service{$i}"]) && !empty($profile["service{$i}_url"])): ?>
                <tr>
                    <td><?= Html::encode($profile["service{$i}"]) ?></td>
                    <td><?= Html::encode($profile["service{$i}_url"]) ?></td>
                </tr>
            <?php endif; ?>
        <?php endfor; ?>
        </tbody>
    </table>
</div>

<script>
    function copyToClipboard() {
        const text = "<?= $profileUrl ?>";
        navigator.clipboard.writeText(text).then(() => {
            alert('URLをコピーしました');
        });
    }
</script>

<style>
    .btn-black {
        background-color: #000;
        color: #fff;
    }
</style>
