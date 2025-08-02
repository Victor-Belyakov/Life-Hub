<?php

namespace app\models\search;

use common\models\Exercise;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class ExerciseSearch extends Exercise
{
    public function scenarios()
    {
        return Model::scenarios();
    }

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
        $query->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}
