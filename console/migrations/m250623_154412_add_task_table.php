<?php

use yii\db\Migration;

class m250623_154412_add_task_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%task}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255)->notNull()->comment('Название задачи'),
            'description' => $this->text()->null()->comment('Описание'),
            "status" => $this->string(20)->notNull()->comment('Статус задачи'),
            'priority' => $this->string(20)->notNull()->comment('Приоритет задачи'),
            'executor_id' => $this->integer()->null()->comment('Исполнитель'),
            'deadline' => $this->date()->null()->comment('Срок выполнения'),
            'created_at' => $this->timestamp()->notNull(),
            'updated_at' => $this->timestamp()->notNull(),
        ]);

        $this->createIndex('idx-task-executor_id', '{{%task}}', 'executor_id');

        $this->addForeignKey(
            'fk-task-executor_id',
            '{{%task}}',
            'executor_id',
            '{{%user}}',
            'id',
            'SET NULL',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-task-executor_id', '{{%task}}');
        $this->dropIndex('idx-task-executor_id', '{{%task}}');
        $this->dropTable('{{%task}}');
    }
}
