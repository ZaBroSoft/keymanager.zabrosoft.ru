<?php

use yii\db\Migration;

/**
 * Handles adding date to table `request`.
 */
class m181106_035333_add_date_column_to_request_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('request', 'date', $this->date());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('request', 'date');
    }
}
