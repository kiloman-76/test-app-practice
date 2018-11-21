<?php

namespace app\controllers;

use Yii;
use app\models\User;
use app\models\user\UserSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\request\Request;

/**
 * AdminController implements the CRUD actions for User model.
 */
class AdminController extends Controller {

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex() {
        $this->layout = "admin";
        return $this->render('index');
    }

    public function actionRequestList() {
        $requests = Request::getAllUnverifiedRequests();
        return $this->render('request-list', [
            'requests' => $requests
        ]);
    }

    public function actionChangeRequestStatus($request_id, $status){
        $request = Request::getByID($request_id);
        if($message = $request->changeRequestStatus($status)){
            $responce['SUCCESS'] = $message;
        } else {
            $responce['ERROR'] = 'Ошибка при изменении статуса пользователя';
        }
        return $message;
    }
}
