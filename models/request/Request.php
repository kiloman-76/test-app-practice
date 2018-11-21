<?php

namespace app\models\request;

use app\models\News;
use app\models\User;

class Request extends \yii\db\ActiveRecord {

    public static function tableName() {
        return '{{%request}}';
    }

    public function GetSender() {
        return $this->hasOne(User::className(), ['id' => 'sender_id']);
    }

    public static function getByID($id){
        return static::find()->where(['id' => $id])->one();
    }

    public static function getAllUnverifiedRequests(){
        return static::find()->where(['status' => 0])->all();
    }

    // Меняет статус заявки, 0-необработанная заявка, 1-одобренная заявка, 2-отклоненная заявка
    public function changeRequestStatus($status){
        $this->status = $status;
        $this->save();
        $news = new News;
        $news->user_id = $this->sender_id;
        if($status == 1){
            $news->text = "Ваша заявка была одобрена";
            $user = User::findIdentity($this->sender_id);
            $user->addAdminStatus();
            $message = 'Заявка одобрена';
        } else {
            $news->text = "Ваша заявка была отклонена";
            $message = 'Заявка отклонена';
        }
        $news->save();
        return $message;
    }

    public static function  checkUserRequest($id){
        return static::find()->where(['sender_id' => $id, 'status'=> 0])->all();
    }

}
