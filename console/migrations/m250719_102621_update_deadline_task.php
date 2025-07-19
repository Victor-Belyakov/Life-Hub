<?php

use yii\db\Migration;

class m250719_102621_update_deadline_task extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('{{%task}}', 'deadline', $this->dateTime()->null()->comment('Срок выполнения'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('{{%task}}', 'deadline', $this->date()->null()->comment('Срок выполнения'));
    }
}
