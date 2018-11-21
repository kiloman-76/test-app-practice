<?php

namespace app\models;


class News extends \yii\db\ActiveRecord {

    public static function tableName() {
        return '{{%news}}';
    }

    public function createNews($text, $user_id){
        $this->text = $text;
        $this->user_id = $user_id;
        $this->save();
    }

    public static function GetByID($id) {
        return static::find()->where(['id' => $id])->one();
    }

    public static function findUserUnreadNews($user_id) {
        return static::find()->where(['user_id' => $user_id, 'status' => 0])->all();
    }

    public function markAsRead(){
        $this->status = 1;
        $this->save();
    }



}
