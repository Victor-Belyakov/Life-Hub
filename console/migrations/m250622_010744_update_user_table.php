<?php

use yii\db\Migration;

class m250622_010744_update_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute('ALTER TABLE {{%user}} ALTER COLUMN created_at TYPE timestamp USING to_timestamp(created_at)');
        $this->execute('ALTER TABLE {{%user}} ALTER COLUMN updated_at TYPE timestamp USING to_timestamp(updated_at)');
        // Для birth_date просто кастим дату в timestamp, без to_timestamp
        $this->execute('ALTER TABLE {{%user}} ALTER COLUMN birth_date TYPE timestamp USING birth_date::timestamp');

        $this->alterColumn('{{%user}}', 'created_at', $this->timestamp()->null());
        $this->alterColumn('{{%user}}', 'updated_at', $this->timestamp()->null());
        $this->alterColumn('{{%user}}', 'birth_date', $this->timestamp()->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->execute('ALTER TABLE {{%user}} ALTER COLUMN created_at TYPE integer USING extract(epoch from created_at)::integer');
        $this->execute('ALTER TABLE {{%user}} ALTER COLUMN updated_at TYPE integer USING extract(epoch from updated_at)::integer');
        // Для birth_date приводим обратно к дате
        $this->execute('ALTER TABLE {{%user}} ALTER COLUMN birth_date TYPE date USING birth_date::date');

        $this->alterColumn('{{%user}}', 'created_at', $this->integer()->null());
        $this->alterColumn('{{%user}}', 'updated_at', $this->integer()->null());
        $this->alterColumn('{{%user}}', 'birth_date', $this->date()->null());
    }
}
