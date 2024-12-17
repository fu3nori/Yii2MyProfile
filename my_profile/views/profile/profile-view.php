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
            <?= Html::button('URLをコピーする', ['class' => 'btn btn-primary', 'onclick' => "copyToClipboard(\"$profileUrl\")"]) ?>
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
            <!-- twitter -->
            <a href="https://twitter.com/intent/tweet?url=<?= urlencode($profileUrl) ?>&text=<?= urlencode('これが私のプロフィールです') ?>" class="btn btn-black text-white twitter-share" target="_blank">
                X(Twitterでシェア)
            </a><br>
            <!-- ここまで -->
            <!-- facebook -->
            <br>
            <div id="fb-root"></div>
            <script async defer crossorigin="anonymous" src="https://connect.facebook.net/ja_JP/sdk.js#xfbml=1&version=v20.0" nonce="ClZ293sE"></script>
            <div class="fb-share-button" data-href="" data-layout="button" data-size="large"><a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode($profileUrl) ?>;src=sdkpreparse" class="fb-xfbml-parse-ignore">シェアする</a></div>
            <!-- ここまで-->
            <br> <br>
            <!-- LINE -->
            <button class="btn-line" onclick="shareToLine()">LINEでシェア</button>

        </div>
            <!-- ここまで -->
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-12">
            <h2 class="display-6">ユーザー名</h2>
            <div class="heading-underline mb-3"></div>
            <p><?= Html::encode($user->username) ?></p>
        </div>
    </div>



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
                        <tr class="d-none d-md-table-row">
                            <td><?= Html::encode($service) ?></td>
                            <td>
                                <?php if ($isLink): ?>
                                    <?= Html::a(Html::encode($displayUrl), $url, ['target' => '_blank', 'title' => Html::encode($url)]) ?><br>
                                    <?= Html::button('クリップボードにコピー', ['class' => 'btn btn-secondary btn-sm mt-1', 'onclick' => "copyToClipboard(\"$url\")"]) ?>
                                <?php else: ?>
                                    <?= Html::encode($displayUrl) ?><br>
                                    <?= Html::button('クリップボードにコピー', ['class' => 'btn btn-secondary btn-sm mt-1', 'onclick' => "copyToClipboard(\"$url\")"]) ?>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <tr class="d-md-none">
                            <td colspan="2">
                                <strong><?= Html::encode($service) ?></strong><br>
                                <?php if ($isLink): ?>
                                    <?= Html::a(Html::encode($displayUrl), $url, ['target' => '_blank', 'title' => Html::encode($url)]) ?><br>
                                    <?= Html::button('クリップボードにコピー', ['class' => 'btn btn-secondary btn-sm mt-1', 'onclick' => "copyToClipboard(\"$url\")"]) ?>
                                <?php else: ?>
                                    <?= Html::encode($displayUrl) ?><br>
                                    <?= Html::button('クリップボードにコピー', ['class' => 'btn btn-secondary btn-sm mt-1', 'onclick' => "copyToClipboard(\"$url\")"]) ?>
                                <?php endif; ?>
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

    function shareToLine() {
        var url = "<?= $profileUrl ?>";
        var text = "私のプロフィールはこちら " + url;
        var lineUrl = 'https://line.me/R/msg/text/?' + encodeURIComponent(text);
        window.open(lineUrl, '_blank');
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
    .btn-line {
        background-color: #00B900;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }
    .btn-line:hover {
        background-color: #009900;
    }
    @media (max-width: 767.98px) {
        .d-md-table-row {
            display: none;
        }
    }
    @media (min-width: 768px) {
        .d-md-none {
            display: none;
        }
    }
</style>