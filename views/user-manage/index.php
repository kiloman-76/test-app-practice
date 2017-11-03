<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\user\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]);  ?>

    <p>
        <?= Html::a('Create User', ['create'], ['class' => 'btn btn-success']) ?>
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
                    'add-admin-status' => function ($url, $model, $key) {
//        var_dump($model); exit();
                        if ($model->status == 1) {
                            return Html::a('<span class="glyphicon glyphicon-arrow-up text_color_green"></span>', $url);
                        }
                    },
                    'delete-admin-status' => function ($url, $model, $key) {
                        if ($model->status == 10) {
                            return Html::a('<span class="glyphicon glyphicon-arrow-down text_color_red"></span>', $url);
                        }
                    },
                    'add-money' => function ($url, $model, $key) {
                        return Html::a('<span class="glyphicon glyphicon-usd"></span>', $url);
                    },
                    'make-transaction' => function ($url, $model, $key) {
                        return Html::a('<span class="glyphicon glyphicon-share-alt"></span>', $url);
                    },
                    'view-user-operations' => function ($url, $model, $key) {
                        return Html::a('<span class="glyphicon glyphicon-align-justify"></span>', $url);
                    },
                ],
            ],
        ],
    ]);
    ?>
    <?php Pjax::end(); ?>
</div>
