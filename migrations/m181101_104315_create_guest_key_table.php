<?php

use yii\db\Migration;

/**
 * Handles the creation of table `guest_key`.
 * Has foreign keys to the tables:
 *
 * - `guest`
 * - `key`
 */
class m181101_104315_create_guest_key_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('guest_key', [
            'id' => $this->primaryKey(),
            'guest_id' => $this->integer()->notNull(),
            'key_id' => $this->integer()->notNull(),
            'date' => $this->date(),
        ]);

        // creates index for column `guest_id`
        $this->createIndex(
            'idx-guest_key-guest_id',
            'guest_key',
            'guest_id'
        );

        // add foreign key for table `guest`
        $this->addForeignKey(
            'fk-guest_key-guest_id',
            'guest_key',
            'guest_id',
            'guest',
            'id',
            'CASCADE'
        );

        // creates index for column `key_id`
        $this->createIndex(
            'idx-guest_key-key_id',
            'guest_key',
            'key_id'
        );

        // add foreign key for table `key`
        $this->addForeignKey(
            'fk-guest_key-key_id',
            'guest_key',
            'key_id',
            'key',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `guest`
        $this->dropForeignKey(
            'fk-guest_key-guest_id',
            'guest_key'
        );

        // drops index for column `guest_id`
        $this->dropIndex(
            'idx-guest_key-guest_id',
            'guest_key'
        );

        // drops foreign key for table `key`
        $this->dropForeignKey(
            'fk-guest_key-key_id',
            'guest_key'
        );

        // drops index for column `key_id`
        $this->dropIndex(
            'idx-guest_key-key_id',
            'guest_key'
        );

        $this->dropTable('guest_key');
    }
}
