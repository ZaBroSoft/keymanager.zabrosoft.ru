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
    const ACTION_KEY_RETURN = 1;
    const ACTION_KEY_LOSS = 2;

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index', 'addguest', 'give-key', 'getguests', 'free-key', 'add-free-key',
                            'request-view', 'list-request', 'change-status', 'action-key'],
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
    } /* Добавление гостя в базу */

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
    } /* Назначение брелка гостю */

    public function actionGetguests()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        if (Yii::$app->request->isAjax){

            $data = Yii::$app->request->post('data');

            $guests = Guest::find()->select('id, name')->where(['like', 'name', $data])->orderBy('name')->all();

            return $guests;
        }
    } /* Список гостей для поля с автозаполнением */

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
    } /* Список свободных брелков */

    public function actionAddFreeKey($key)
    {
        if ($key == '' || $key == 'NaN' || $key == 0){
            return $this->redirect('free-key');
        }

        $model = Key::findOne(['number' => $key]);
        $model->status = Key::STATUS_FREE;
        $model->save();

        return $this->redirect(['free-key', 'next_key' => $model->number + 1]);
    } /* Добавление свободных брелков */

    public function actionRequestView($id)
    {
        $req = Request::findOne($id);
        return $this->render('request-view', [
            'request' => $req
        ]);
    } /* Просмотр заявки на брелок */

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
    } /* Список заявок */

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

                    $key->status = Key::STATUS_ISSUED;
                    $key->save();

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
    } /* Изменение статуса заявки */

    public function actionActionKey()
    {

        if (Yii::$app->request->isAjax){
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

            $number = Yii::$app->request->post('number');
            $action = Yii::$app->request->post('action');
            $from = Yii::$app->request->post('from');

            if ($action == 'return'){
                $key = Key::findOne($number);
                if ($key != null){
                    if ($from == Key::STATUS_FREE){
                        $guestKey =GuestKey::findOne(['key_id' => $key->id]);
                        if ($guestKey != null){
                            $guestKey->delete();
                        }
                        $key->status = Key::STATUS_FREE;
                        $key->save();
                        return [
                            'status' => 'OK'
                        ];
                    }
                    if ($from == Key::STATUS_STOCK){
                        $guestKey =GuestKey::findOne(['key_id' => $key->id]);
                        if ($guestKey != null){
                            $guestKey->delete();
                        }
                        $key->status = Key::STATUS_STOCK;
                        $key->save();
                        return [
                            'status' => 'OK'
                        ];
                    }
                }
            }
        }

        return $this->render('action-key');
    }  /* Действие над брелками */
}
