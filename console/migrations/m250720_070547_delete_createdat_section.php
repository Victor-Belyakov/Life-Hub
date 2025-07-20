<?php

use yii\db\Migration;

class m250720_070547_delete_createdat_section extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('section', 'created_at');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('section', 'created_at', $this->dateTime());
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250720_070547_delete_createdat_section cannot be reverted.\n";

        return false;
    }
    */
}
