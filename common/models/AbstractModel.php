<?php

namespace common\models;

use yii\db\ActiveRecord;
use yii\web\NotFoundHttpException;

class AbstractModel extends ActiveRecord
{
    /**
     * @throws NotFoundHttpException
     */
    public static function findModel(int $id): static
    {
        if (($model = static::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Model not found.');
    }
}
