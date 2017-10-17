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

class AdminController extends Controller
{
    
    public $layout = 'admin';


    public function behaviors()
    {
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
        return $this->render('index');
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
    
    public function actionAdmin()
    {
        if(isset(\Yii::$app->user->id)){
            
            $rbac = \Yii::$app->authManager;
            $admin = $rbac->getRole('admin');
            $rbac->assign($admin,\Yii::$app->user->id);
        } else {
            var_dump('Вам здесь не рады!');
        }
    }
    
    public function actionTestmin()
    {
        var_dump('Вы админ!');
    }
    
}
