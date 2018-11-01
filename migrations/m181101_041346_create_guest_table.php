<?php

use yii\db\Migration;

/**
 * Handles the creation of table `guest`.
 */
class m181101_041346_create_guest_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('guest', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull()->unique(),
            'post' => $this->string(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('guest');
    }
}
