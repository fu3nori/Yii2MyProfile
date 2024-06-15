<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\User;
use app\models\LoginForm;

class UserController extends Controller
{
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        return $this->render('user-login', [
            'model' => $model,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }

    public function actionRegist()
    {
        $model = new User();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->setPassword($model->password);
            $model->role = User::find()->count() === 0 ? 1 : 0; // 最初のユーザーのみ role を 1 にする
            $model->save(false);
            Yii::$app->user->login($model);
            return $this->redirect(['site/index']);
        }

        return $this->render('user-regist', [
            'model' => $model,
        ]);
    }

    public function actionEdit($id)
    {
        $model = User::findOne($id);
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if (!empty($model->password)) {
                $model->setPassword($model->password);
            }
            $model->save(false);
            return $this->redirect(['site/index']);
        }

        return $this->render('user-edit', [
            'model' => $model,
        ]);
    }

    public function actionList()
    {
        if (Yii::$app->user->isGuest || Yii::$app->user->identity->role != 1) {
            throw new \yii\web\ForbiddenHttpException('アクセスが拒否されました');
        }

        $users = User::find()->all();

        return $this->render('user-list', [
            'users' => $users,
        ]);
    }
}
