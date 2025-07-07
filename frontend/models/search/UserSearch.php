<?php

namespace frontend\models\search;

use common\models\User;
use yii\data\ActiveDataProvider;

class UserSearch extends User
{
    private const int USER_SELECT2_LIMIT = 5;

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

        $query->andFilterWhere(['id' => $this->id]);


        return $dataProvider;
    }

    /**
     * @param string $q
     * @return array
     */
    public function getUserForSelect2(string $q): array
    {
        return User::find()
            ->select([
                'id',
                "CONCAT(first_name, ' ', last_name) AS text"
            ])
            ->where("CONCAT(first_name, ' ', last_name) ILIKE :q", [':q' => "%{$q}%"])
            ->limit(self::USER_SELECT2_LIMIT)
            ->asArray()
            ->all();
    }
}
