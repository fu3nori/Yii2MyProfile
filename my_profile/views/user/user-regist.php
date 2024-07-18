<?php
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Url;

$this->title = 'ユーザー登録';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-regist">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="user-form">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'mail')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'password')->passwordInput() ?>

        <div class="form-group">
            <?= Html::submitButton('登録', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>
        <br>
        <a href="<?= Url::to(['user/twitter']) ?>" class="btn btn-info">Twitterでアカウント作成</a>
        <br>
        Googleアカウントでアカウント作成<br>
        <?php
        $authAuthChoice = AuthChoice::begin([
            'baseAuthUrl' => ['user/auth'],
        ]);
        foreach ($authAuthChoice->getClients() as $client) {
            $authLink = $authAuthChoice->createClientUrl($client);
            echo Html::a(
                Html::img('@web/icons/sign_up_google.png', [
                    'alt' => 'Sign up with Google',
                    'class' => 'auth-client-img'
                ]),
                $authLink,
                ['class' => 'auth-client-link']
            );
        }
        AuthChoice::end();
        ?>
        <br>
    </div>
</div>
