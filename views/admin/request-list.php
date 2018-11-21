<?php
/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'Тестовый проект';
?>
<div class="site-index">
    <?php foreach ($requests as $request):?>
    <div class="request">
        <h5>Заявка №<?=$request->id?> от <?=$request->sender->username?>(<?=$request->sender->email?>)</h5>
        <span><?=$request->text?></span>
        <div class="buttons">
            <?= Html::a('Принять', ['admin/change-request-status', 'request_id' => $request->id, 'status'=> 1], ['class' => 'btn btn-success request-access']) ?>
            <?= Html::a('Отклонить', ['admin/change-request-status', 'request_id' => $request->id, 'status'=> 2], ['class' => 'btn btn-danger request-access']) ?>
        </div>
    </div>

    <?php endforeach;?>
</div>
