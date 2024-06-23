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
