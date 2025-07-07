<?php

namespace common\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property string $name
 * @property string $created_at
 *
 * @property Entry[] $entries
 */
class Section extends ActiveRecord
{
    public static function tableName()
    {
        return 'section';
    }

    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    public function getEntries(): ActiveQuery
    {
        return $this->hasMany(Entry::class, ['section_id' => 'id']);
    }
}
