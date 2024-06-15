<?php
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

$this->title = 'ユーザー情報編集';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-edit">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>以下のフィールドに入力して編集してください:</p>

    <?php $form = ActiveForm::begin(['id' => 'edit-form']); ?>

    <?= $form->field($model, 'mail')->textInput(['autofocus' => true]) ?>

    <?= $form->field($model, 'username')->textInput() ?>

    <?= $form->field($model, 'password')->passwordInput(['value' => '']) ?>

    <div class="form-group">
        <?= Html::submitButton('更新', ['class' => 'btn btn-primary', 'name' => 'edit-button']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
