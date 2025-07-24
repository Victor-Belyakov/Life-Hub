<?php

namespace common\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * @property int $id
 * @property int $section_id
 * @property string $title
 * @property string|null $content
 * @property string $type
 * @property string $status
 * @property string $created_at
 * @property string $updated_at
 * @property int $sort_order
 *
 * @property Section $section
 * @property Tag[] $tags
 */
class Record extends AbstractModel
{
    public static function tableName()
    {
        return 'record';
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

    public function rules()
    {
        return [
            [['section_id', 'title'], 'required'],
            [['section_id', 'sort_order'], 'integer'],
            [['content'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['title', 'type', 'status'], 'string', 'max' => 255],
            ['type', 'default', 'value' => 'note'],
            ['status', 'default', 'value' => 'active'],
        ];
    }

    /**
     * @return string[]
     */
    public function attributeLabels(): array
    {
        return [
            'section_id' => 'Раздел',
            'title' => 'Название',
            'content' => 'Контент',
            'type' => 'Тип',
            'status' => 'Статус',
            'sort_order' => 'Порядок',
        ];
    }

    public function getSection(): ActiveQuery
    {
        return $this->hasOne(Section::class, ['id' => 'section_id']);
    }
}
