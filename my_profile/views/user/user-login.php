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
    Googleアカウントでサインイン<br>
    <?php
    $authAuthChoice = AuthChoice::begin([
        'baseAuthUrl' => ['user/auth'],
    ]);
    foreach ($authAuthChoice->getClients() as $client) {
        $authLink = $authAuthChoice->createClientUrl($client);
        echo Html::a(
            Html::img('@web/icons/sign_in_google.png', [
                'alt' => 'Sign in with Google',
                'class' => 'auth-client-img'
            ]),
            $authLink,
            ['class' => 'auth-client-link']
        );
    }
    AuthChoice::end();
    ?>
    <br>
    <a href="<?= Url::to(['user/twitter']) ?>" class="btn btn-info">Twitterでログイン</a>
    <br>
    <p><a href="../user/forget">パスワードを忘れた方はこちら</a></p>
</div>
