<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var string $token */
/** @var yii\base\DynamicModel $model */
/** @var string $submittedMail */
/** @var string $submittedToken */

$this->title = 'パスワード忘れ';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-forget">
    <h1><?= Html::encode($this->title) ?></h1>


    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'mail')->textInput(['maxlength' => true])->label('メールアドレス') ?>
    <?= Html::hiddenInput('DynamicModel[token]', $token) ?>

    <div class="form-group">
        <?= Html::submitButton('送信', ['class' => 'btn btn-primary']) ?>
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
