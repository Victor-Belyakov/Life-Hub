<?php

namespace common\models;

use common\behaviors\DateFormatBehavior;
use frontend\enum\TaskPriorityEnum;
use frontend\enum\TaskStatusEnum;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "task".
 *
 * @property int $id
 * @property string $title
 * @property string|null $description
 * @property string $status
 * @property string $priority
 * @property int|null $executor_id
 * @property int $creator_id
 * @property User $creator
 * @property string|null $deadline
 * @property string $created_at
 * @property string|null $updated_at
 *
 * @property User|null $executor
 */
class Task extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'task';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'value' => new Expression('NOW()'),
            ],
            [
                'class' => DateFormatBehavior::class,
                'attributes' => ['deadline'],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'status', 'priority', 'creator_id'], 'required'],
            [['description'], 'string'],
            [['executor_id', 'creator_id'], 'integer'],
            [['deadline', 'created_at', 'updated_at'], 'safe'],
            [['title'], 'string', 'max' => 255],
            [['status'], 'in', 'range' => array_map(static fn($enum) => $enum->value, TaskStatusEnum::cases())],
            [['priority'], 'in', 'range' => array_map(static fn($enum) => $enum->value, TaskPriorityEnum::cases())],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Название',
            'description' => 'Описание',
            'status' => 'Статус',
            'priority' => 'Приоритет',
            'executor_id' => 'Исполнитель',
            'creator_id' => 'Постановщик задачи',
            'deadline' => 'Срок выполнения',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата обновления',
        ];
    }

    /**
     * Получить исполнителя задачи
     * @return ActiveQuery
     */
    public function getExecutor(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'executor_id']);
    }

    /**
     * Получить постановщика задачи
     * @return ActiveQuery
     */
    public function getCreator(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'creator_id']);
    }
}
