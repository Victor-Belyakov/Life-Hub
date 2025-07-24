<?php

namespace frontend\controllers;

use common\models\Task;
use common\services\TelegramService;
use frontend\enum\task\TaskPriorityEnum;
use frontend\models\search\TaskSearch;
use Throwable;
use Yii;
use yii\bootstrap5\ActiveForm;
use yii\db\Exception;
use yii\db\StaleObjectException;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class TaskController extends Controller
{
    /**
     * @return string
     */
    public function actionIndex(): string
    {
        $tasks = Task::find()->orderBy(['created_at' => SORT_DESC])->all();

        $groupedTasks = ArrayHelper::index($tasks, null, 'status');

        return $this->render('index', [
            'groupedTasks' => $groupedTasks,
            'newTaskModel' => new Task(),
        ]);
    }

    /**
     * @return string
     */
    public function actionList(): string
    {
        $searchModel = new TaskSearch();
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
        $model = Task::findModel($id);
        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('_form', [
                'model' => $model,
            ]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * @return Response|string
     * @throws Exception
     */
    public function actionCreate(): Response|string
    {
        $model = new Task();
        if ($model->load(Yii::$app->request->post())) {
            if (!$model->save()) {
                return $this->asJson([
                    'success' => false,
                    'errors' => ActiveForm::validate($model),
                ]);
            }

            if ($model->executor_id !== $model->creator_id) {
//                    TelegramService::sendMessage(sprintf(
//                        "Пользователю %s назначена задача %s от %s. Время выполнения до %s",
//                        $model->executor->getFullName(),
//                        $model->title,
//                        $model->creator->getFullName(),
//                        $model->deadline
//                    ));
            }

            return $this->asJson(['success' => true]);
        }

        return $this->renderAjax('_form', [
            'model' => $model
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
        $model = Task::findModel($id);

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
            ]);
        }

        return $this->render('update', [
            'model' => $model,
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
        Task::findModel($id)?->delete();

        return $this->redirect(['index']);
    }

    /**
     * @return false[]|true[]
     * @throws Exception
     * @throws NotFoundHttpException
     */
    public function actionChangeStatus(): array
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $taskId = Yii::$app->request->post('id');
        $newStatus = Yii::$app->request->post('status');

        $task = Task::findModel($taskId);
        $task->status = $newStatus;
        if ($task->save(false)) {
            return ['success' => true];
        }

        return ['success' => false];
    }

    /**
     * @return array
     */
    public function actionGetEvents(): array
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $searchModel = new TaskSearch();
        $tasks = $searchModel->getTasksForCalendar();
        $events = [];

        /** @var Task $task */
        foreach ($tasks as $task) {
            $events[] = [
                'title' => $task->title,
                'start' => $task->created_at,
                'end' => $task->deadline,
                'url' => Url::to(['task/view', 'id' => $task->id]),
            ];
        }

        return $events;
    }
}
