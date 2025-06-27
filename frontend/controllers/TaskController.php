<?php

namespace frontend\controllers;

use frontend\enum\TaskPriorityEnum;
use frontend\models\search\TaskSearch;
use TelegramService;
use Yii;
use common\models\Task;
use yii\httpclient\Exception;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * TaskController implements the CRUD actions for Task model.
 */
class TaskController extends Controller
{
    /**
     * Список задач для доски
     */
    public function actionIndex()
    {
        $tasks = Task::find()->orderBy(['created_at' => SORT_DESC])->all();
        $newTaskModel = new Task();

        return $this->render('index', [
            'tasks' => $tasks,
            'newTaskModel' => $newTaskModel,
        ]);
    }

    /**
     * Список задач для листинга
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
     * Просмотр одной задачи
     * @throws NotFoundHttpException
     */
    public function actionView($id): string
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Создание новой задачи
     * @throws Exception|\yii\db\Exception
     */
    public function actionCreate(): Response|string
    {
        $model = new Task();
        if ($model->load(Yii::$app->request->post())) {
            $model->creator_id = Yii::$app->user->id;
            $model->save();

            if ($model->executor_id !== $model->creator_id) {
                TelegramService::sendMessage(sprintf(
                    "Пользователю %s назначена задача %s от %s. Время выполнения до %s",
                    $model->executor->getFullName(),
                    $model->creator->getFullName(),
                    $model->title,
                    $model->deadline
                ));
            }

            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Редактирование задачи
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                if (Yii::$app->request->isAjax) {
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
                return $this->redirect(['index']);
            }

            if (Yii::$app->request->isAjax) {
                return $this->asJson([
                    'success' => false,
                    'errors' => $model->errors,
                ]);
            }
        }

        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('_form', ['model' => $model]);
        }

        return $this->render('update', ['model' => $model]);
    }

    /**
     * Удаление задачи
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        return $this->redirect(['index']);
    }

    /**
     * Поиск модели задачи по ID
     */
    protected function findModel($id)
    {
        if (($model = Task::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Запрашиваемая задача не найдена.');
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

}