<?php

namespace app\controllers;

use app\models\GiveKeyForm;
use app\models\Guest;
use app\models\GuestKey;
use app\models\Key;
use app\models\NewGuestForm;
use Yii;
use yii\filters\AccessControl;

class AdminController extends \yii\web\Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index', 'addguest', 'give-key', 'getguests'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function (){
                            return \Yii::$app->user->getId() == 100;
                        }
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index', [

        ]);
    }

    public function actionAddguest()
    {
        $model = new NewGuestForm();

        if ($model->load(\Yii::$app->request->post()) && $model->validate()){
            $model->addGuest();
            return $this->render('info', [
                'guest' => $model,
                'info' => 'add guest'
            ]);
        }

        return $this->render('addguest',
        [
            'model' => $model
        ]);
    }

    public function actionGiveKey()
    {
        if (Yii::$app->request->isAjax){
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

            $number = Yii::$app->request->post('number');
            $name = Yii::$app->request->post('name');
            $post = Yii::$app->request->post('post');

            $guest = null;

            if ($post != ''){
                if (Guest::findOne(['name' => $name]) == null){
                    $guest = new Guest();
                    $guest->name = $name;
                    $guest->post = $post;
                    $guest->save();
                }else{
                    return [
                        'status' => 'Already guest'
                    ];
                }

            }else{
                $guest = Guest::findOne(['name' => $name]);
            }

            $key = Key::findOne(['number' => $number]);

            if ($guest == null){
                return [
                    'status' => 'Not guest'
                ];
            }

            if ($key == null){
                return [
                    'status' => 'Not key'
                ];
            }

            if ($key->guest != null){
                return [
                    'status' => 'Key not free',
                    'guest' => $key->guest
                ];
            }

            $guest_key = new GuestKey();
            $guest_key->guest_id = $guest->id;
            $guest_key->key_id = $key->id;
            $guest_key->date = date('Y-m-d');
            $guest_key->save();

            $key->status = Key::STATUS_ISSUED;
            $key->save();

            return [
                'status' => 'OK'
            ];
        }


        return $this->render('give', [
        ]);
    }

    public function actionGetguests()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        if (Yii::$app->request->isAjax){

            $data = Yii::$app->request->post('data');

            $guests = Guest::find()->select('id, name')->where(['like', 'name', $data])->orderBy('name')->all();

//            $index = 0;
//            $guests = [];
//            foreach (Guest::find()->select('name')->where(['like', 'name', $data])->orderBy('name')->all() as $guest){
//                $guests[$index++] = $guest->name;
//            }

            return $guests;
        }
    }

}
