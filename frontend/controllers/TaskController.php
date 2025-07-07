<?php

namespace frontend\controllers;

use common\models\Task;
use common\services\TelegramService;
use frontend\enum\task\TaskPriorityEnum;
use frontend\models\search\TaskSearch;
use Throwable;
use Yii;
use yii\db\StaleObjectException;
use yii\helpers\Url;
use yii\httpclient\Exception;
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
        $newTaskModel = new Task();

        return $this->render('index', [
            'tasks' => $tasks,
            'newTaskModel' => $newTaskModel,
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
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView($id): string
    {
        return $this->render('view', [
            'model' => Task::findModel($id),
        ]);
    }

    /**
     * @return Response|string
     * @throws Exception
     * @throws \yii\db\Exception
     */
    public function actionCreate(): Response|string
    {
        $model = new Task();

        if ($model->load(Yii::$app->request->post())) {
            $model->creator_id = Yii::$app->user->id;

            if ($model->save()) {

                if ($model->executor_id !== $model->creator_id) {
                    TelegramService::sendMessage(sprintf(
                        "Пользователю %s назначена задача %s от %s. Время выполнения до %s",
                        $model->executor->getFullName(),
                        $model->title,
                        $model->creator->getFullName(),
                        $model->deadline
                    ));
                }

                if (Yii::$app->request->isAjax) {
                    return $this->asJson(['success' => true]);
                }

                return $this->redirect(['view', 'id' => $model->id]);
            }

            if (Yii::$app->request->isAjax) {
                return $this->asJson([
                    'success' => false,
                    'errors' => $model->getErrors(),
                ]);
            }
        }

        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('_form', [
                'model' => $model,
            ]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }


    /**
     * @param $id
     * @return string|Response
     * @throws NotFoundHttpException
     * @throws \yii\db\Exception
     */
    public function actionUpdate($id): Response|string
    {
        $model = Task::findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                if (!Yii::$app->request->isAjax) {
                    return $this->redirect(['index']);
                }

                return $this->asJson([
                    'success' => true,
                    'task' => [
                        'id' => $model->id,
                        'title' => $model->title,
                        'description' => $model->description,
                        'status' => $model->status,
                        'priority' => $model->priority,
                        'executor_id' => $model->executor_id,
                        'deadline' => $model->deadline,
                        'priorityLabel' => TaskPriorityEnum::fromValue($model->priority)?->label(),
                        'priorityClass' => TaskPriorityEnum::fromValue($model->priority)?->badgeClass(),
                    ],
                ]);
            }

            if (Yii::$app->request->isAjax) {
                return $this->asJson([
                    'success' => false,
                    'errors' => $model->errors,
                ]);
            }
        }

        return Yii::$app->request->isAjax
            ? $this->renderAjax('_form', ['model' => $model])
            : $this->render('update', ['model' => $model]);
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
     * @throws \yii\db\Exception
     */
    public function actionChangeStatus(): array
    {
        $taskId = Yii::$app->request->post('id');
        $newStatus = Yii::$app->request->post('status');

        $task = Task::findOne($taskId);

        if ($task) {
            $task->status = $newStatus;
            if ($task->save(false)) {
                return ['success' => true];
            }
        }

        return ['success' => false];
    }

    /**
     * @return array
     */
    public function actionGetEvents(): array
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $tasks = Task::find()->where(['executor_id' => Yii::$app->user->id])->all();
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
