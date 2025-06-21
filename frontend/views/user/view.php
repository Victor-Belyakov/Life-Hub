<?php

use yii\widgets\DetailView;
use yii\helpers\Html;
use frontend\enum\UserEnum;

/** @var yii\web\View $this */
/** @var common\models\User $model */

$this->title = $model->email;
?>

<div class="user-view">
    <style>
        .table > tbody > tr > th {
            color: #2b2f32;
            font-weight: 500;
        }
    </style>
    <h1 class="text-info"><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'label' => 'Идентификатор',
                'value' => $model->id,
                'labelColOptions' => ['style' => 'color: #;'],
            ],
            [
                'label' => 'Email',
                'value' => $model->email,
            ],
            [
                'label' => 'ФИО',
                'value' => trim($model->first_name . ' ' . $model->middle_name . ' ' . $model->last_name),
            ],
            [
                'label' => 'Дата рождения',
                'value' => function($model) {
                    $date = \DateTime::createFromFormat('Y-m-d', $model->birth_date);
                    return $date ? $date->format('d.m.Y') : $model->birth_date;
                },
            ],
            [
                'label' => 'Статус',
                'value' => function($model) {
                    return UserEnum::fromValue((int)$model->status)?->label() ?? 'Неизвестно';
                },
            ],
            [
                'label' => 'Дата создания',
                'value' => function($model) {
                    $date = \DateTime::createFromFormat('Y-m-d', $model->created_at);
                    return $date ? $date->format('d.m.Y') : $model->created_at;
                },
            ],
            [
                'label' => 'Дата обновления',
                'value' => function($model) {
                    $date = \DateTime::createFromFormat('Y-m-d', $model->updated_at);
                    return $date ? $date->format('d.m.Y') : $model->updated_at;
                },
            ]
        ],
    ]) ?>

    <p>
        <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-info text-light']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены, что хотите удалить этого пользователя?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
</div>
