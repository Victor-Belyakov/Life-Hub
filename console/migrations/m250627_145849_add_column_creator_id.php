<?php

use yii\db\Migration;

class m250627_145849_add_column_creator_id extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('task', 'creator_id', $this->integer()->notNull());

        $this->addForeignKey(
            'fk-task-creator_id',
            'task',
            'creator_id',
            'user',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-task-creator_id', 'task');
        $this->dropColumn('task', 'creator_id');
    }
}
