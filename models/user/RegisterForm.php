<?php
namespace app\models\user;
use Yii;
use yii\base\Model;
use app\models\User;


class RegisterForm extends Model
{
    public $username;
    public $email;
    public $password;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\app\models\User', 'message' => 'Пользователь с таким логином уже существует.'],
            ['username', 'string', 'min' => 2, 'max' => 255],
            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\app\models\User', 'message' => 'Пользователь с таким email уже существует.'],
            ['password', 'required'],
            ['password', 'string', 'min' => 6],
        ];
    }

    public function attributeLabels()
    {
        return [

            'username' => 'Логин',
            'email' => 'Почта',
            'password' => 'Пароль',

        ];
    }


    /**
     * Registers user
     *
     * @return User|null the saved model or null if saving fails
     */
    public function register()
    {
        if (!$this->validate()) {
            return null;
        }

        $user = new User();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->setPassword($this->password);
        $user->generateAuthKey();

        return $user->save() ? $user : null;
    }
    
    public function verificateMail($user){
        Yii::$app->mailer->compose('verificationMail', [
            'user' => $user  
        ])        
        ->setFrom('test@domain.com')
        ->setTo($user->email)
        ->setSubject('Подтверждение регистрации')
        ->send();
    }
}