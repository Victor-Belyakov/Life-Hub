<?php

use yii\db\Migration;

class m250722_093513_update_time_record extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('{{%record}}', 'created_at', $this->dateTime()->null()->comment('Дата создания'));
        $this->alterColumn('{{%record}}', 'updated_at', $this->dateTime()->null()->comment('Дата обновления'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('{{%record}}', 'created_at', $this->date()->null()->comment('Дата создания'));
        $this->alterColumn('{{%record}}', 'updated_at', $this->date()->null()->comment('Дата обновления'));
    }
}
