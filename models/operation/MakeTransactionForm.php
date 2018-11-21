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
class MakeTransactionForm extends Model {

    public $email;
    public $money;
    public $sender;

    /**
     * @return array the validation rules.
     */
    public function rules() {

        $current_email = $this->sender->email;
        $current_balance = $this->sender->balance;
        return [
            [['email', 'money'], 'required'],
            ['email', 'trim'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'exist', 'targetClass' => 'app\models\User', 'message' => 'Такого адреса нет в базе пользователей!'],
            ['email', 'compare', 'compareValue' => $current_email, 'operator' => '!=', 'message' => 'Вы не можете перевести деньги этому же пользователю!'],
            ['money', 'double', 'message' => 'Пожалуйста, введите число'],
            ['money', 'double', 'tooSmall' => 'Сумма отправки не может быть меньше копейки!', 'min' => 0.01],
            ['money', 'double', 'tooBig' => 'Сумма отправки не может превышать сумму средств счету пользователя!', 'max' => $current_balance,]
        ];
    }

    public function sendMoney($sender) {

        if ($this->validate()) {
            $operation = new Operation;

            $sender->changeBalance(-1 * $this->money);
            $sender->save();

            $operation->sender_id = $sender->id;
            $operation->sender_balance = $sender->balance;

            $recipient = User::findByEmail($this->email);
            $recipient->changeBalance($this->money);
            $recipient->save();

            $operation->recipient_id = $recipient->id;
            $operation->recipient_balance = $recipient->balance;

            $operation->money = $this->money;
            $operation->creation_data = date('U');
            $operation->creator_id = Yii::$app->user->identity->id;

            $operation->save();

            $news = new News;
            $news->createNews("C вашего счета было снято $this->money рублей администрацией",  $sender->id );
            $news = new News;
            $news->createNews("Вам начислено $this->money рублей от пользователя $sender->email", $recipient->id );
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
