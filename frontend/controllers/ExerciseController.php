<?php

namespace frontend\controllers;

use app\models\search\ExerciseSearch;
use common\models\Exercise;
use Exception;
use frontend\controllers\BaseController;
use Throwable;
use Yii;
use yii\db\StaleObjectException;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class ExerciseController extends BaseController
{
    /**
     * @return string
     */
    public function actionIndex(): string
    {
        $searchModel = new ExerciseSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'newModel' => new Exercise(),
            'dataProvider' => $dataProvider
        ]);
    }

    /**
     * @throws Exception
     */
    public function actionCreate(): Response|string
    {
        $model = new Exercise();

        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                return $this->asJson(['success' => true]);
            }

            return $this->asJson([
                'success' => false,
                'errors' => $model->getErrors(),
            ]);
        }

        return $this->renderAjax('_form', [
            'model' => $model,
        ]);
    }

    /**
     * @throws Exception|NotFoundHttpException
     */
    public function actionUpdate(int $id): Response|string
    {
        $model = Exercise::findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                return $this->asJson(['success' => true]);
            }

            return $this->asJson([
                'success' => false,
                'errors' => $model->getErrors(),
            ]);
        }

        return $this->renderAjax('_form', [
            'model' => $model,
            'action' => ['/exercise/update', 'id' => $id],
        ]);
    }

    /**
     * @param int $id
     * @return Response
     * @throws Throwable
     * @throws StaleObjectException
     * @throws NotFoundHttpException
     */
    public function actionDelete(int $id): Response
    {
        Exercise::findModel($id)?->delete();

        return $this->redirect(['index']);
    }
}
