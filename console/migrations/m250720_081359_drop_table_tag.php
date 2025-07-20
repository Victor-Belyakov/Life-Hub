<?php

use yii\db\Migration;

class m250720_081359_drop_table_tag extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropForeignKey('pk_record_tag', 'record_tag', ['record_id', 'tag_id']);
        $this->dropForeignKey('fk_record_tag_record', 'record_tag', 'record_id', 'record', 'id', 'CASCADE');
        $this->dropForeignKey('fk_record_tag_tag', 'record_tag', 'tag_id', 'tag', 'id', 'CASCADE');
        $this->dropTable('tag');
        $this->dropTable('record_tag');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->createTable('tag', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
        ]);

        $this->createTable('record_tag', [
            'record_id' => $this->integer()->notNull(),
            'tag_id' => $this->integer()->notNull(),
        ]);

        $this->addPrimaryKey('pk_record_tag', 'record_tag', ['record_id', 'tag_id']);
        $this->addForeignKey('fk_record_tag_record', 'record_tag', 'record_id', 'record', 'id', 'CASCADE');
        $this->addForeignKey('fk_record_tag_tag', 'record_tag', 'tag_id', 'tag', 'id', 'CASCADE');
    }
}
