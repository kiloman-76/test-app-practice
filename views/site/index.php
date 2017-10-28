<?php

/* @var $this yii\web\View */

$this->title = 'Тестовый проект';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Добро пожаловать!</h1>
        
    <?php if (!Yii::$app->user->isGuest) :?>
   
        
        <p class="lead">Ваш баланс: <?php echo(Yii::$app->user->identity->balance)?> </p>
        <p>
            <a class="btn btn-lg btn-success" href="/operation/send-money">Отправить деньги</a>
            <a class="btn btn-lg btn-success" href="/operation/view-transaction">Ваши операции</a>
        </p>
        <?php if (Yii::$app->user->can('admin')) {
            echo('<a class="btn btn-lg btn-success" href="/admin/index">Панель управления</a>');
        }?>
        <?php else:?>
        
        <p class="lead">Чтобы продолжить работу с TestApp, пожалуйста, войдите или зарегистрируйтесь </p>

        
        
        <p>
            <a class="btn btn-lg btn-success" href="/user/login">Войти</a>
            <a class="btn btn-lg btn-success" href="/user/register">Зарегистрироваться</a>
        </p>
        
        <?php endif;?>
    </div>
    

</div>
