<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property int $section_id
 * @property string $title
 * @property string|null $content
 * @property string $type
 * @property string $status
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Section $section
 * @property Tag[] $tags
 */
class Entry extends ActiveRecord
{
    public static function tableName()
    {
        return 'entry';
    }

    public function rules()
    {
        return [
            [['section_id', 'title'], 'required'],
            [['section_id'], 'integer'],
            [['content'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['title', 'type', 'status'], 'string', 'max' => 255],
            ['type', 'default', 'value' => 'note'],
            ['status', 'default', 'value' => 'active'],
        ];
    }

    public function getSection()
    {
        return $this->hasOne(Section::class, ['id' => 'section_id']);
    }

    public function getEntryTags()
    {
        return $this->hasMany(EntryTag::class, ['entry_id' => 'id']);
    }

    public function getTags()
    {
        return $this->hasMany(Tag::class, ['id' => 'tag_id'])->via('entryTags');
    }
}
