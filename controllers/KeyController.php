<?php

namespace app\controllers;

use app\models\Guest;
use app\models\Key;
use yii\filters\AccessControl;

class KeyController extends \yii\web\Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index', 'search-by-key', 'request-key', 'get-free-key'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionSearchByKey()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        if (\Yii::$app->request->isAjax){

            $number_key = \Yii::$app->request->post('num');
            $key = Key::getKeyByNumber($number_key);

            return [
                'key_id' => $key->id,
                'key_status' => $key->status
            ];
        }
    }

    public function actionRequestKey($number, $name)
    {

        $key = Key::findOne(['number' => $number]);
        $guest = Guest::findOne(['name' => $name]);



        return $this->render('request-key',[
            'key' => $key,
            'guest' => $guest,
        ]);
    }

    public function actionGetFreeKey()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        if (\Yii::$app->request->isAjax){
            $key = Key::findOne(['status' => Key::STATUS_FREE]);
            return ['key' => $key];
        }
    }
}
