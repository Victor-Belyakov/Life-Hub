<?php

use frontend\enum\task\TaskPriorityEnum;
use frontend\enum\task\TaskStatusEnum;
use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Task $model */

$this->title = $model->title;
?>
<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card shadow">
            <div class="card-header bg-info text-white">
                <h3 class="mb-0"><?= Html::encode($this->title) ?></h3>
            </div>

            <div class="user-view p-4">
                <style>
                    .table > tbody > tr > th,
                    .table > tbody > tr > td {
                        color: #6c757d;
                        font-weight: 500;
                    }
                </style>


                <?= DetailView::widget([
                    'model' => $model,
                    'options' => ['class' => 'table table-bordered table-hover'],
                    'attributes' => [
                        [
                            'label' => 'Идентификатор',
                            'value' => $model->id
                        ],
                        [
                            'label' => 'Название',
                            'value' => $model->title
                        ],
                        [
                            'label' => 'Описание',
                            'value' => $model->description,
                        ],
                        [
                            'label' => 'Статус',
                            'value' => function($model) {
                                $priorityEnum = TaskStatusEnum::fromValue($model->status);
                                return $priorityEnum?->label();
                            }
                        ],
                        [
                            'label' => 'Приоритет',
                            'value' => function($model) {
                                $priorityEnum = TaskPriorityEnum::fromValue($model->priority);
                                return $priorityEnum?->label();
                            }
                        ],
                        [
                            'label' => 'Исполнитель',
                            'value' => $model->executor->fullName,
                        ],
                        [
                            'label' => 'Постановщик',
                            'value' => $model->creator->fullName,
                        ],
                        [
                            'label' => 'Время выполнения',
                            'value' => static function($model) {
                                $date = DateTime::createFromFormat('Y-m-d', $model->deadline);
                                return $date ? $date->format('d.m.Y') : $model->deadline;
                            },
                        ],
                        [
                            'label' => 'Дата Создания',
                            'value' => static function($model) {
                                $date = DateTime::createFromFormat('Y-m-d', $model->created_at);
                                return $date ? $date->format('d.m.Y') : $model->created_at;
                            },
                        ]
                    ],
                ]) ?>

                <div class="mt-4 d-flex gap-3">
                    <?= Html::a('Редактировать', ['update', 'id' => $model->id], [
                        'class' => 'btn btn-cus-success text-light'
                    ]) ?>
                    <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
                        'class' => 'btn btn-danger',
                        'data' => [
                            'confirm' => 'Вы уверены, что хотите удалить этого пользователя?',
                            'method' => 'post',
                        ],
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
</div>
