<?php

namespace app\controllers;

use app\models\request\Request;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use app\models\User;
use app\models\request\AddRequestForm;

class SiteController extends Controller {

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

    public function actionCreateRequest(){
        $user = User::findIdentity(Yii::$app->user->identity->id);

        $request = Request::checkUserRequest(Yii::$app->user->identity->id);
        if(!$request){
            $model = new AddRequestForm();
            if ($model->load(Yii::$app->request->post()) && $model->sendRequest($user)) {
                return $this->goBack();
            }
            return $this->render('add-request', [
                'model' => $model,
            ]);
        } else {
            return $this->render('error', [
                'message' => 'У вас уже имеется необработанная заявка, ожидайте ее рассмотрения',
            ]);
        }

    }

}
