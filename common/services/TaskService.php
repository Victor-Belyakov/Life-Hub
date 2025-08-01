<?php

namespace common\services;

use frontend\models\search\TaskSearch;
use frontend\models\search\UserSearch;
use yii\db\Expression;
use yii\helpers\ArrayHelper;

class TaskService
{
    /**
     * Для dropDownList: [value => label]
     * Возвращает только те разделы, которые реально используются в таблице record
     */
    public static function getUsersForSelect(): array
    {
        $userIds = TaskSearch::find()
            ->select('executor_id')
            ->distinct()
            ->column();

        $users = UserSearch::find()
            ->select([
                'id',
                // Склеиваем Фамилия Имя Отчество (или Имя Фамилия, как нужно)
                new Expression("CONCAT(last_name, ' ', first_name, ' ', middle_name) AS full_name")
            ])
            ->where(['id' => $userIds])
            ->orderBy('full_name')
            ->asArray()
            ->all();

        return ArrayHelper::map($users, 'id', 'full_name');
    }
}