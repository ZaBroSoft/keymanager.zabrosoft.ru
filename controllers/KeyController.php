<?php

namespace app\controllers;

use app\models\Guest;
use app\models\Key;
use app\models\Request;
use Yii;
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
                        'actions' => ['index', 'search-by-key', 'request-key', 'get-free-key', 'add-request'],
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
                'key_status' => $key->status,
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
            'requestName' => $name,
        ]);
    }

    public function actionGetFreeKey()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        if (\Yii::$app->request->isAjax){
            $key = Key::find()->where(['status' => Key::STATUS_FREE])->orderBy('id')->one();
            return ['key' => $key];
        }
    }

    public function actionAddRequest()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        if (\Yii::$app->request->isAjax){

            $number = Yii::$app->request->post('number');
            $name = Yii::$app->request->post('name');
            $post = Yii::$app->request->post('post');
            $type = Yii::$app->request->post('type');
            $bracelet = Yii::$app->request->post('bracelet');
            $access = Yii::$app->request->post('access');
            $vip = Yii::$app->request->post('vip');
            $other = Yii::$app->request->post('other');

            $req = new Request();

            $key = Key::findOne(['number' => $number]);
            if ($key == null){

            }else{
                $req->link('key', $key);
                $key->old_status = $key->status;
                $key->status = Key::STATUS_INREQUEST;
                $key->save();
            }

            $guest = Guest::findOne(['name' => $name]);
            if ($guest == null){
                $req->name = $name;
                $req->post = $post;
            }else{
                $req->link('guest', $guest);
                $req->name = $guest->name;
                $req->post = $guest->post;
            }

            $req->type = $type;
            $req->bracelet = $bracelet;
            $req->access = $access;
            $req->vip = $vip;
            $req->other = $other;
            $req->status = Request::STATUS_SENDED;
            $req->user_id = Yii::$app->user->getId();
            $req->date = date('Y-m-d');

            $req->save();

            return [
                'request_number' => $req->id
            ];
        }
    }

}
