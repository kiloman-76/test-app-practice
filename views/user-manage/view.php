<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Обновить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены что хотите удалить этого пользователя?',
                'method' => 'post',
            ],
        ]) ?>
         <?= Html::a('Пополнить счет', ['add-money', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        
        <?php
            if($model->status == 10){
                echo Html::a('Удалить права администратора', ['delete-admin-status', 'id' => $model->id], ['class' => 'btn btn-danger']); 
            } else {
                echo Html::a('Дать права администратора', ['add-admin-status', 'id' => $model->id], ['class' => 'btn btn-success']); 

            }
        ?>
         <?= Html::a('Список операций', ['view-user-operations', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
         <?= Html::a('Сделать перевод', ['make-transaction', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= DetailView::widget([
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
    ]) ?>

</div>