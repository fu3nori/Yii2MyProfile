<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use app\models\User;
use app\models\Profile;
use yii\data\Pagination;

class AdminController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::class,
                'only' => ['index', 'check', 'delete'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            return Yii::$app->user->identity->role == 1;
                        },
                    ],
                ],
                'denyCallback' => function ($rule, $action) {
                    throw new ForbiddenHttpException('このページにアクセスする権限がありません。');
                },
            ],
        ];
    }

    public function actionIndex()
    {
        $query = User::find();
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => 50]);
        $users = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();

        return $this->render('admin-index', [
            'users' => $users,
            'pages' => $pages,
        ]);
    }

    public function actionCheck($id)
    {
        $profile = Profile::findOne(['user_id' => $id]);
        $user = User::findOne($id);

        if (!$profile) {
            return $this->render('admin-check', [
                'message' => 'プロフィールが存在しません',
                'user' => $user,
                'profile' => null,
            ]);
        }

        return $this->render('admin-check', [
            'message' => null,
            'user' => $user,
            'profile' => $profile,
        ]);
    }

    public function actionDelete($id)
    {
        $profile = Profile::findOne(['user_id' => $id]);
        if ($profile) {
            $profile->delete();
        }

        $user = User::findOne($id);
        if ($user) {
            $user->delete();
        }

        return $this->redirect(['admin/index']);
    }
}
