<?php

namespace common\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\Expression;

class Sport extends AbstractModel
{
    public static function tableName()
    {
        return 'sport';
    }

    /**
     * @return array[]
     */
    public function behaviors(): array
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'value' => new Expression('NOW()'),
            ]
        ];
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['user_id', 'date', 'exercise_id'], 'required'],
            [['user_id', 'exercise_id'], 'integer'],
            ['note', 'string'],
            [['created_at', 'date'], 'safe'],
            ['exercise_id', 'exist', 'targetClass' => Exercise::class, 'targetAttribute' => 'id'],
            ['user_id', 'exist', 'targetClass' => User::class, 'targetAttribute' => 'id'],
        ];
    }

    /**
     * @return string[]
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'user_id' => 'Пользователь',
            'exercise_id' => 'Упражнение',
            'date' => 'Дата тренировки',
            'note' => 'Примечание',
            'created_at' => 'Дата создания',
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getExercise(): ActiveQuery
    {
        return $this->hasOne(Exercise::class, ['id' => 'exercise_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getSets(): ActiveQuery
    {
        return $this->hasMany(SportSet::class, ['sport_id' => 'id'])->orderBy('set_number');
    }
}
