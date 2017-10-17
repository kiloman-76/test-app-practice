<?php

/* @var $this yii\web\View */

$this->title = 'Тестовый проект';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Добро пожаловать!</h1>

        <p class="lead">Чтобы продолжить работу с TestApp, пожалуйст, войдите или зарегистрируйтесь </p>

        <?php if (Yii::$app->user->can('admin')) {
            echo('<a class="btn btn-lg btn-success" href="/admin/index">Панель управления</a>');
        }?>
        
        <p>
            <a class="btn btn-lg btn-success" href="/user/login">Войти</a>
            <a class="btn btn-lg btn-success" href="/user/register">Зарегистрироваться</a>
        </p>
    </div>
    

</div>
