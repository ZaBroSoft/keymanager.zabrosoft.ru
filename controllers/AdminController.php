<?php

namespace app\controllers;

use app\models\Guest;
use app\models\NewGuestForm;
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
                        'actions' => ['index', 'addguest'],
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

}
