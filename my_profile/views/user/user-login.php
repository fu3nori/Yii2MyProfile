<?php
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Url;

$this->title = 'ログイン';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>以下のフィールドに入力してログインしてください:</p>

    <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

    <?= $form->field($model, 'mail')->textInput(['autofocus' => true]) ?>

    <?= $form->field($model, 'password')->passwordInput() ?>

    <?= $form->field($model, 'rememberMe')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton('ログイン', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    <br>
    <a href="<?= Url::to(['user/twitter']) ?>" class="btn btn-info">Twitterでログイン</a>
    <br>
    <p><a href="../user/forget">パスワードを忘れた方はこちら</a></p>
</div>
