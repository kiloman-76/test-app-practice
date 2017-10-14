<?php
use yii\helpers\Html;
use yii\helpers\Url;


/* @var $this \yii\web\View view component instance */
/* @var $message \yii\mail\BaseMessage instance of newly created mail message */
$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['user/reset-password', 'token' => $user->auth_key, 'email' => $user->email]);

?>
<h2>Здравствуйте! </h2> 
<span>Чтобы обновить пароль, перейдите по ссылке</span>
<p><?= Html::a(Html::encode($resetLink), $resetLink) ?></p>
