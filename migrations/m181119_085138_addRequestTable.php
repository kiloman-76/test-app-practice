<?php

use yii\db\Migration;

/**
 * Class m181119_085138_addRequestTable
 */
class m181119_085138_addRequestTable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->createTable('request', [
            'id' => $this->primaryKey()->comment('Первичный ключ'),
            'text' => $this->text()->comment('Текст заявки'),
            'sender' => $this->integer(100)->comment('ID отправителя'),
            'status' => $this->integer('2')->comment('Статус')->defaultValue(0),
            'creation_data' => 'datetime DEFAULT NOW()',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('request');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181119_085138_addRequestTable cannot be reverted.\n";

        return false;
    }
    */
}
