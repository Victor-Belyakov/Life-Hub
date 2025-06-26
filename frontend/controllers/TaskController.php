<?php

namespace frontend\controllers;

use frontend\models\search\TaskSearch;
use Yii;
use common\models\Task;
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
     * Список задач
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
     * Просмотр одной задачи
     */
    public function actionView($id): string
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Создание новой задачи
     */
    public function actionCreate(): Response|string
    {
        $model = new Task();
        if ($model->load(Yii::$app->request->post())) {

            $model->save();
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
                            'priorityLabel' => \frontend\enum\TaskPriorityEnum::fromValue($model->priority)?->label(),
                            'priorityClass' => \frontend\enum\TaskPriorityEnum::fromValue($model->priority)?->badgeClass(),
                        ],
                    ]);
                }
                return $this->redirect(['index']);
            } else {
                if (Yii::$app->request->isAjax) {
                    return $this->asJson([
                        'success' => false,
                        'errors' => $model->errors,
                    ]);
                }
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

    public function actionChangeStatus()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

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