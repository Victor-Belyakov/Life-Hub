<?php

namespace common\services;

use common\models\Section;
use yii\helpers\ArrayHelper;

class SectionService
{
    /**
     * @return array
     */
    public static function getSectionList(): array
    {
        return ArrayHelper::map(Section::find()->all(),'id','name');
    }
}
