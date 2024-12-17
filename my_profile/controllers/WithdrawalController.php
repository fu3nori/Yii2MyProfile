<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use app\models\User;
use app\models\Profile;

class WithdrawalController extends Controller
{
    public function actionIndex($id)
    {
        $currentUserId = Yii::$app->user->id;

        if ($currentUserId != $id) {
            throw new ForbiddenHttpException('他のユーザーの退会処理を行うことはできません。');
        }

        if (Yii::$app->request->isPost) {
            // プロフィールの削除
            $profile = Profile::findOne(['user_id' => $id]);
            if ($profile) {
                $profile->delete();
            }

            // ユーザーの削除
            $user = User::findOne($id);
            if ($user) {
                $user->delete();
            }

            // ログアウトしてホームページにリダイレクト
            Yii::$app->user->logout();
            return $this->redirect(['site/index']);
        }

        return $this->render('withdrawal-index', [
            'id' => $id,
        ]);
    }
}
