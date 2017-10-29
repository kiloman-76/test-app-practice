<?php

use yii\db\Migration;

/**
 * Class m171022_040530_addOperationTable
 */
class m171022_040530_addOperationTable extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('operation', [
            'id' => $this->primaryKey()->comment('Первичный ключ'),
            'sender_id' => $this->integer('5')->comment('Отправитель'),
            'sender_balance' => $this->integer('10')->comment('Баланс отправвителя'),
            'money' => $this->integer('10')->notNull()->comment('Сумма перевода'),
            'recipient_id' => $this->integer('5')->notNull()->comment('Получатель'),
            'recipient_balance' => $this->integer('10')->notNull()->comment('Баланс получателя'),
            'creation_data' => $this->integer('15')->notNull()->comment('Дата создания'),
            'creator_id' => $this->integer('5')->comment('Создатель'), 
        ]);
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('operation');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171022_040530_addOperationTable cannot be reverted.\n";

        return false;
    }
    */
}
