<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use app\models\Profile;
use app\models\User;
use app\models\ProfileForm;
use Endroid\QrCode\Builder\Builder;
use yii\web\UploadedFile;
use yii\imagine\Image;
use Imagine\Image\Box;

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

            // ファイルアップロード処理
            $this->handleFileUpload($model, $profile);

            if ($profile->save(false)) {
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

        // 既存のサムネイル URL をモデルに代入
        for ($i = 1; $i <= 5; $i++) {
            $thumbnailAttribute = "thum_url{$i}";
            $model->$thumbnailAttribute = $profile->$thumbnailAttribute;
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $this->handleFileUploadForEdit($model, $profile);



            if ($profile->save(false)) {
                return $this->redirect(['profile/view', 'id' => $userId]);
            }
        }

        return $this->render('profile-edit', ['model' => $model, 'profile' => $profile]);
    }



    protected function handleFileUploadForEdit($model, $profile)
    {
        for ($i = 1; $i <= 5; $i++) {
            $imgAttribute = "img_url{$i}";
            $thumbnailAttribute = "thum_url{$i}";
            $uploadedFile = UploadedFile::getInstance($model, $imgAttribute);

            if ($uploadedFile) {
                // 古い画像の削除
                $this->deleteOldImage($profile->$imgAttribute);
                $this->deleteOldImage($profile->$thumbnailAttribute);

                // 新しい画像の保存
                $imgPath = $this->saveImage($uploadedFile);
                $profile->$imgAttribute = $imgPath['full'];
                $profile->$thumbnailAttribute = $imgPath['thumbnail'];
            }
        }
    }


    protected function saveImage($uploadedFile)
    {
        $basePath = Yii::getAlias('@webroot/image/');
        $webPath = Yii::getAlias('@web/image/');
        $filename = date('YmdHis') . '_' . Yii::$app->security->generateRandomString(128) . '.png';
        $thumbnailFilename = date('YmdHis') . '_' . Yii::$app->security->generateRandomString(128) . '_thm.png';

        // 画像の保存
        $fullPath = $basePath . $filename;
        if ($uploadedFile->saveAs($fullPath)) {
            // サムネイルの生成
            $image = \yii\imagine\Image::getImagine()->open($fullPath);
            $thumbnail = $image->thumbnail(new Box(300, 300));
            $thumbnailPath = $basePath . $thumbnailFilename;
            $thumbnail->save($thumbnailPath, ['quality' => 80]);

            return [
                'full' => $webPath . $filename,
                'thumbnail' => $webPath . $thumbnailFilename,
            ];
        } else {
            return false;
        }
    }

    protected function deleteOldImage($path)
    {
        if ($path) {
            $fullPath = Yii::getAlias('@webroot') . $path;
            if (file_exists($fullPath)) {
                @unlink($fullPath);
            }
        }
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

        // QRコード生成
        $profileUrl = Yii::$app->urlManager->createAbsoluteUrl(['profile/view', 'id' => $profile->user_id]);
        $result = Builder::create()
            ->data($profileUrl)
            ->size(200)
            ->margin(10)
            ->build();

        $qrCode = base64_encode($result->getString());

        return $this->render('profile-view', [
            'profile' => $profile,
            'user' => $user,
            'qrCode' => $qrCode, // QRコードをビューに渡す
        ]);
    }





}
