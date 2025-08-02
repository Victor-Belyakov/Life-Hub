<?php

namespace common\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

class SportSet extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName()
    {
        return 'sport_set';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['sport_id', 'set_number', 'reps'], 'required'],
            [['sport_id', 'set_number', 'reps'], 'integer'],
            ['weight', 'number'],
            ['weight', 'default', 'value' => 0],
        ];
    }

    /**
     * @return string[]
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'sport_id' => 'Спорт',
            'set_number' => 'Номер подхода',
            'reps' => 'Кол-во повторений',
            'weight' => 'Вес',
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getResult(): ActiveQuery
    {
        return $this->hasOne(Sport::class, ['id' => 'sport_id']);
    }
}
