<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\models\User;
use yii\widgets\Pjax;

$this->title = 'Ваши Операции';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-operation">
    <h1><?= Html::encode($this->title) ?></h1>
    
    <?php Pjax::begin(['id'=>'type-transaction']);?>
   <select class='operation-type' size="3" name="hero[]">
    <option selected value='0'>Все</option>
    <option value="1">Отправленные</option>
    <option value="2">Полученные</option>
   </select>
    <?php Pjax::end();?>
    
    <?php Pjax::begin(['id' => 'transactions']) ?>
        <?php
            foreach ($operations as $operation) {
            $time_operation = date('d M Y H:i:s', $operation->creation_data);
            $user = new User;
            if ($operation->sender_id == Yii::$app->user->id) {
                ?>

                <?php if ($operation->creator_id != $operation->sender_id) { ?>
                    <p><span class="operation-item red">
                            <?php echo Html::encode("С вашего счета отправлено {$operation->money} руб. пользователю {$operation->recipient->email} {$time_operation}. Ваш баланс {$operation->sender_balance} руб."); ?>
                        </span></p>

                <?php } else if ($operation->creator_id == $operation->sender_id) {
                    ?>
                    <p><span class="operation-item red">
                            <?php echo Html::encode("Вы отправили {$operation->money} руб. пользователю {$operation->recipient->email} {$time_operation}. Ваш баланс {$operation->sender_balance} руб."); ?>
                        </span></p>
                    <?php
                }
                ?>

                <?php
            } else if ($operation->recipient_id == Yii::$app->user->id) {
                if ($operation->sender_id == 0) {
                    ?>
                    <p><span class="operation-item green">
                            <?php echo Html::encode("Вам начислено {$operation->money} руб.  {$time_operation}. Ваш баланс {$operation->recipient_balance} руб."); ?>
                        </span></p>

                <?php } else {
                    ?>
                    <p><span class="operation-item green">
                            <?php echo Html::encode("Вам отправил {$operation->money} руб. пользователь {$operation->sender->email} {$time_operation}. Ваш баланс {$operation->recipient_balance} руб."); ?>
                        </span></p>
                    <?php
                }
                ?>

                <?php
            }
        }
        ?>
    <?php Pjax::end(); ?>



</div>
