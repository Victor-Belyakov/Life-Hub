<?php

use yii\db\Migration;

class m250722_104818_add_color_record extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250722_104818_add_color_record cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250722_104818_add_color_record cannot be reverted.\n";

        return false;
    }
    */
}
