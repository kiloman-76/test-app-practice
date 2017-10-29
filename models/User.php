<?php

namespace app\models;

use app\models\operation\Operation;

class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{


    
     public static function tableName()
    {
        return '{{%user}}';
    }
    
     public function GetSendedOperations(){
        return $this->hasMany(Operation::className(), ['sender_id' => 'id']);
    }
    
     public function GetRecipientOperations(){
        return $this->hasMany(Operation::className(), ['recipient_id' => 'id']);
    }
    
     public function GetCreatedOperations(){
        return $this->hasMany(Operation::className(), ['creator_id' => 'id']);
    }
    
    
    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        foreach (self::$users as $user) {
            if ($user['accessToken'] === $token) {
                return new static($user);
            }
        }

        return null;
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);

    }
    
       public static function findByEmail($email)
    {
        return static::findOne(['email' => $email]);

    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }
    
    public function generateAuthKey(){
        $this->auth_key = \Yii::$app->security->generateRandomString();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }
    
    public function getBalance()
    {
        return $this->balance;
    }
    
    public function changeBalance($sum){
        $this->balance += $sum;
        $this->save();
    }
    
    public function addAdminStatus(){
        
        $this->status = 10;
        $this->save();
        
        $rbac = \Yii::$app->authManager;
        $admin = $rbac->getRole('admin');
        $rbac->assign($admin,$this->getId());
        
               
        return true;
    }
    
     public function deleteAdminStatus(){
         
        $this->status = 1;
        $this->save(); 
         
        $rbac = \Yii::$app->authManager;
        $admin = $rbac->getRole('admin');
        $rbac->revoke($admin,$this->getId());
        
        
        return true;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return \Yii::$app->security->validatePassword($password, $this->password_hash);
    }
    
     public function setPassword($password)
     {
         $this->password_hash = \Yii::$app->security->generatePasswordHash($password);
     }
}
