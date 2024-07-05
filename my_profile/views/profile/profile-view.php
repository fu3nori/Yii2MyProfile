<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Profile $profile */
/** @var app\models\User $user */

$this->title = 'プロフィール';
$this->params['breadcrumbs'][] = $this->title;

$profileUrl = Yii::$app->urlManager->createAbsoluteUrl(['profile/view', 'id' => $profile->user_id]);
$domain = Yii::$app->request->hostInfo; // ドメイン名を取得
?>

<div class="profile-view container">
    <h1 class="display-5"><?= Html::encode($this->title) ?></h1>
    <div class="heading-underline mb-4"></div>

    <div class="row">
        <div class="col-12">
            <p>URL: <?= Html::a($profileUrl, $profileUrl) ?></p>
            <?= Html::button('URLをコピーする', ['class' => 'btn btn-primary', 'onclick' => 'copyToClipboard("'.$profileUrl.'")']) ?>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-12 text-right">
            <p>QRコードでシェア</p>
            <img src="data:image/png;base64, <?= $qrCode ?>" alt="QR Code" class="img-fluid">
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-12">
            <p>プロフィールをシェアする:</p>
            <a href="https://twitter.com/intent/tweet?url=<?= urlencode($profileUrl) ?>&text=<?= urlencode('これが私のプロフィールです') ?>" class="btn btn-black text-white twitter-share" target="_blank">
                X(Twitterでシェア)
            </a>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-12">
            <h2 class="display-6">ユーザー名</h2>
            <div class="heading-underline mb-3"></div>
            <p><?= Html::encode($user->username) ?></p>
        </div>
    </div>

    <?php if ($profile->thum_url1 || $profile->thum_url2 || $profile->thum_url3 || $profile->thum_url4 || $profile->thum_url5): ?>
        <div class="row mt-3">
            <div class="col-12">
                <h2 class="display-6">ポートフォリオ・画像</h2>
                <div class="heading-underline mb-3"></div>
            </div>
            <?php for ($i = 1; $i <= 5; $i++): ?>
                <?php
                $thumbnail = $profile->{"thum_url{$i}"};
                $original = $profile->{"img_url{$i}"};
                ?>
                <?php if ($thumbnail && $original): ?>
                    <div class="col-6 col-md-4 col-lg-3 mt-2">
                        <a href="<?= $domain . $original ?>" target="_blank">
                            <img src="<?= $domain . $thumbnail ?>" alt="Thumbnail <?= $i ?>" class="img-fluid">
                        </a>
                    </div>
                <?php endif; ?>
            <?php endfor; ?>
        </div>
    <?php endif; ?>

    <div class="row mt-3">
        <div class="col-12">
            <h2 class="display-6">自己紹介文</h2>
            <div class="heading-underline mb-3"></div>
            <p><?= nl2br(Html::encode($profile->self_introduction)) ?></p>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-12">
            <h2 class="display-6">サービス</h2>
            <div class="heading-underline mb-3"></div>
            <table class="table table-responsive">
                <thead>
                <tr>
                    <th>サービス名</th>
                    <th>サービスURL・コード</th>
                    <th>アクション</th>
                </tr>
                </thead>
                <tbody>
                <?php for ($i = 1; $i <= 10; $i++): ?>
                    <?php
                    $service = $profile["service{$i}"];
                    $url = $profile["service{$i}_url"];
                    if (!empty($service) && !empty($url)):
                        $isLink = preg_match('/^https?:\/\//', $url);
                        $displayUrl = (strlen($url) > 30) ? substr($url, 0, 29) . '...' : $url;
                        ?>
                        <tr>
                            <td><?= Html::encode($service) ?></td>
                            <td>
                                <?php if ($isLink): ?>
                                    <?= Html::a(Html::encode($displayUrl), $url, ['target' => '_blank', 'title' => Html::encode($url)]) ?>
                                <?php else: ?>
                                    <?= Html::encode($displayUrl) ?>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?= Html::button('クリップボードにコピー', ['class' => 'btn btn-secondary btn-sm', 'onclick' => 'copyToClipboard("'.$url.'")']) ?>
                            </td>
                        </tr>
                    <?php endif; ?>
                <?php endfor; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    function copyToClipboard(text) {
        navigator.clipboard.writeText(text).then(() => {
            alert('クリップボードにコピーしました: ' + text);
        });
    }
</script>

<style>
    .btn-black {
        background-color: #000;
        color: #fff;
    }
    .btn-black:hover {
        background-color: #444;
        color: #fff;
    }
    .display-5 {
        font-size: 2.5rem;
    }
    .display-6 {
        font-size: 2rem;
    }
    .heading-underline {
        border-bottom: 2px solid #007BFF;
        width: 50px;
    }
    .twitter-share {
        background-color: #1da1f2;
        color: white;
    }
    .twitter-share:hover {
        background-color: #0d8ddb;
        color: white;
    }
</style>
