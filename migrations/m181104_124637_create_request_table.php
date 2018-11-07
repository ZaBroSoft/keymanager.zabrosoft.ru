<?php

use yii\db\Migration;

/**
 * Handles the creation of table `request`.
 * Has foreign keys to the tables:
 *
 * - `key`
 * - `guest`
 */
class m181104_124637_create_request_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('request', [
            'id' => $this->primaryKey(),
            'key_id' => $this->integer(),
            'guest_id' => $this->integer(),
            'name' => $this->string(),
            'post' => $this->string(),
            'type' => $this->integer(2),
            'access' => $this->integer(2),
            'bracelet' => $this->integer(2),
            'vip' => $this->integer(2),
            'other' => $this->text(),
            'status' => $this->integer(2),
        ]);

        // creates index for column `key_id`
        $this->createIndex(
            'idx-request-key_id',
            'request',
            'key_id'
        );

        // add foreign key for table `key`
        $this->addForeignKey(
            'fk-request-key_id',
            'request',
            'key_id',
            'key',
            'id',
            'CASCADE'
        );

        // creates index for column `guest_id`
        $this->createIndex(
            'idx-request-guest_id',
            'request',
            'guest_id'
        );

        // add foreign key for table `guest`
        $this->addForeignKey(
            'fk-request-guest_id',
            'request',
            'guest_id',
            'guest',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `key`
        $this->dropForeignKey(
            'fk-request-key_id',
            'request'
        );

        // drops index for column `key_id`
        $this->dropIndex(
            'idx-request-key_id',
            'request'
        );

        // drops foreign key for table `guest`
        $this->dropForeignKey(
            'fk-request-guest_id',
            'request'
        );

        // drops index for column `guest_id`
        $this->dropIndex(
            'idx-request-guest_id',
            'request'
        );

        $this->dropTable('request');
    }
}
