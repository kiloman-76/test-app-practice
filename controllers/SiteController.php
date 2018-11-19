<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use app\models\User;
use app\models\request\AddRequestForm;

class SiteController extends Controller {

    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['request'],
                'rules' => [
                    [
                        'actions' => ['request'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions() {
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

    public function actionIndex() {
         if (!Yii::$app->user->isGuest) {
            $user = User::findIdentity(Yii::$app->user->identity->id);
            $operations = $user->getOperationInfo();
            return $this->render('index', ['operations' => $operations]);

         }
        return $this->render('index');
    }

    public function actionRequest(){
        $model = new AddRequestForm();
        $user = User::findIdentity(Yii::$app->user->identity->id);
        if ($model->load(Yii::$app->request->post()) && $model->sendRequest($user)) {
            return $this->goBack();
        }
        return $this->render('request', [
            'model' => $model,
        ]);
    }

}
