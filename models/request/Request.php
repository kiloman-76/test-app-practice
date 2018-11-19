<?php

namespace app\models\request;


class Request extends \yii\db\ActiveRecord {

    public static function tableName() {
        return '{{%request}}';
    }

    public static function findUserNews($user_id) {
        return static::find()->where(['user_id' => $user_id])->all();
    }

}
