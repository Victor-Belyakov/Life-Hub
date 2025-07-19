<?php

use frontend\enum\user\UserEnum;
use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\User $model */

$this->title = $model->email;
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
                            'label' => 'Email',
                            'value' => $model->email
                        ],
                        [
                            'label' => 'ФИО',
                            'value' => trim($model->first_name . ' ' . $model->middle_name . ' ' . $model->last_name),
                        ],
                        [
                            'label' => 'Роль',
                            'value' => $model->getRoleName(),
                        ],
                        [
                            'label' => 'Дата рождения',
                            'value' => static function($model) {
                                return (new DateTime($model->birth_date))->format('d-m-Y');
                            },
                        ],
                        [
                            'label' => 'Статус',
                            'value' => static function($model) {
                                return UserEnum::fromValue((int)$model->status)?->label() ?? 'Неизвестно';
                            },
                        ],
                        [
                            'label' => 'Дата создания',
                            'value' => static function($model) {
                                $date = DateTime::createFromFormat('Y-m-d', $model->created_at);
                                return $date ? $date->format('d.m.Y') : $model->created_at;
                            },
                        ],
                        [
                            'label' => 'Дата обновления',
                            'value' => static function($model) {
                                $date = DateTime::createFromFormat('Y-m-d', $model->updated_at);
                                return $date ? $date->format('d.m.Y') : $model->updated_at;
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
