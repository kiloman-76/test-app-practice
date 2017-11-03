<?php

namespace app\models\user;

use Yii;
use yii\base\Model;
use app\models\User;

class ResetPasswordForm extends Model {

    public $password;
    public $password_repeat;
    private $_user = false;

    /**
     * @return array the validation rules.
     */
    public function rules() {
        return [
            [['password', 'password_repeat'], 'required'],
            ['password', 'compare', 'compareAttribute' => 'password_repeat', 'message' => 'Пароли должны совпадать!'],
        ];
    }

    public function attributeLabels() {
        return [
            'password' => 'Пароль',
            'password_repeat' => 'Повторите пароль',
        ];
    }

    public function resetPassword() {
        if ($this->validate()) {
            return $this->password;
        }
    }

}
