<?php

namespace app\models\search;

use common\models\Record;
use common\models\Section;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\Query;
use yii\helpers\ArrayHelper;

class RecordSearch extends Record
{
    public $section_id;

    public function rules(): array
    {
        return [
            [['title'], 'safe'], // если у тебя фильтрация по названию
            [['type'], 'string'], // ✨ фильтр по разделу
            [['section_id'], 'integer'], // ✨ фильтр по разделу
        ];
    }
    /**
     * @return array|array[]
     */
    public function scenarios()
    {
        return Model::scenarios();
    }

    /**
     * @param $params
     * @return ActiveDataProvider
     */
    public function search($params): ActiveDataProvider
    {
        $query = self::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }
        $query->andFilterWhere(['like', 'title', $this->title]);
        $query->andFilterWhere(['section_id' => $this->section_id]);
        $query->andFilterWhere(['type' => $this->type]);

        $query->orderBy(['sort_order' => SORT_ASC]);

        return $dataProvider;
    }

}
