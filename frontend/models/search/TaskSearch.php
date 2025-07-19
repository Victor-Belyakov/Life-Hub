<?php

namespace frontend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Task;

class TaskSearch extends Task
{
    public function rules(): array
    {
        return [
            [['id', 'executor_id'], 'integer'],
            [['title', 'status', 'priority', 'deadline', 'created_at'], 'safe'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Task::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['created_at' => SORT_DESC]],
            'pagination' => ['pageSize' => 20],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere(['id' => $this->id]);
        $query->andFilterWhere(['executor_id' => $this->executor_id]);
        $query->andFilterWhere(['status' => $this->status]);
        $query->andFilterWhere(['priority' => $this->priority]);

        if (!empty($this->deadline)) {
            $query->andFilterWhere(['deadline' => $this->deadline]);
        }

        $query->andFilterWhere(['like', 'title', $this->title]);

        return $dataProvider;
    }

    /**
     * @return array
     */
    public function getTasksForCalendar(): array
    {
        return Task::find()->where(['executor_id' => Yii::$app->user->id])->all();
    }
}