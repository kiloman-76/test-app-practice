<?php

namespace app\controllers;

use app\models\News;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use app\models\User;
use app\models\request\AddRequestForm;

class NewsController extends Controller {

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



    public function actionMarkAsRead($id){
        $news = News::GetByID($id);
        $news->markAsRead();
        return true;
    }

    public function actionDelete($id){

    }

    public function actionTakeUserNews(){
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $user_id = Yii::$app->user->identity->id;
        $responce['NEWS'] = News::findUserUnreadNews($user_id);
        return $responce;
    }

}
