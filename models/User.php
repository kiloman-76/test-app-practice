<?php

namespace app\models;

use app\models\operation\Operation;


class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface {

    public static function tableName() {
        return '{{%user}}';
    }

    public function attributeLabels() {
        return [
            'username' => 'Логин',
            'balance' => 'Баланс',
        ];
    }

    public function GetSendedOperations() {
        return $this->hasMany(Operation::className(), ['sender_id' => 'id']);
    }

    public function GetRecipientOperations() {
        return $this->hasMany(Operation::className(), ['recipient_id' => 'id']);
    }

    public function GetCreatedOperations() {
        return $this->hasMany(Operation::className(), ['creator_id' => 'id']);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id) {
        return static::findOne(['id' => $id]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null) {
        foreach (self::$users as $user) {
            if ($user['accessToken'] === $token) {
                return new static($user);
            }
        }

        return null;
    }

    public static function GetRandomUsers(){
        $userArr = static::find()->where('id != :id', ['id'=>1])->all();
        $user = array_rand($userArr, 2);
        return array($userArr[$user[0]], $userArr[$user[1]]);

    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username) {
        return static::findOne(['username' => $username]);
    }
    
    public static function findUser($email) {
      
       return static::find()->filterWhere(['like', 'email', $email])->all();
    }

    public static function findByEmail($email) {
        return static::findOne(['email' => $email]);
    }

    /**
     * @inheritdoc
     */
    public function getId() {
        return $this->id;
    }

    public function generateAuthKey() {
        $this->auth_key = \Yii::$app->security->generateRandomString();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey() {
        return $this->auth_key;
    }

    public function getBalance() {
        return $this->balance;
    }

    public function changeBalance($sum) {
        $this->balance += $sum;
        $this->save();
    }

    public function addAdminStatus() {

        $this->status = 10;
        $this->save();

        $rbac = \Yii::$app->authManager;
        $admin = $rbac->getRole('admin');
        $rbac->assign($admin, $this->getId());

        $news = new News();
        $news->text = 'Вашему аккаунту были даны полномочия администратора';
        $news->user_id = $this->getId();
        $news->save();

        return true;
    }

    public function deleteAdminStatus() {

        $this->status = 1;
        $this->save();

        $rbac = \Yii::$app->authManager;
        $admin = $rbac->getRole('admin');
        $rbac->revoke($admin, $this->getId());

        $news = new News();
        $news->text = 'У вашего аккаунта были отозваны полномочия администратора';
        $news->user_id = $this->getId();
        $news->save();

        return true;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey) {
        return $this->authKey === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password) {
        return \Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    public function setPassword($password) {
        $this->password_hash = \Yii::$app->security->generatePasswordHash($password);
    }

    public function getOperationInfo() {
        $operations = Array();
        $operations['send'] = $this->getSumSended();
        $operations['recipient'] = $this->getSumRecipient();
        $operations['number'] = $this->getNumberOfOperations();
        return $operations;
    }

    public function getNumberOfOperations() {
        $count = 0;
        $operations = Operation::findUserOperation($this->id);
        foreach ($operations as $operation) {
            $count++;
        }
        return $count;
    }

    public function getSumSended() {
        $operations = $this->sendedOperations;
        $sum = 0;
        foreach ($operations as $operation) {
            $sum += $operation->money;
        }
        return $sum;
    }

    public function getSumRecipient() {
        $operations = $this->recipientOperations;
        $sum = 0;
        foreach ($operations as $operation) {
            $sum += $operation->money;
        }
        return $sum;
    }

}
