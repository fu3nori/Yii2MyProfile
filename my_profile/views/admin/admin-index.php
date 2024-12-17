<?php

use yii\helpers\Html;
use yii\widgets\LinkPager;

/** @var yii\web\View $this */
/** @var yii\data\Pagination $pages */
/** @var app\models\User[] $users */

$this->title = 'ユーザー管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="admin-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <table class="table table-bordered">
        <thead>
        <tr>
            <th>ID</th>
            <th>メールアドレス</th>
            <th>ユーザー名</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($users as $user): ?>
            <tr>
                <td><?= Html::encode($user->id) ?></td>
                <td><?= Html::encode($user->mail) ?></td>
                <td><?= Html::encode($user->username) ?></td>
                <td>
                    <?= Html::a('ユーザーチェック', ['admin/check', 'id' => $user->id], ['class' => 'btn btn-primary']) ?>
                    <?= Html::a('ユーザー削除', ['admin/delete', 'id' => $user->id], [
                        'class' => 'btn btn-danger',
                        'data' => [
                            'confirm' => 'このユーザーを削除してもよろしいですか？',
                            'method' => 'post',
                        ],
                    ]) ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <?= LinkPager::widget([
        'pagination' => $pages,
    ]) ?>
</div>
