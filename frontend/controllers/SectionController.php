<?php

namespace frontend\controllers;

use common\models\Section;
use frontend\models\search\SectionSearch;
use Throwable;
use Yii;
use yii\db\Exception;
use yii\db\StaleObjectException;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class SectionController extends BaseController
{
    /**
     * @return string
     */
    public function actionIndex(): string
    {
        $searchModel = new SectionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'newModel' => new Section(),
            'dataProvider' => $dataProvider
        ]);
    }

    /**
     * @throws Exception
     */
    public function actionCreate(): Response|string
    {
        $model = new Section();

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
        $model = Section::findModel($id);

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
            'action' => ['/section/update', 'id' => $id],
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
        Section::findModel($id)?->delete();

        return $this->redirect(['index']);
    }
}
