<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\Pjax;


/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$user_current = Yii::$app->user->identity->id;
?>
<div class="user-view">


    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php if ($user_current != $model->id): ?>
            <?= Html::a('Обновить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?=
            Html::a('Удалить', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Вы уверены что хотите удалить этого пользователя?',
                    'method' => 'post',
                ],
            ])
            ?>
            <?php
            if ($model->status == 10) {
                echo Html::a('Удалить права администратора', '#', ['class' => 'btn btn-danger delete-admin','data'=>['id'=>$model->id] ]);
            } else {
                echo Html::a('Дать права администратора', '#', ['class' => 'btn btn-success add-admin','data'=>['id'=>$model->id] ]);
            }
            ?>
        <?php endif; ?>

        <?= Html::a('Пополнить счет', ['add-money', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>


        <?= Html::a('Список операций', ['view-user-operations', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Сделать перевод', ['make-transaction', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </p>

    <?=
    DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'username',
            'email:email',
            'password_hash',
            'auth_key',
            'balance',
            'status',
        ],
    ])
    ?>

</div>
