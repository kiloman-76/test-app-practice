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

        $model = new SendMoneyForm();

        if ($model->load(Yii::$app->request->post()) && $model->sendMoney()) {
            return $this->goBack();
        }

        return $this->render('send-money', [
                    'model' => $model,
        ]);
    }

    public function actionViewTransaction() {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $user_id = Yii::$app->user->identity->id;
        $operations = Operation::findUserOperation($user_id);
        return $this->render('view-transaction', [
                    'operations' => $operations
        ]);
    }

}
