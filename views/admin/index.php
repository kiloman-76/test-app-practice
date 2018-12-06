<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
$this->title = 'Тестовый проект';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Добро пожаловать, Администратор!</h1>

        <p>
            <?= Html::a('Управление пользователями', ['user-manage/index'], ['class' => 'btn btn-lg btn-success']) ?>
        </p>
        <p>
            <?= Html::a('Управление заявками', ['admin/request-list'], ['class' => 'btn btn-lg btn-success']) ?>
        </p>
        <p>
            <?= Html::a('Генератор пользователей и заявок', ['admin/generate-list'], ['class' => 'btn btn-lg btn-success']) ?>
        </p>
    </div>

    <?=\Yii::t('app/admin','TestAdmin');?>

</div>
