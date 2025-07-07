<?php

namespace common\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property string $name
 *
 * @property Entry[] $entries
 */
class Tag extends ActiveRecord
{
    public static function tableName()
    {
        return 'tag';
    }

    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    public function getEntryTags(): ActiveQuery
    {
        return $this->hasMany(EntryTag::class, ['tag_id' => 'id']);
    }

    public function getEntries(): ActiveQuery
    {
        return $this->hasMany(Entry::class, ['id' => 'entry_id'])->via('entryTags');
    }
}
