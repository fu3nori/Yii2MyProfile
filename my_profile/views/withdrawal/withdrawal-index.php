<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var int $id */

$this->title = '退会処理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="withdrawal-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>退会するとあなたのアカウントとプロフィールは全て削除されます。</p>

    <?php $form = ActiveForm::begin(['id' => 'withdrawal-form']); ?>

    <div class="form-group">
        <?= Html::submitButton('退会する', ['class' => 'btn btn-danger']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
