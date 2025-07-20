<?php

namespace frontend\controllers;

use common\models\Record;
use common\models\Section;
use common\models\Tag;
use common\models\Task;
use frontend\models\search\RecordSearch;
use frontend\models\search\TaskSearch;
use Throwable;
use Yii;
use yii\db\Exception;
use yii\db\StaleObjectException;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class RecordController extends BaseController
{
    public function actionIndex()
    {
        $models = Record::find()->orderBy(['created_at' => SORT_DESC])->all();
        $sections = ArrayHelper::map(Section::find()->orderBy('name')->all(), 'id', 'name');

        return $this->render('index', [
            'models' => $models,
            'sections' => $sections,
            'newModel' => new Record(),
        ]);
    }

    /**
     * @return string
     */
    public function actionList(): string
    {
        $searchModel = new RecordSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('list', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @param int $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView(int $id): string
    {
        $model = Record::findModel($id);

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * @return Response|string
     * @throws Exception
     */
    public function actionCreate(): Response|string
    {
        $model = new Record();

        if ($model->load(Yii::$app->request->post())) {
            if (!$model->save()) {
                return $this->asJson([
                    'success' => false,
                    'errors' => $model->getErrors(),
                ]);
            }

            return $this->asJson(['success' => true]);
        }

        return $this->renderAjax('_form', [
            'model' => $model,
        ]);
    }

    /**
     * @param int $id
     * @return string|Response
     * @throws NotFoundHttpException
     * @throws Exception
     */
    public function actionUpdate(int $id): Response|string
    {
        $model = Record::findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', ['model' => $model]);
    }

    /**
     * @param $id
     * @return Response
     * @throws NotFoundHttpException
     * @throws Throwable
     * @throws StaleObjectException
     */
    public function actionDelete($id): Response
    {
        Record::findModel($id)?->delete();

        return $this->redirect(['index']);
    }
}
