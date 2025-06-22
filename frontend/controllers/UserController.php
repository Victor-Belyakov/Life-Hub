<?php

namespace frontend\controllers;


use backend\services\TelegramService;
use common\models\User;
use frontend\models\search\UserSearch;
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
     */
    public function actionUpdate(int $id): Response|string
    {
        $model = User::findOne($id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
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
        $telegramService = new TelegramService();
        $telegramService->sendMessage('Пользователь: ' . $model->email . ' удалён');
        return $this->redirect(['index']);
    }
}
