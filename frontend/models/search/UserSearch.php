<?php

namespace frontend\models\search;

use common\models\User;
use yii\data\ActiveDataProvider;

class UserSearch extends User
{
    public function search($params)
    {
        $query = User::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20,
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ],
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        // фильтрация по целочисленному id
        $query->andFilterWhere(['id' => $this->id]);


        return $dataProvider;
    }
}
