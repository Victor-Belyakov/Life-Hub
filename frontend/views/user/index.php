<?php

use frontend\enum\UserEnum;
use yii\grid\GridView;
use yii\helpers\Html;

/**
 * @var $dataProvider
 * @var $searchModel
 */
?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'layout' => "{items}\n{summary}\n{pager}",
    'columns' => [
        [
            'label' => '<span class="text-info">Email</span>',
            'value' => function($model) { return $model->email; },
            'encodeLabel' => false,
            'contentOptions' => ['style' => 'color: #2b2f32;'],
        ],
        [
            'label' => '<span class="text-info">ФИО</span>',
            'value' => function($searchModel) {
                return trim($searchModel->first_name . ' ' . $searchModel->middle_name . ' ' . $searchModel->last_name);
            },
            'encodeLabel' => false,
            'contentOptions' => ['style' => 'color: #2b2f32;'],
        ],
        [
            'label' => '<span class="text-info">День рождение</span>',
            'value' => function($model) {
                $date = \DateTime::createFromFormat('Y-m-d', $model->birth_date);
                return $date ? $date->format('d.m.Y') : $model->birth_date;
            },
            'encodeLabel' => false,
            'contentOptions' => ['style' => 'color: #2b2f32;'],
        ],
        [
            'label' => '<span class="text-info">Статус</span>',
            'value' => function($model) {
                $status = UserEnum::fromValue((int)$model->status);
                return $status ? $status->label() : 'Неизвестно';
            },
            'encodeLabel' => false,
            'contentOptions' => ['style' => 'color: #2b2f32;'],
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'header' => '<span class="text-info">Действия</span>',
            'template' => '{view} {update} {delete}',
            'buttons' => [
                'view' => function ($url, $model, $key) {
                    return Html::a('<i class="bi bi-eye text-info"></i>', $url, [
                        'title' => 'Просмотр',
                        'class' => 'btn btn-sm me-1',
                        'data-pjax' => '0',
                    ]);
                },
                'update' => function ($url, $model, $key) {
                    return Html::a('<i class="bi bi-pencil text-info"></i>', $url, [
                        'title' => 'Редактировать',
                        'class' => 'btn btn-sm me-1',
                        'data-pjax' => '0',
                    ]);
                },
                'delete' => function ($url, $model, $key) {
                    return Html::a('<i class="bi bi-trash text-info"></i>', $url, [
                        'title' => 'Удалить',
                        'class' => 'btn btn-sm',
                        'data-confirm' => 'Вы уверены, что хотите удалить этот элемент?',
                        'data-method' => 'post',
                        'data-pjax' => '0',
                    ]);
                },
            ],
        ],
    ],
]);

?>
