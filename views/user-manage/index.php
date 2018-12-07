<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\user\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Управление пользователями';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]);  ?>

    <p>
        <?= Html::a('Новый пользователь', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'rowOptions' => function ($model, $key, $index, $grid) {
            if ($key == Yii::$app->user->identity->id) {
                $class = 'no-edit';
            } else {
                $class = 'edit';
            }
            return [
                'key' => $key,
                'index' => $index,
                'class' => $class
            ];
        },
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            //'id',
            'username',
            'email:email',
            //'password_hash',
            //'auth_key',
            'balance',
            //'status',
            ['class' => 'yii\grid\ActionColumn',
                'template' => '{view}{delete}{update}{add-admin-status}{delete-admin-status}{add-money}{make-transaction}{view-user-operations}',
                'buttons' => [
                    'view' => function ($url, $model, $key) {
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, ['title' => 'Просмотр']);
                    },
                    'delete' => function ($url, $model, $key) {
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, ['title' => 'Удалить']);
                    },
                    'update' => function ($url, $model, $key) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, ['title' => 'Редактировать']);
                    },
                    'add-admin-status' => function ($url, $model, $key) {
//        var_dump($model); exit();
                        if ($model->status == 1) {
                            return Html::a('<span class="glyphicon glyphicon-arrow-up text_color_green"></span>', '#', ['class'=>'add-admin', 'data'=>['id'=>$model->id], 'title'=> 'Дать статус администратора']);
                        }
                    },
                    'delete-admin-status' => function ($url, $model, $key) {
                        if ($model->status == 10) {
                            return Html::a('<span class="glyphicon glyphicon-arrow-down text_color_red"></span>', '#', ['class'=>'delete-admin', 'data'=>['id'=>$model->id],  'title'=> 'Убрать статус администратора']);
                        }
                    },
                    'add-money' => function ($url, $model, $key) {
                        return Html::a('<span class="glyphicon glyphicon-usd"></span>', $url, ['title' => 'Добавить денег']);
                    },
                    'make-transaction' => function ($url, $model, $key) {
                        return Html::a('<span class="glyphicon glyphicon-share-alt"></span>', $url, ['title' => 'Отправить деньги другому пользователю с этого счета']);
                    },
                    'view-user-operations' => function ($url, $model, $key) {
                        return Html::a('<span class="glyphicon glyphicon-align-justify"></span>', $url, ['title' => 'Просмотреть операции']);
                    },

                ],
            ],
        ],
    ]);
    ?>
    <?php Pjax::end(); ?>
</div>
