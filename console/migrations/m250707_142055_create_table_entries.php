<?php

use yii\db\Migration;

class m250707_142055_create_table_entries extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('section', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'created_at' => $this->integer()->notNull(),
        ]);

        $this->createTable('record', [
            'id' => $this->primaryKey(),
            'section_id' => $this->integer()->notNull(),
            'title' => $this->string()->notNull(),
            'content' => $this->text(),
            'type' => $this->string()->defaultValue('note'),
            'status' => $this->string()->defaultValue('active'),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);


        $this->addForeignKey('fk_entries_sections', 'record', 'section_id', 'section', 'id', 'CASCADE');

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

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // Удаляем внешние ключи и таблицы в обратном порядке
        $this->dropForeignKey('fk_record_tag_tag', 'record_tag');
        $this->dropForeignKey('fk_record_tag_record', 'record_tag');
        $this->dropPrimaryKey('pk_record_tag', 'record_tag');
        $this->dropTable('record_tag');

        $this->dropTable('tag');

        $this->dropForeignKey('fk_entries_sections', 'record');
        $this->dropTable('record');

        $this->dropTable('section');
    }

}
