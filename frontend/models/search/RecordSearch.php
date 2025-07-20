<?php

namespace frontend\models\search;

use common\models\Record;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class RecordSearch extends Record
{
    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params): ActiveDataProvider
    {
        $query = Record::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }
        $query->andFilterWhere(['like', 'title', $this->title]);

        return $dataProvider;
    }
}