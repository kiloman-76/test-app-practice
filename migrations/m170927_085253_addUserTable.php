<?php

use yii\db\Migration;

/**
 * Class m170927_085253_addUserTable
 */
class m170927_085253_addUserTable extends Migration {

    /**
     * @inheritdoc
     */
    public function safeUp() {
        $this->createTable('user', [
            'id' => $this->primaryKey()->comment('Первичный ключ'),
            'username' => $this->string('200')->notNull()->comment('Имя'),
            'email' => $this->string('200')->notNull()->comment('Почтовый адрес'),
            'password_hash' => $this->string('200')->notNull()->comment('Пароль'),
            'auth_key' => $this->string('200')->notNull()->comment('Ключ авторизации'),
            'balance' => $this->float('2')->comment('Баланс')->defaultValue(100),
            'status' => $this->integer('2')->comment('Статус')->defaultValue(1),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function safeDown() {
        $this->dropTable('user');
    }

    /*
      // Use up()/down() to run migration code without a transaction.
      public function up()
      {

      }

      public function down()
      {
      echo "m170927_085253_addUserTable cannot be reverted.\n";

      return false;
      }
     */
}
