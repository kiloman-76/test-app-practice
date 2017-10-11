<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\user\LoginForm;
use app\models\user\RegisterForm;
use app\models\User;
use app\models\ContactForm;

class UserController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
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
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionRegister()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new RegisterForm();
        if ($model->load(Yii::$app->request->post()) && $user=$model->register()) {
          
            $model->verificateMail($user);
            
            return $this->goBack();
        }
        return $this->render('register', [
            'model' => $model,
        ]);
    }

    public function actionVerificatePassword($token, $email){
        
       $user = User::findOne([
           'email' => $email,
       ]);
       
        if($user -> auth_key == $token){
            $user -> status = 1;
            $user -> save();
            Yii::$app->session->setFlash('testmessage','Вы успешно зарегистрировались на сайте, '
                . 'теперь вы можете войти, используя свой логин и пароль');

            $this->redirect( array('login','message'=>'testmessage') );
        } else {
            var_dump($user -> auth_key,$token); exit();
            Yii::$app->session->setFlash('testmessage','Ошибка');

            $this->redirect( array('login','message'=>'Ошибка') );        }
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
   
    
    
}
