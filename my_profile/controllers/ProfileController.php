<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use app\models\Profile;
use app\models\User;
use app\models\ProfileForm;

class ProfileController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::class,
                'only' => ['regist', 'edit'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
                'denyCallback' => function ($rule, $action) {
                    return Yii::$app->response->redirect(['user/login']);
                },
            ],
        ];
    }

    public function actionRegist()
    {
        $userId = Yii::$app->user->id;

        // Check if the profile already exists
        if (Profile::find()->where(['user_id' => $userId])->exists()) {
            throw new ForbiddenHttpException('プロフィールは既に登録されています。');
        }

        $model = new ProfileForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $profile = new Profile();
            $profile->attributes = $model->attributes;
            $profile->user_id = $userId;
            if ($profile->save()) {
                return $this->redirect(['profile/view', 'id' => $userId]);
            }
        }

        return $this->render('profile-regist', ['model' => $model]);
    }

    public function actionEdit($id)
    {
        $userId = Yii::$app->user->id;
        $profile = Profile::findOne(['user_id' => $id]);

        if (!$profile) {
            throw new NotFoundHttpException('プロフィールが見つかりません');
        }

        if ($profile->user_id !== $userId) {
            throw new ForbiddenHttpException('他のユーザーのプロフィールを編集することはできません。');
        }

        $model = new ProfileForm();
        $model->attributes = $profile->attributes;

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $profile->attributes = $model->attributes;
            if ($profile->save()) {
                return $this->redirect(['profile/view', 'id' => $userId]);
            }
        }

        return $this->render('profile-edit', ['model' => $model]);
    }

    public function actionView($id)
    {
        $profile = Profile::findOne(['user_id' => $id]);
        if ($profile === null) {
            throw new NotFoundHttpException("Profile not found.");
        }

        $user = User::findOne($id);
        if ($user === null) {
            throw new NotFoundHttpException("User not found.");
        }

        return $this->render('profile-view', [
            'profile' => $profile,
            'user' => $user,
        ]);
    }


}
