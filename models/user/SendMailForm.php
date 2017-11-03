<?php

namespace app\models\user;

use Yii;
use yii\base\Model;
use app\models\User;

class SendMailForm extends Model {

    public $email;
    private $_user = false;

    /**
     * @return array the validation rules.
     */
    public function rules() {
        return [
            ['email', 'validateEmail'],
        ];
    }

    public function attributeLabels() {
        return [
            'email' => 'Почта',
        ];
    }

    public function validateEmail($attribute, $params) {
        if (!$this->hasErrors()) {
            $user = $this->getUser();

            if (!$user) {
                $this->addError($attribute, 'Такого почтового адреса нет');
            }
        }
    }

    public function getUser() {
        if ($this->_user === false) {
            $this->_user = User::findByEmail($this->email);
        }

        return $this->_user;
    }

    public function sendMail() {
        if (!$this->validate()) {
            return null;
        }

        $user = $this->getUser();

        Yii::$app->mailer->compose('resetPasswordMail', [
                    'user' => $user
                ])
                ->setFrom('test@domain.com')
                ->setTo($user->email)
                ->setSubject('Смена пароля')
                ->send();

        return true;
    }

}
