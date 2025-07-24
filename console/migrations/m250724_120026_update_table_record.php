<?php

use yii\db\Migration;

class m250724_120026_update_table_record extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%record}}', 'sort_order', $this->integer()->defaultValue(0)->after('status'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%record}}', 'sort_order');
    }
}
