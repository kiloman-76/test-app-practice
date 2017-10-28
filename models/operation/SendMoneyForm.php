<?php

namespace app\models\operation;

use Yii;
use yii\base\Model;
use app\models\User;
use app\models\operation\Operation;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class SendMoneyForm extends Model
{
    public $email;
    public $money;
    
    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        $current_email = Yii::$app->user->identity->email;;
        $current_balance = Yii::$app->user->identity->balance;
        
        return [
            [['email', 'money'], 'required'],
            ['email', 'trim'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'exist', 'targetClass' => 'app\models\User', 'message' => 'Такого адреса нет в системе'],
            ['email', 'compare', 'compareValue' => $current_email, 'operator' => '!=', 'message' => 'Вы не можете перевести деньги самому себе!'],
            
            ['money','double', 'message' => 'Пожалуйста, введите число'],
            ['money','double','message' => 'Сумма не может быть меньше 1 копейки','min'=>0.01],
            ['money','double','message' => 'Сумма отправки не может превышать сумму средств на вашем счету','max'=>$current_balance, ],
        ];
    }
    
     public function attributeLabels()
    {
        return [
            'username' => 'Логин',
            'password' => 'Пароль',
            'rememberMe' => 'Запомнить меня',
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
    public function sendMoney() {
        if ($this->validate()) {
            $operation = new Operation;
            $sender = User::findIdentity(Yii::$app->user->identity->id);
            
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
            $operation->creator_id = $sender->id;
            
            
            $operation->save();
            return true;
        }
        return false;
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = User::findByUsername($this->username);
        }

        return $this->_user;
    }
}
