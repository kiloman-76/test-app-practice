<?php

use yii\db\Migration;

/**
 * Class m181119_081128_addNewsTable
 */
class m181119_081128_addNewsTable extends Migration
{
    /**
     * {@inheritdoc}
     */

    public function safeUp() {
        $this->createTable('news', [
            'id' => $this->primaryKey()->comment('Первичный ключ'),
            'user_id' => $this->integer('100')->comment('Получатель'),
            'text' => $this->text()->comment('Текст новости'),
            'status' => $this->integer('2')->comment('Статус')->defaultValue(0),
            'creation_data' => 'datetime DEFAULT NOW()',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('news');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181119_081128_addNewsTable cannot be reverted.\n";

        return false;
    }
    */
}
