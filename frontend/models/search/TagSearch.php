<?php

namespace frontend\models\search;

use common\models\Tag;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class TagSearch extends Tag
{
    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params): ActiveDataProvider
    {
        $query = Tag::find();

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
