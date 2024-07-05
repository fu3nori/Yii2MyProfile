<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ProfileForm */
/* @var $form yii\widgets\ActiveForm */
/* @var $profile app\models\Profile */

$this->title = 'プロフィール編集';
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="profile-form">
    <p><b>利用方法</b><br>
        <b>サービス名</b>にはあなたのwebサイトの名前やあなたが使っているwebサービスやSNSの名前(Twitter、Pixiv、ニコニコ動画、Facebook、Linkedin、Youtubeチャンネル名、インスタグラム。PSNフレンドコード、ニンテンドーアカウント)、或いはアプリの名前などを入れて下さい。<br><br>
        <b>サービスURL・コード</b>にはサービス名で指定したあなたのwebサイトのURL(https://foovar.com)やwebサービスやSNSのあなたのURL(例 https://x.com/foovar、https://www.pixiv.net/users/******)、アプリのフレンドコード(例 idf123456)などを入力して下さい。<br>
        URL形式の文字列は自動的にリンクが貼られます
    </p>
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'self_introduction')->textarea(['rows' => 6]) ?>

    <?php for ($i = 1; $i <= 10; $i++): ?>
        <?= $form->field($model, "service{$i}")->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, "service{$i}_url")->textInput(['maxlength' => true]) ?>
    <?php endfor; ?>

    <?php for ($i = 1; $i <= 5; $i++): ?>
        <?php if ($profile["img_url{$i}"]): ?>
            <div class="form-group">
                <label class="control-label">既存の画像 <?= $i ?></label>
                <img src="<?= $profile["img_url{$i}"] ?>" alt="Image <?= $i ?>" style="max-width: 300px;">
                <?= Html::a('削除', ['profile/delete-image', 'id' => $profile->user_id, 'imgNumber' => $i], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => '本当にこの画像を削除しますか？',
                        'method' => 'post',
                    ],
                ]) ?>
            </div>
        <?php else: ?>
            <?= $form->field($model, "img_url{$i}")->fileInput() ?>
        <?php endif; ?>
    <?php endfor; ?>

    <div class="form-group">
        <?= Html::submitButton('保存', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
