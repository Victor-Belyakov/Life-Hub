<?php

namespace common\models;

use yii\db\ActiveQuery;

/**
 * @property int $id
 * @property string $name
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

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['name'], 'required'],
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
