<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\User;
use app\models\operation\Operation;
use app\models\operation\SendMoneyForm;

class OperationController extends Controller {

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

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionSendMoney() {

        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $message = '';
        $model = new SendMoneyForm();

        if ($model->load(Yii::$app->request->post()) && $model->sendMoney()) {      
            $message = "Деньги были отправлены";
        }

        return $this->render('send-money', [
                    'model' => $model,
                    'message' => $message
        ]);
    }

    public function actionViewTransaction($type = 0) {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $user_id = Yii::$app->user->identity->id;
        $user= User::findIdentity($user_id);
        
        
        if($type == 1){
            $operations = $user->sendedOperations;
        } else if ($type == 2){
            $operations = $user->recipientOperations;
        } else {
            $operations = Operation::findUserOperation($user_id);
        }
        
     
        return $this->render('view-transaction', [
                    'operations' => $operations
        ]);
    }

}
