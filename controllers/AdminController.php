<?php

namespace app\controllers;

use app\models\GiveKeyForm;
use app\models\Guest;
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
