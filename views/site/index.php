<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
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
                    <p class="lead"><?= Html::a('Отправить деньги', ['/operation/send-money'], ['class' => 'btn btn-lg btn-success']) ?></p>
                    <p class="lead"><?= Html::a('Ваши операции', ['/operation/view-transaction'], ['class' => 'btn btn-lg btn-success']) ?></p>

                    <?php
                    if (Yii::$app->user->can('admin')) {
                        echo(Html::a('Панель управления', ['/admin/index'], ['class' => 'btn btn-lg btn-success']));
                    } else {
                        echo(Html::a('Подать заявку', ['/site/create-request'], ['class' => 'btn btn-lg btn-success']));
                    }
                    ?>
                </div>
            </div>     


        <?php else: ?>

            <p class="lead">Чтобы продолжить работу с TestApp, пожалуйста, войдите или зарегистрируйтесь </p>

            <p>
                <?= Html::a('Войти', ['user/login'], ['class' => 'btn btn-lg btn-success']) ?>
                <?= Html::a('Зарегистрироваться', ['user/register'], ['class' => 'btn btn-lg btn-success']) ?>

            </p>

        <?php endif; ?>
    </div>


</div>
