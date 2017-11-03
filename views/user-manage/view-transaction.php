<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\models\User;

$this->title = 'Ваши Операции';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-operation">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php
    foreach ($operations as $operation) {
        $time_operation = date('d M Y H:i:s', $operation->creation_data);

        if ($operation->sender_id == $user_id) {
            ?>

            <?php if ($operation->creator_id != $operation->sender_id) { ?>
                <p><span class="operation-item red">
                        <?php echo Html::encode("Администратор {$operation->creator->email} отправил со счета пользователя {$operation->money} руб. пользователю {$operation->recipient->email} {$time_operation}. Баланс пользователя {$operation->sender_balance} руб."); ?>
                    </span></p>

            <?php } else if ($operation->creator_id == $operation->sender_id) {
                ?>
                <p><span class="operation-item red">
                        <?php echo Html::encode("Пользователь отправил {$operation->money} руб. пользователю {$operation->recipient->email} {$time_operation}. Баланс пользователя {$operation->sender_balance} руб."); ?>
                    </span></p>
                <?php
            }
            ?>

            <?php
        } else if ($operation->recipient_id == $user_id) {
            if ($operation->sender_id == 0) {
                ?>
                <p><span class="operation-item green">
                        <?php echo Html::encode("Администратор {$operation->creator->email} начислил пользвателю {$operation->money} руб.  {$time_operation}. Баланс пользователя {$operation->recipient_balance} руб."); ?>
                    </span></p>

            <?php } else {
                ?>
                <p><span class="operation-item green">
                        <?php echo Html::encode("Пользователю отправил {$operation->money} руб. пользователь {$operation->sender->email} {$time_operation}. Баланс пользователя {$operation->recipient_balance} руб."); ?>
                    </span></p>
                <?php
            }
            ?>

            <?php
        }
    }
    ?>


</div>
