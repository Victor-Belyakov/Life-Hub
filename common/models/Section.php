<?php

namespace common\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\Expression;

/**
 * @property int $id
 * @property string $name
 * @property string $created_at
 *
 * @property Record[] $entries
 */
class Section extends AbstractModel
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return 'section';
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => null,
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['name'], 'required'],
            ['createdAt', 'safe'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @return string[]
     */
    public function attributeLabels(): array
    {
        return [
            'name' => 'Наименование раздела'
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getEntries(): ActiveQuery
    {
        return $this->hasMany(Record::class, ['section_id' => 'id']);
    }
}
