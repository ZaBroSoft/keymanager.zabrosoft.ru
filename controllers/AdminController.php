<?php

namespace app\controllers;

use app\models\GiveKeyForm;
use app\models\Guest;
use app\models\GuestKey;
use app\models\Key;
use app\models\NewGuestForm;
use app\models\Request;
use Yii;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\helpers\Html;

class AdminController extends \yii\web\Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index', 'addguest', 'give-key', 'getguests', 'free-key', 'add-free-key',
                            'request-view', 'list-request', 'change-status'],
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

        $freeKeys = Key::find()->where(['status' => Key::STATUS_FREE])->count();
        $requestcount = Request::find()->where(['status'=>Request::STATUS_SENDED])->count();

        return $this->render('index', [
            'freeKeys' => $freeKeys,
            'requestCount' => $requestcount
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

        if (Yii::$app->request->isAjax){
            $req = Request::findOne(Html::encode(Yii::$app->request->post('request_id')));

            $guest = new Guest();
            $guest->name = Html::encode(Yii::$app->request->post('name'));
            $guest->post = Html::encode(Yii::$app->request->post('post'));
            $guest->save();

            $req->link('guest', $guest);
            $req->name = $guest->name;
            $req->post = $guest->post;

            $req->save();

            return $this->redirect(['request-view', 'id' => $req->id]);
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
                        'status' => 'Already guest',
                        'nextKey' => $number,
                    ];
                }

            }else{
                $guest = Guest::findOne(['name' => $name]);
            }

            $key = Key::findOne(['number' => $number]);

            if ($guest == null){
                return [
                    'status' => 'Not guest',
                    'nextKey' => $number,
                ];
            }

            if ($key == null){
                return [
                    'status' => 'Not key',
                    'nextKey' => $number,
                ];
            }

            if ($key->guest != null){
                return [
                    'status' => 'Key not free',
                    'guest' => $key->guest,
                    'nextKey' => $number,
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
                'status' => 'OK',
                'nextKey' => $number + 1,
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

    public function actionFreeKey()
    {
        $keys = Key::find()->where(['status' => Key::STATUS_FREE]);

        $countKeys = clone $keys;
        $pages = new Pagination(['totalCount' => $countKeys->count(), 'pageSize' => 5]);
        $models = $keys->offset($pages->offset)
            ->limit($pages->limit)
            ->all();

        $nextKey = Yii::$app->request->get('next_key');

        return $this->render('free-key', [
            'models' => $models,
            'pages' => $pages,
            'nextKey' => $nextKey,
            'keyCount' => $countKeys->count()
        ]);
    }

    public function actionAddFreeKey($key)
    {
        if ($key == '' || $key == 'NaN' || $key == 0){
            return $this->redirect('free-key');
        }

        $model = Key::findOne(['number' => $key]);
        $model->status = Key::STATUS_FREE;
        $model->save();

        return $this->redirect(['free-key', 'next_key' => $model->number + 1]);
    }

    public function actionRequestView($id)
    {
        $req = Request::findOne($id);
        return $this->render('request-view', [
            'request' => $req
        ]);
    }

    public function actionListRequest()
    {
        $list = Request::find()->orderBy(['(id)' => SORT_DESC]);

        $listCount = clone $list;
        $pages = new Pagination(['totalCount' => $listCount->count(), 'pageSize' => 15]);
        $models = $list->offset($pages->offset)->limit($pages->limit)->all();

        return $this->render('list-request', [
            'models' => $models,
            'pages' => $pages
        ]);
    }

    public function actionChangeStatus($id, $status)
    {
        $req = Request::findOne($id);
        switch ($status){
            case Request::STATUS_ISJOB:
                $req->status = Request::STATUS_ISJOB;
                break;
            case Request::STATUS_READY:
                $req->status = Request::STATUS_READY;
                break;
            case Request::STATUS_DONE:
                $req->status = Request::STATUS_DONE;

                if ($req->guest == null){
                    return $this->redirect(['request-view', 'id' => $id]);
                }

                if ($req->key != null){
                    $key = Key::findOne($req->key->id);
                    $guest = Guest::findOne($req->guest->id);

                    $guestKey = new GuestKey();
                    $guestKey->key_id = $key->id;
                    $guestKey->guest_id = $guest->id;
                    $guestKey->date = date('Y-m-d');
                    $guestKey->save();
                }

                $req->save();

                return $this->redirect(['request-view', 'id' => $id]);

                break;
            case Request::STATUS_CANCELED:
                $req->status = Request::STATUS_CANCELED;
                if ($req->key != null){
                    $key = Key::findOne($req->key->id);
                    $key->status = $key->old_status;
                    $key->old_status = null;
                    $key->save();
                }

                $req->save();
                return $this->redirect(['list-request']);
                break;
        }
        $req->save();

        return $this->redirect(['request-view', 'id' => $id]);
    }
}
