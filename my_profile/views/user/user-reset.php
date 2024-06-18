<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var yii\base\DynamicModel $model */
/** @var string $mail */
/** @var string $token */

$this->title = 'パスワードリセット';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-reset">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>新しいパスワードを入力してください。</p>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'password')->passwordInput(['maxlength' => true])->label('新しいパスワード') ?>

    <div class="form-group">
        <?= Html::submitButton('リセット', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    <?php if (Yii::$app->session->hasFlash('success')): ?>
        <div class="alert alert-success">
            <?= Yii::$app->session->getFlash('success') ?>
        </div>
    <?php endif; ?>

    <?php if (Yii::$app->session->hasFlash('error')): ?>
        <div class="alert alert-danger">
            <?= Yii::$app->session->getFlash('error') ?>
        </div>
    <?php endif; ?>
</div>
