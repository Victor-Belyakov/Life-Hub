<?php

use yii\db\Migration;

class m250802_072925_create_table_sport extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // Таблица упражнений (справочник)
        $this->createTable('exercise', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull()->unique(),
        ]);

        // Таблица тренировок
        $this->createTable('sport', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'date' => $this->dateTime()->notNull(),
            'exercise_id' => $this->integer()->notNull(),
            'note' => $this->text(),
            'created_at' => $this->dateTime()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);

        // Таблица подходов
        $this->createTable('sport_set', [
            'id' => $this->primaryKey(),
            'sport_id' => $this->integer()->notNull(),
            'set_number' => $this->integer()->notNull(),
            'reps' => $this->integer()->notNull(),
            'weight' => $this->float()->defaultValue(0),
        ]);

        // Внешние ключи
        $this->addForeignKey('fk-sport-exercise', 'sport', 'exercise_id', 'exercise', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk-sport_set-result', 'sport_set', 'sport_id', 'sport', 'id', 'CASCADE', 'CASCADE');
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk-sport_set-result', 'sport_set');
        $this->dropForeignKey('fk-sport-exercise', 'sport');
        $this->dropTable('sport_set');
        $this->dropTable('sport');
        $this->dropTable('exercise');

        return true;
    }
}
