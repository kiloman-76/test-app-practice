<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Html;
use app\models\User;
use app\models\operation\Operation;
use app\models\operation\AddMoneyForm;
use app\models\operation\MakeTransactionForm;
use app\models\user\UserSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\HttpException;
use app\models\user\CreateUserForm;


/**
 * UserManageController implements the CRUD actions for User model.
 */
class UserManageController extends Controller {

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
					[
						'allow' => true,
						'actions' => ['search'],
						'roles' => ['@'],
					],
                ],
            ],
        ];
    }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }
    
    
    public function actionSearch($email){
        $users = User::findUser($email);
       
        return $this->renderPartial('users-search', [
            'users' => $users,
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new CreateUserForm();

        if ($model->load(Yii::$app->request->post()) && $user = $model->createUser()) {
            return $this->redirect(['view', 'id' => $user->id]);
        }

        return $this->render('create', [
                    'model' => $model,
        ]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        if ($id == Yii::$app->user->identity->id) {
            throw new HttpException(403, 'Вы не можете редактировать себя!');
        }
        $model = $this->findModel($id);

        if ($model->load($post = Yii::$app->request->post()) && $save = $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
                    'model' => $model,
        ]);
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        if ($id == Yii::$app->user->identity->id) {
            throw new HttpException(403, 'Вы не можете редактировать себя!');
        }
        $user = $this->findModel($id);
        if($user->sendedOperations || $user->recipientOperations || $user->createdOperations){
            return $this->render('../site/error', [
                'message' => 'У данного пользователя имеются операции с другими пользователями, его нельзя удалить',
            ]);
        } else {
            $user->delete();
        }

        return $this->redirect(['index']);
    }

    public function actionAddMoney($id) {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $user = $this->findModel($id);
        $model = new AddMoneyForm();

        if ($model->load(Yii::$app->request->post()) && $model->addMoney($user)) {
            return $this->goBack('/user-manage/index');
        }

        return $this->render('add-money', [
                    'model' => $model,
        ]);
    }

    public function actionMakeTransaction($id) {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $user = $this->findModel($id);
        $model = new MakeTransactionForm();
        $model->sender = $user;

        if ($model->load(Yii::$app->request->post()) && $model->sendMoney($user)) {
            return $this->goBack('index');
        }

        return $this->render('send-money', [
            'model' => $model,
            'user' => $user
        ]);
    }

    public function actionAddAdminStatus($id) {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $user = $this->findModel($id);
        if ($user->addAdminStatus()) {
            return $user->id;
        };
    }

    public function actionDeleteAdminStatus($id) {
        if ($id == Yii::$app->user->identity->id) {
            throw new HttpException(403, 'Вы не можете редактировать себя!');
        }
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $user = $this->findModel($id);
        if ($user->deleteAdminStatus()) {
            return $user->id;
        };
    }

    public function actionViewUserOperations($id) {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $operations = Operation::findUserOperation($id);
        return $this->render('view-transaction', [
                    'user_id' => $id,
                    'operations' => $operations
        ]);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
