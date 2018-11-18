<?php

namespace app\models\operation;

use app\models\User;

class Operation extends \yii\db\ActiveRecord {

    public static function tableName() {
        return '{{%operation}}';
    }

    public function GetSender() {
        return $this->hasOne(User::className(), ['id' => 'sender_id']);
    }

    public function GetRecipient() {
        return $this->hasOne(User::className(), ['id' => 'recipient_id']);
    }

    public function GetCreator() {
        return $this->hasOne(User::className(), ['id' => 'creator_id']);
    }

    public static function findUserOperation($user_id) {
        return static::find()->where(['sender_id' => $user_id])
                        ->orWhere(['recipient_id' => $user_id])->all();
    }

}
