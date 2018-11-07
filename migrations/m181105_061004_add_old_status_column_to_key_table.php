<?php

use yii\db\Migration;

/**
 * Handles adding old_status to table `key`.
 */
class m181105_061004_add_old_status_column_to_key_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('key', 'old_status', $this->integer(2));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('key', 'old_status');
    }
}
