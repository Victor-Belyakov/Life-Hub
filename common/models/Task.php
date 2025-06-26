<?php

namespace common\models;

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
 * @property string|null $deadline
 * @property string $created_at
 * @property string|null $updated_at
 *
 * @property User|null $executor
 */
class Task extends ActiveRecord
{
    const STATUS_NEW = 'new';
    const STATUS_IN_PROGRESS = 'in_progress';
    const STATUS_DONE = 'done';
    const STATUS_CANCELED = 'canceled';

    const PRIORITY_LOW = 'low';
    const PRIORITY_MEDIUM = 'medium';
    const PRIORITY_HIGH = 'high';

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
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if (is_string($this->deadline)) {
                // пытаемся распарсить дату в формате d-m-Y
                $date = \DateTime::createFromFormat('d-m-Y', $this->deadline);
                if ($date) {
                    $this->deadline = $date->format('Y-m-d');
                } else {
                    $this->deadline = null;
                }
            }
            return true;
        }
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'status', 'priority'], 'required'],
            [['description'], 'string'],
            [['executor_id'], 'integer'],
            [['deadline', 'created_at', 'updated_at'], 'safe'],
            [['title'], 'string', 'max' => 255],
            [['status'], 'in', 'range' => [self::STATUS_NEW, self::STATUS_IN_PROGRESS, self::STATUS_DONE, self::STATUS_CANCELED]],
            [['priority'], 'in', 'range' => [self::PRIORITY_LOW, self::PRIORITY_MEDIUM, self::PRIORITY_HIGH]],
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
            'deadline' => 'Срок выполнения',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата обновления',
        ];
    }

    /**
     * Получить исполнителя задачи
     * @return ActiveQuery
     */
    public function getExecutor()
    {
        return $this->hasOne(User::class, ['id' => 'executor_id']);
    }
}
