<?php

namespace common\services;

use frontend\enum\record\RecordTypeEnum;
use frontend\models\search\RecordSearch;
use frontend\models\search\SectionSearch;
use yii\helpers\ArrayHelper;

class RecordService
{
    /**
     * @return array
     */
    public static function getSectionsForSelect(): array
    {
        $sectionIds = RecordSearch::find()
            ->select('section_id')
            ->distinct()
            ->column();

        $sections = SectionSearch::find()
            ->select(['id', 'name'])
            ->where(['id' => $sectionIds])
            ->orderBy('name')
            ->asArray()
            ->all();

        return ArrayHelper::map($sections, 'id', 'name');
    }

    /**
     * @return array
     */
    public static function getTypesForSelect(): array
    {
        $types = RecordSearch::find()
            ->select('type')
            ->distinct()
            ->column();

        $allTypeLabels = RecordTypeEnum::labels();

        $result = [];
        foreach ($types as $type) {
            if (isset($allTypeLabels[$type])) {
                $result[$type] = $allTypeLabels[$type];
            } else {
                $result[$type] = $type;
            }
        }
        return $result;
    }
}
