<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\user\LoginForm;
use app\models\user\RegisterForm;
use app\models\ContactForm;
use app\models\User;

class SiteController extends Controller {

    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['testmin'],
                'rules' => [
                    [
                        'actions' => ['testmin'],
                        'allow' => true,
                        'roles' => ['admin'],
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

    public function actionAbout() {
        return $this->render('about');
    }

}
