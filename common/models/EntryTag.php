<?php

namespace common\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * @property int $entry_id
 * @property int $tag_id
 *
 * @property Entry $entry
 * @property Tag $tag
 */
class EntryTag extends ActiveRecord
{
    public static function tableName()
    {
        return 'entry_tag';
    }

    public function rules()
    {
        return [
            [['entry_id', 'tag_id'], 'required'],
            [['entry_id', 'tag_id'], 'integer'],
            [['entry_id', 'tag_id'], 'unique', 'targetAttribute' => ['entry_id', 'tag_id']],
        ];
    }

    public function getEntry(): ActiveQuery
    {
        return $this->hasOne(Entry::class, ['id' => 'entry_id']);
    }

    public function getTag(): ActiveQuery
    {
        return $this->hasOne(Tag::class, ['id' => 'tag_id']);
    }
}
