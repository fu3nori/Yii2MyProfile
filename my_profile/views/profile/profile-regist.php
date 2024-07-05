<?php

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\ProfileForm $model */

$this->title = 'プロフィール登録';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="profile-regist">
    <h1><?= Html::encode($this->title) ?></h1>
    <br>
    <p><b>利用方法</b><br>
        <b>サービス名</b>にはあなたのwebサイトの名前やあなたが使っているwebサービスやSNSの名前(Twitter、Pixiv、ニコニコ動画、Facebook、Linkedin、Youtubeチャンネル名、インスタグラム。PSNフレンドコード、ニンテンドーアカウント)、或いはアプリの名前などを入れて下さい。<br><br>
        <b>サービスURL・コード</b>にはサービス名で指定したあなたのwebサイトのURL(https://foovar.com)やwebサービスやSNSのあなたのURL(例 https://x.com/foovar、https://www.pixiv.net/users/******)、アプリのフレンドコード(例 idf123456)などを入力して下さい。<br>
        URL形式の文字列は自動的にリンクが貼られます
    </p>
    <br>
    <div class="profile-form">

        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

        <?= $form->field($model, 'self_introduction')->textarea(['rows' => 6]) ?>

        <?= $form->field($model, 'service1')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'service1_url')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'service2')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'service2_url')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'service3')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'service3_url')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'service4')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'service4_url')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'service5')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'service5_url')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'service6')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'service6_url')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'service7')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'service7_url')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'service8')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'service8_url')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'service9')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'service9_url')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'service10')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'service10_url')->textInput(['maxlength' => true]) ?>
        <!-- ファイルアップロード -->

        <?php if (Yii::$app->user->identity->role == 3): ?>

            <?= $form->field($model, 'img_url1')->fileInput() ?>
            <?= $form->field($model, 'img_url2')->fileInput() ?>
            <?= $form->field($model, 'img_url3')->fileInput() ?>
            <?= $form->field($model, 'img_url4')->fileInput() ?>
            <?= $form->field($model, 'img_url5')->fileInput() ?>
        <?php endif; ?>

        <!-- ここまで-->
        <div class="form-group">
            <?= Html::submitButton('登録', ['class' => 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>
