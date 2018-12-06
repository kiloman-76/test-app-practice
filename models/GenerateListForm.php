<?php

namespace app\models;
use app\models\operation\Operation;
use Faker\Provider\Person;
use Yii;
use yii\base\Model;
use app\models\User;
/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class GenerateListForm extends Model {

    public $users;
    public $operations;

    /**
     * @return array the validation rules.
     */
    public function rules() {
        return [
            [['users', 'operations'], 'required'],

            ['users', 'integer', 'message' => 'Пожалуйста, введите число'],
            ['users', 'integer', 'tooSmall' => 'Количество пользователей не должно быть меньше 15', 'min' => 1],
            ['users', 'integer', 'tooBig' => 'Количество пользователей не должно быть больше 1000', 'max' => 1000,],

            ['operations', 'integer', 'message' => 'Пожалуйста, введите число'],
            ['operations', 'integer', 'tooSmall' => 'Количество операций не должно быть меньше 10', 'min' => 1],
            ['operations', 'integer', 'tooBig' => 'Количество операций не должно быть больше 1000', 'max' => 1000,],
        ];
    }

    public function attributeLabels() {
        return [
            'users' => 'Количество пользователей',
            'operations' => 'Количество операций',
        ];
    }

    public function generateList()
    {
        if ($this->validate()) {
            require __DIR__ . '/../vendor/autoload.php';
            $faker = \Faker\Factory::create();
            while ($this->users > 0) {
                $randString = \Yii::$app->security->generateRandomString(6);
                $user = new User();

                $user->username = 'user_' . $randString;
                $user->email = $faker->freeEmail;
                $user->setPassword($randString);
                $user->generateAuthKey();

                $user->save();
                $this->users--;
            }
            while ($this->operations > 0) {

                $transaction = Yii::$app->db->beginTransaction();
                $money = rand(1,100)/100;

                try{
                    $usersArr = User::GetRandomUsers();
                    Yii::info('$usersArr');
                    Yii::info($usersArr);
                    $operation = new Operation();
                    $sender = User::findIdentity($usersArr[0]['id']);
                    $recipient = User::findIdentity($usersArr[1]['id']);
                    Yii::info('$recipient');
                    Yii::info($recipient);
                    if($sender->balance < 5){
                        $operationAdd = new Operation;
                        $admin_id = 1;

                        $sender->changeBalance(100);
                        $sender->save();
                        $operationAdd->recipient_id = $sender->id;
                        $operationAdd->recipient_balance = $sender->balance;

                        $operationAdd->money = 100;
                        $operationAdd->creation_data = date('U');
                        $operation->creator_id = $admin_id;

                        $operationAdd->save();

                        $news = new News;
                        $news->createNews("На ваш счет добавлено 100 рублей", $sender->id);
                    }

                    $sender->changeBalance(-1 * $money);
                    $sender->save();
                    $operation->sender_id = $sender->id;
                    $operation->sender_balance = $sender->balance;

                    Yii::info('$recipient');
                    Yii::info($recipient);
                    $recipient->changeBalance($money);
                    $recipient->save();
                    $operation->recipient_id = $recipient->id;
                    $operation->recipient_balance = $recipient->balance;

                    $operation->money = $money;
                    $operation->creation_data = date('U');
                    $operation->creator_id = $sender->id;
                    $operation->save();

                    $news = new News;
                    $news->createNews("Вам начислено $money рублей от пользователя $sender->email" ,$recipient->id);

                    $transaction->commit();
                } catch (\Exception $e){
                    $transaction->rollback();
                }


                $this->operations--;
            }
            return true;
        }
        return false;
    }
    /**
     * Logs in a user using the provided username and password.
     * @return bool whether the user is logged in successfully
     */
    public function login() {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
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
