<?php

namespace frontend\controllers;


use common\models\User;
use frontend\models\search\UserSearch;
use Yii;

class UserController extends BaseController
{
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        $model = User::findOne($id);

        return $this->render('view', [
            'model' => $model,
        ]);
    }

}