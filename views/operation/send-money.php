<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\widgets\Pjax;


$this->title = 'Отправить деньги';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
        <div class="site-login">
            <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(['id'=>'send-money']);?>
            <?php
                $form = ActiveForm::begin([
                            'id' => 'login-form',
                            'layout' => 'horizontal',
                            'fieldConfig' => [
                                'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
                                'labelOptions' => ['class' => 'col-lg-1 control-label'],
                            ],
                ]);
                ?>
                <?php if(isset($model)):?>
                    <?= $form->field($model, 'email')->textInput(['autofocus' => true]) ?>

                    <?= $form->field($model, 'money')->textInput(['autofocus' => true]) ?>
                <?php endif;?>

                <div class="form-group">
                    <div class="col-lg-offset-1 col-lg-11">
                        <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                    </div>
                </div>
                <?php if(isset($message)):?>
                    <h3><?=$message?></h3>
                <?php endif;?>


            <?php ActiveForm::end(); ?>

    <?php Pjax::end();?>

        </div>
</div>
<div class="row">
     <?php Pjax::begin(['id'=>'search-users', 'timeout' => 5000 ]);?>
    <span>Введите данные</span>
    <?php Pjax::end();?>
</div>

