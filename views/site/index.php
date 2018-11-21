<?php
/* @var $this yii\web\View */

$this->title = 'Тестовый проект';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Добро пожаловать!</h1>

        <?php if (!Yii::$app->user->isGuest) : ?>

            <div class="row-">
                <div class="col-md-6">
                    <p class="lead">Ваш баланс: <?php echo(Yii::$app->user->identity->balance) ?> </p>
                    <p class="lead text_color_red">Вы отправили: <?php echo $operations['send'] ?> </p>
                    <p class="lead text_color_green">Вы получили: <?php echo $operations['recipient'] ?> </p>
                    <p class="lead">Всего операций: <?php echo $operations['number'] ?> </p>  
                </div>
                <div class="col-md-6">  
                    <p class="lead"><a class="btn btn-lg btn-success" href="/operation/send-money">Отправить деньги</a></p>
                    <p class="lead"><a class="btn btn-lg btn-success" href="/operation/view-transaction">Ваши операции</a></p>

                    <?php
                    if (Yii::$app->user->can('admin')) {
                        echo('<a class="btn btn-lg btn-success" href="/admin/index">Панель управления</a>');
                    } else {
                        echo('<a class="btn btn-lg btn-success" href="/site/create-request">Подать заявку</a>');
                    }
                    ?>
                </div>
            </div>     


        <?php else: ?>

            <p class="lead">Чтобы продолжить работу с TestApp, пожалуйста, войдите или зарегистрируйтесь </p>



            <p>
                <a class="btn btn-lg btn-success" href="/user/login">Войти</a>
                <a class="btn btn-lg btn-success" href="/user/register">Зарегистрироваться</a>
            </p>

        <?php endif; ?>
    </div>


</div>
