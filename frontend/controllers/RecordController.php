<?php

namespace frontend\controllers;

use common\models\Record;
use common\models\Section;
use frontend\models\search\RecordSearch;
use Throwable;
use Yii;
use yii\db\Exception;
use yii\db\StaleObjectException;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\widgets\ActiveForm;

class RecordController extends BaseController
{
    /**
     * @return string
     */
    public function actionIndex(): string
    {
        $models = Record::find()->orderBy(['sort_order' => SORT_ASC])->all();
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
     * @return Response|string
     * @throws Exception
     */
    public function actionCreate(): Response|string
    {
        $model = new Record();
        $sections = ArrayHelper::map(Section::find()->orderBy('name')->all(), 'id', 'name');

        if ($model->load(Yii::$app->request->post())) {
            if (!$model->save()) {
                return $this->asJson([
                    'success' => false,
                    'errors' => ActiveForm::validate($model),
                ]);
            }

            return $this->asJson(['success' => true]);
        }

        return $this->renderAjax('_form', [
            'model' => $model,
            'sections' => $sections
        ]);
    }

    /**
     * @param int $id
     * @return array|string|Response
     * @throws Exception
     * @throws NotFoundHttpException
     */
    public function actionUpdate(int $id): Response|array|string
    {
        $model = Record::findModel($id);
        $sections = ArrayHelper::map(Section::find()->orderBy('name')->all(), 'id', 'name');

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ['success' => true, 'id' => $model->id];
            }
            return $this->redirect(['view', 'id' => $model->id]);
        }

        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('_form', [
                'model' => $model,
                'sections' => $sections,
            ]);
        }

        return $this->render('update', [
            'model' => $model,
            'sections' => $sections,
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
        $sections = ArrayHelper::map(Section::find()->orderBy('name')->all(), 'id', 'name');

        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('_form', [
                'model' => $model,
                'sections' => $sections,
            ]);
        }

        return $this->render('update', [
            'model' => $model,
            'sections' => $sections,
        ]);
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

    /**
     * @return true[]
     * @throws Exception
     */
    public function actionSort(): array
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $order = Yii::$app->request->post('order', []);
        foreach ($order as $position => $id) {
            $model = Record::findOne($id);
            if ($model) {
                $model->sort_order = $position;
                $model->save(false, ['sort_order']);
            }
        }
        return ['success' => true];
    }
}
