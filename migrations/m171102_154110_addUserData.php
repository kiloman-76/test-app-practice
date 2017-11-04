<?php

use yii\db\Migration;
use app\models\User;

/**
 * Class m171102_154110_addUserData
 */
class m171102_154110_addUserData extends Migration {

    /**
     * @inheritdoc
     */
    public function safeUp() {
        $this->insert('user', [
            'username' => 'admin',
            'email' => 'admin@mail.ru',
            'password_hash' => \Yii::$app->security->generatePasswordHash('admin'),
            'auth_key' => \Yii::$app->security->generateRandomString(),
            'balance' => 100,
            'status' => 1
        ]);

        $rbac = \Yii::$app->authManager;
        $admin = $rbac->getRole('admin');
        $rbac->assign($admin, 1);
    }

    /**
     * @inheritdoc
     */
    public function safeDown() {
        $this->delete('user', ['id' => 1]);
    }

    /*
      // Use up()/down() to run migration code without a transaction.
      public function up()
      {

      }

      public function down()
      {
      echo "m171102_154110_addUserData cannot be reverted.\n";

      return false;
      }
     */
}
