<?php

use yii\db\Migration;

/**
 * Class m171016_160507_createRoles
 */
class m171016_160507_createRoles extends Migration {

    /**
     * @inheritdoc
     */
    public function safeUp() {
        $rbac = \Yii::$app->authManager;

        $user = $rbac->createRole('user');
        $user->description = 'Посетитель';
        $rbac->add($user);

        $admin = $rbac->createRole('admin');
        $admin->description = 'Может всё';
        $rbac->add($admin);

        $rbac->addChild($admin, $user);

//        $rbac->assign(
//            $admin,
//            \app\models\User::findOne([
//                'username' => 'php'])->id
//        );
    }

    /**
     * @inheritdoc
     */
    public function safeDown() {
        $manager = \Yii::$app->authManager;
        $manager->removeAll();
    }

    /*
      // Use up()/down() to run migration code without a transaction.
      public function up()
      {

      }

      public function down()
      {
      echo "m171016_160507_createRoles cannot be reverted.\n";

      return false;
      }
     */
}
