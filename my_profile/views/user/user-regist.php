<?php
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

$this->title = 'ユーザー登録';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-regist">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>以下のフィールドに入力して登録してください:</p>

    <?php $form = ActiveForm::begin(['id' => 'regist-form']); ?>

    <?= $form->field($model, 'mail')->textInput(['autofocus' => true]) ?>

    <?= $form->field($model, 'username')->textInput() ?>

    <?= $form->field($model, 'password')->passwordInput() ?>

    <div class="form-group">
        <?= Html::submitButton('登録', ['class' => 'btn btn-primary', 'name' => 'regist-button']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
