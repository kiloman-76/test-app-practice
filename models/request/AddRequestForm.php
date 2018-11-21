<?php

namespace app\models\request;

use Yii;
use yii\base\Model;
use app\models\User;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class AddRequestForm extends Model {

    public $text;

    /**
     * @return array the validation rules.
     */
    public function rules() {

        return [
            ['text', 'trim'],
            ['text', 'string'],
        ];
    }

    public function attributeLabels() {
        return [
            'text' => 'Текст заявки',
        ];
    }


    public function sendRequest($sender) {

        if ($this->validate()) {
            $request = new Request();
            $request->sender_id = $sender->id;
            $request->text = $this->text;
            $request->save();

            return true;
        }
        return false;
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser() {
        if ($this->_user === false) {
            $this->_user = User::findByUsername($this->username);
        }

        return $this->_user;
    }

}
