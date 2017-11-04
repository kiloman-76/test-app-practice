<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\user\LoginForm;
use app\models\user\RegisterForm;
use app\models\user\ResetPasswordForm;
use app\models\user\SendMailForm;
use app\models\User;
use app\models\ContactForm;

class UserController extends Controller {

    /**
     * @inheritdoc
     */
    public function behaviors() {
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
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin() {

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

    public function actionSendMail() {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new SendMailForm();
        if ($model->load(Yii::$app->request->post()) && $model->sendMail()) {
            $this->redirect(array('login', 'message' => 'На Ваш email было выслано письмо для подтверждения'));
        }

        return $this->render('send-mail', [
                    'model' => $model,
        ]);
    }

    public function actionResetPassword($token = null, $email = null) {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new ResetPasswordForm();
        if (isset($token) && isset($email)) {
            return $this->render('reset-password', [
                        'model' => $model,
            ]);
        }

        if ($model->load(Yii::$app->request->post()) && $password = $model->resetPassword()) {
            $user = User::findByEmail($email);
            $user->setPassword($password);
            $user->save();
            $this->redirect(array('login', 'message' => ' Теперь вы можете войти, используя ваш новый пароль'));
        }

        ;
        return $this->render('reset-password', [
                    'model' => $model,
        ]);
    }

    public function actionRegister() {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new RegisterForm();
        if ($model->load(Yii::$app->request->post()) && $user = $model->register()) {

            $model->verificateMail($user);

            return $this->redirect(array('login', 'message' => ' Теперь вы можете войти, используя ваш новый пароль'));
        }
        return $this->render('register', [
            'model' => $model,
        ]);
    }

    public function actionVerificatePassword($token, $email) {

        $user = User::findOne([
                    'email' => $email,
        ]);

        if ($user->auth_key == $token) {
            $user->status = 1;
            $user->save();
            $this->redirect(array('login', 'message' => 'Вы успешно зарегистрировались на сайте, '
                . 'теперь вы можете войти, используя свой логин и пароль'));
        } else {
            var_dump($user->auth_key, $token);
            exit();

            $this->redirect(array('login', 'message' => 'Ошибка в подтверждении пароля'));
        }
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout() {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
}
