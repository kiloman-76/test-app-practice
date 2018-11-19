<?php

namespace app\models;


class News extends \yii\db\ActiveRecord {

    public static function tableName() {
        return '{{%news}}';
    }

    public static function findUserNews($user_id) {
        return static::find()->where(['user_id' => $user_id])->all();
    }

}
