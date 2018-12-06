<?php

/* @var $this yii\web\View */
use yii\helpers\Html;
$this->title = 'Тестовый проект';
$faker = Faker\Factory::create();
?>
<div class="site-index">
    <div class="jumbotron">
        <h1><?=\Yii::t('app','Welcome');?></h1>

        <?php if (!Yii::$app->user->isGuest) : ?>

            <div class="row-">
                <div class="col-md-6">
                    <p class="lead"><?=\Yii::t('app','Balance');?><?php echo(Yii::$app->user->identity->balance) ?> </p>
                    <p class="lead text_color_red"><?=\Yii::t('app','Send');?><?php echo $operations['send'] ?> </p>
                    <p class="lead text_color_green"><?=\Yii::t('app','Received');?><?php echo $operations['recipient'] ?> </p>
                    <p class="lead"><?=\Yii::t('app','Total operations', ['n' => $operations['number']]);?></p>
                </div>
                <div class="col-md-6">
                    <p class="lead"><?= Html::a(\Yii::t('app','Send money'), ['/operation/send-money'], ['class' => 'btn btn-lg btn-success']) ?></p>
                    <p class="lead"><?= Html::a(\Yii::t('app','Your operations'), ['/operation/view-transaction'], ['class' => 'btn btn-lg btn-success']) ?></p>

                    <?php
                    if (Yii::$app->user->can('admin')) {
                        echo(Html::a(\Yii::t('app','Setting panel'), ['/admin/index'], ['class' => 'btn btn-lg btn-success']));
                    } else {
                        echo(Html::a(\Yii::t('app','Create request'), ['/site/create-request'], ['class' => 'btn btn-lg btn-success']));
                    }
                    ?>
                </div>
            </div>     


        <?php else: ?>

            <p class="lead"><?=\Yii::t('app','Please auth')?></p>

            <p>
                <?= Html::a(\Yii::t('app','Auth'), ['user/login'], ['class' => 'btn btn-lg btn-success']) ?>
                <?= Html::a(\Yii::t('app','Register'), ['user/register'], ['class' => 'btn btn-lg btn-success']) ?>
            </p>

        <?php endif; ?>
    </div>


</div>
