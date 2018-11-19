<?php

namespace app\models\operation;

use Yii;
use yii\base\Model;
use app\models\User;
use app\models\operation\Operation;
use app\models\News;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class AddMoneyForm extends Model {

    public $money;

    /**
     * @return array the validation rules.
     */
    public function rules() {
        return [
            ['money', 'required', 'message' => 'Сумма перевода не может быть пустой!'],
            ['money', 'double', 'message' => 'Пожалуйста, введите число'],
            ['money', 'double', 'tooSmall' => 'Сумма отправки не может быть меньше копейки!', 'min' => 0.01],
            ['money', 'match', 'pattern' => '/^\d+(.\d{1,2})?$/', 'message' => 'Не более двух знаков после запятой!']
        ];
    }

    public function attributeLabels() {
        return [
            'money' => 'Сумма перевода',
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */

    /**
     * Logs in a user using the provided username and password.
     * @return bool whether the user is logged in successfully
     */
    public function addMoney($recipient) {
        if ($this->validate()) {
            $operation = new Operation;
            $admin_id = Yii::$app->user->identity->id;

            $recipient->changeBalance($this->money);
            $recipient->save();
            $operation->recipient_id = $recipient->id;
            $operation->recipient_balance = $recipient->balance;

            $operation->money = $this->money;
            $operation->creation_data = date('U');
            $operation->creator_id = $admin_id;

            $operation->save();

            $news = new News;
            $news->user_id = $recipient->id;
            $news->text = "На ваш счет добавлено $this->money рублей";
            $news->save();
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
