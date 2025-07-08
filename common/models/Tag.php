<?php

namespace common\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property string $name
 *
 * @property Record[] $entries
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

    public function getRecordTags(): ActiveQuery
    {
        return $this->hasMany(RecordTag::class, ['tag_id' => 'id']);
    }

    public function getRecords(): ActiveQuery
    {
        return $this->hasMany(Record::class, ['id' => 'record_id'])->via('recordTags');
    }
}
