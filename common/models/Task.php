<?php

namespace common\models;

use frontend\enum\task\TaskPriorityEnum;
use frontend\enum\task\TaskStatusEnum;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * @property int $id
 * @property string $title
 * @property string|null $description
 * @property string $status
 * @property string $priority
 * @property int|null $executor_id
 * @property int $creator_id
 * @property string|null $deadline
 * @property string $created_at
 * @property string|null $updated_at
 *
 * @property User $creator
 * @property User $executor
 */
class Task extends AbstractModel
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return 'task';
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

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->deadline) {
                $date = new \DateTime($this->deadline);

                $time = $date->format('H:i:s');
                if ($time === '00:00:00') {
                    $date->setTime(23, 59, 59);
                }

                $this->deadline = $date->format('Y-m-d H:i:s');
            }
            return true;
        }
        return false;
    }

    public function beforeValidate()
    {
        if (parent::beforeValidate()) {
            // Устанавливаем creator_id если он не задан
            if (empty($this->creator_id)) {
                $this->creator_id = Yii::$app->user->getId();
            }
            return true;
        }
        return false;
    }


    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['title', 'priority'], 'required'],
            [['description'], 'string'],
            [['executor_id', 'creator_id'], 'integer'],
            [['deadline', 'created_at', 'updated_at'], 'safe'],
            [['title'], 'string', 'max' => 255],
            [['status'], 'default', 'value' => TaskStatusEnum::NEW],
            [['creator_id'], 'default', 'value' => Yii::$app->user->getId()],
//            [['status'], 'in', 'range' => array_map(static fn($enum) => $enum->value, TaskStatusEnum::cases())],
            [['priority'], 'in', 'range' => array_map(static fn($enum) => $enum->value, TaskPriorityEnum::cases())],
        ];
    }

    /**
     * @return string[]
     */
    public function attributeLabels(): array
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
     * @return ActiveQuery
     */
    public function getExecutor(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'executor_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getCreator(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'creator_id']);
    }
}
