<?php

namespace common\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * @property int $entry_id
 * @property int $tag_id
 *
 * @property Record $entry
 * @property Tag $tag
 */
class RecordTag extends ActiveRecord
{
    public static function tableName()
    {
        return 'record_tag';
    }

    public function rules()
    {
        return [
            [['record_id', 'tag_id'], 'required'],
            [['record_id', 'tag_id'], 'integer'],
            [['record_id', 'tag_id'], 'unique', 'targetAttribute' => ['record_id', 'tag_id']],
        ];
    }

    public function getRecord(): ActiveQuery
    {
        return $this->hasOne(Record::class, ['id' => 'record_id']);
    }

    public function getTag(): ActiveQuery
    {
        return $this->hasOne(Tag::class, ['id' => 'tag_id']);
    }
}
