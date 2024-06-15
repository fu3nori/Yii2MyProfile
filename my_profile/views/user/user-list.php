<?php
use yii\helpers\Html;

$this->title = 'ユーザー一覧';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-list">
    <h1><?= Html::encode($this->title) ?></h1>

    <table class="table table-striped">
        <thead>
        <tr>
            <th>ID</th>
            <th>メールアドレス</th>
            <th>ニックネーム</th>
            <th>登録日</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($users as $user): ?>
            <tr>
                <td><?= Html::encode($user->id) ?></td>
                <td><?= Html::encode($user->mail) ?></td>
                <td><?= Html::encode($user->username) ?></td>
                <td><?= Html::encode($user->created) ?></td>
                <td><?= Html::a('編集', ['user/edit', 'id' => $user->id], ['class' => 'btn btn-primary']) ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
