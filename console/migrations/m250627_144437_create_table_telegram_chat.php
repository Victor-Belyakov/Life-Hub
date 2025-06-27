<?php

use yii\db\Migration;

class m250627_144437_create_table_telegram_chat extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('user', 'chat_id');
        $this->createTable('telegram', [
            'id' => $this->primaryKey(),
            'chat_id' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull(),
            'telegram_user_id' => $this->integer()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('telegram_chat');
    }
}
