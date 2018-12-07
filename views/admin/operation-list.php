<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use app\models\User;
use yii\widgets\LinkPager;

$this->title = 'Все Операции';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-operation">
    <h1><?= Html::encode($this->title) ?></h1>

    <?= LinkPager::widget([
        'pagination' => $pagination,
    ]); ?>

        <?php foreach ($operations as $operation) :
            $time_operation = date('d M Y H:i:s', $operation->creation_data);
            $user = new User;
            if(isset($operation->sender_id)):
                if($operation->creator_id == $operation->sender_id):?>
                    <p><span class="operation-item gray">
                    <?=Html::encode("Пользователь {$operation->sender->email} отправил {$operation->money} руб. пользователю {$operation->recipient->email} {$time_operation}. Баланс отправителя {$operation->sender_balance} руб, баланс получателя {$operation->recipient_balance} "); ?>
                    </span></p>
                <?php  else: ?>
                    <p><span class="operation-item gray">
                    <?=Html::encode("Со счета пользователя {$operation->sender->email} администратором {$operation->creator->email} отправлено {$operation->money} руб. пользователю {$operation->recipient->email} {$time_operation}. Баланс отправителя { $operation->sender_balance} руб, баланс получателя {$operation->recipient_balance} "); ?>
                    </span></p>
                <?php endif; ?>

            <?php  else: ?>
                <p><span class="operation-item gray">
                <?=Html::encode("Администратор {$operation->creator->email} добавил {$operation->money} руб. пользователю {$operation->recipient->email} {$time_operation}. Баланс пользователя {$operation->recipient_balance} руб."); ?>
                </span></p>
            <?php endif; ?>

        <?php endforeach; ?>



</div>
