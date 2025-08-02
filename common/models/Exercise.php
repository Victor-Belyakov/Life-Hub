<?php

namespace common\models;

use yii\db\ActiveQuery;

class Exercise extends AbstractModel
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return 'exercise';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            ['name', 'required'],
            ['name', 'string', 'max' => 255],
            ['name', 'unique'],
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getSportResults(): ActiveQuery
    {
        return $this->hasMany(Sport::class, ['exercise_id' => 'id']);
    }
}
