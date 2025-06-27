<?php

namespace frontend\controllers;


use backend\services\TelegramService;
use common\models\User;
use frontend\models\search\UserSearch;
use frontend\services\UserService;
use Yii;
use yii\db\Exception;
use yii\web\Response;

class UserController extends BaseController
{
    /**
     * @return string
     */
    public function actionIndex(): string
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @param int $id
     * @return string
     */
    public function actionView(int $id): string
    {
        $model = User::findOne($id);

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * @param int $id
     * @return Response|string
     * @throws Exception
     * @throws \Exception
     */
    public function actionUpdate(int $id): Response|string
    {
        $model = User::findOne($id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            UserService::assignRole($model->id, $model->role);

            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', ['model' => $model]);
    }

    /**
     * @throws Exception|\yii\httpclient\Exception
     */
    public function actionDelete(int $id): Response|string
    {
        $model = User::findOne($id);
        $model?->softDelete();
        TelegramService::sendMessage('Пользователь: ' . $model->email . ' удалён');

        return $this->redirect(['index']);
    }

    /**
     * @param $q
     * @return array[]
     */
    public function actionExecutorList($q = null): array
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;

        $out = ['items' => []];
        if (!is_null($q)) {
            $data = User::find()
                ->select(['id', 'fullName AS text'])
                ->where(['like', 'fullName', $q])
                ->limit(20)
                ->asArray()
                ->all();
            $out['items'] = $data;
        }
        return $out;
    }

}
