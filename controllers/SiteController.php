<?php

namespace app\controllers;

use app\models\Guest;
use app\models\Key;
use app\models\Request;
use Yii;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'index', 'about', 'contact', 'getguests', 'search-by-key', 'search-by-name'],
                'rules' => [
                    [
                        'actions' => ['logout', 'index', 'about', 'contact', 'getguests', 'search-by-key', 'search-by-name'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {

        $requests = Request::find()->where(['user_id'=>Yii::$app->user->getId()])->orderBy(['id'=>SORT_DESC]);

        $requestsCount = clone $requests;
        $pages = new Pagination(['totalCount'=> $requestsCount->count(), 'pageSize'=>10]);

        $models = $requests->offset($pages->offset)->limit($pages->limit)->all();

        return $this->render('index', [
            'requests' => $models,
            'pages' => $pages
        ]);
    }

    public function actionSearchByKey()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        if (\Yii::$app->request->isAjax){

            $number_key = \Yii::$app->request->post('num');
            $key = Key::getKeyByNumber($number_key);

            if ($key == null){
                return [
                    'key_status' => 0
                ];
            }

            if ($key->guest == null){
                return [
                    'key_id' => $key->id,
                    'key_status' => $key->status,
                ];
            }

            $guest = Guest::getGuestByName($key->guest->name);
            $key_count = $guest == null ? 0 : count($guest->keysArray);

            return [
                'key_id' => $key->id,
                'key_status' => $key->status,
                'keys_count' => $key_count,
                'guest' => $guest,
                'keys' => $guest->keysArray,
                'key_status_name' => $key->getStatusName()
            ];
        }
    }

    public function actionSearchByName()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        if (\Yii::$app->request->isAjax){

            $name = \Yii::$app->request->post('num');

            $guest = Guest::getGuestByName($name);

            if ($guest == null){
                return [
                    'guest' => $guest,
                ];
            }

            $key_count = $guest == null ? 0 : count($guest->keysArray);

            return [
                'guest' => $guest,
                'keys_count' => $key_count,
                'keys' => $guest->keysArray,
            ];
        }
    }

    public function actionGetguests()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        if (Yii::$app->request->isAjax){

            $data = Yii::$app->request->post('data');

            $index = 0;
            $guests = [];
            foreach (Guest::find()->select('name')->where(['like', 'name', $data])->orderBy('name')->all() as $guest){
                $guests[$index++] = $guest->name;
            }

            return $guests;
        }
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
}
