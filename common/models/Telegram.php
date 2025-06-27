<?php

namespace common\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 *
 * @property int $id
 * @property string $chat_id
 * @property int $user_id
 * @property int $telegram_user_id
 *
 * @property User $user
 */
class Telegram extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'telegram';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['chat_id', 'user_id', 'telegram_user_id'], 'required'],
            [['user_id', 'telegram_user_id'], 'integer'],
            [['chat_id'], 'string', 'max' => 255],
            [['telegram_user_id'], 'unique'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'chat_id' => 'Chat ID',
            'user_id' => 'Пользователь',
            'telegram_user_id' => 'Telegram User ID',
        ];
    }

    /**
     * Пользователь
     */
    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}
