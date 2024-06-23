<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class Profile extends ActiveRecord
{
    public static function tableName()
    {
        return 'profile';
    }

    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['user_id'], 'integer'],
            [['self_introduction'], 'string'],
            [['service1', 'service2', 'service3', 'service4', 'service5', 'service6', 'service7', 'service8', 'service9', 'service10','img_url1', 'img_url2', 'img_url3', 'img_url4', 'img_url5', 'thum_url1', 'thum_url2', 'thum_url3', 'thum_url4', 'thum_url5'], 'string', 'max' => 255],
            [['service1_url', 'service2_url', 'service3_url', 'service4_url', 'service5_url', 'service6_url', 'service7_url', 'service8_url', 'service9_url', 'service10_url'], 'string', 'max' => 255],
            ['service1', 'validateServicePair', 'skipOnEmpty' => false],
        ];
    }

    public function validateServicePair($attribute, $params)
    {
        for ($i = 1; $i <= 10; $i++) {
            $service = $this->{"service{$i}"};
            $url = $this->{"service{$i}_url"};
            if (($service && !$url) || (!$service && $url)) {
                $this->addError($attribute, 'サービス名とURLは組にして両方入力してください。');
            }
        }
    }

    public function attributeLabels()
    {
        return [
            'self_introduction' => '自己紹介文',
            'service1' => 'サービス名1',
            'service1_url' => 'サービスURL1',
            'service2' => 'サービス名2',
            'service2_url' => 'サービスURL2',
            'service3' => 'サービス名3',
            'service3_url' => 'サービスURL3',
            'service4' => 'サービス名4',
            'service4_url' => 'サービスURL4',
            'service5' => 'サービス名5',
            'service5_url' => 'サービスURL5',
            'service6' => 'サービス名6',
            'service6_url' => 'サービスURL6',
            'service7' => 'サービス名7',
            'service7_url' => 'サービスURL7',
            'service8' => 'サービス名8',
            'service8_url' => 'サービスURL8',
            'service9' => 'サービス名9',
            'service9_url' => 'サービスURL9',
            'service10' => 'サービス名10',
            'service10_url' => 'サービスURL10',
        ];
    }
}
