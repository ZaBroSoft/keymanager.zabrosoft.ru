<?php

use yii\db\Migration;

/**
 * Handles the creation of table `key`.
 */
class m181031_092452_create_key_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('key', [
            'id' => $this->primaryKey(),
            'number' => $this->integer()->notNull()->unique(),
            'status' => $this->integer(2),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('key');
    }
}
