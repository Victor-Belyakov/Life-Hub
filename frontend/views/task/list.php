<?php

use yii\grid\ActionColumn;
use console\rbac\permissions\user\UserUpdatePermission;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @var $dataProvider
 * @var $searchModel
 */
?>

<?= $this->render('_header') ?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'emptyText' => '<span style="color: #6c757d">Ничего не найдено</span>',
    'filterModel' => $searchModel,
    'layout' => "{items}\n{summary}\n{pager}",
    'rowOptions' => static function($model) {
        $url = Url::to(['task/view', 'id' => $model->id]);
        return [
            'style' => 'cursor: pointer;',
            'onclick' => "if(!event.target.closest('.action-buttons')) { window.location.href='$url'; }",
        ];
    },
    'columns' => [
        [
            'label' => '<span class="text-info">Id</span>',
            'value' => static function($model) { return $model->id; },
            'encodeLabel' => false,
            'contentOptions' => ['style' => 'color: #6c757d;'],
        ],
        [
            'label' => '<span class="text-info">Название</span>',
            'value' => static function($model) { return $model->title; },
            'encodeLabel' => false,
            'contentOptions' => ['style' => 'color: #6c757d;'],
        ],
        [
            'label' => '<span class="text-info">Описание</span>',
            'value' => static function($model) { return $model->description; },
            'encodeLabel' => false,
            'contentOptions' => ['style' => 'color: #6c757d;'],
        ],
        [
            'label' => '<span class="text-info">Статус</span>',
            'value' => static function($model) { return $model->status; },
            'encodeLabel' => false,
            'contentOptions' => ['style' => 'color: #6c757d;'],
        ],
        [
            'label' => '<span class="text-info">Приоритет</span>',
            'value' => static function($model) { return $model->priority; },
            'encodeLabel' => false,
            'contentOptions' => ['style' => 'color: #6c757d;'],
        ],
        [
            'label' => '<span class="text-info">Исполнитель</span>',
            'value' => static function($model) { return $model->executor->fullName; },
            'encodeLabel' => false,
            'contentOptions' => ['style' => 'color: #6c757d;'],
        ],
        [
            'label' => '<span class="text-info">Срок выполнения</span>',
            'value' => static function($model) { return $model->deadline; },
            'encodeLabel' => false,
            'contentOptions' => ['style' => 'color: #6c757d;'],
        ],
        [
            'class' => ActionColumn::class,
            'header' => '<span class="text-info">Действия</span>',
            'template' => '{update} {delete}',
            'contentOptions' => ['class' => 'action-buttons'],
            'buttons' => [
                'update' => static function ($url, $model, $key) {
                    return Yii::$app->user->can(UserUpdatePermission::getName())
                        ? Html::a('<i class="bi bi-pencil text-info"></i>', $url, [
                            'title' => 'Редактировать',
                            'class' => 'btn btn-sm me-1',
                            'data-pjax' => '0',
                        ]) : '';
                },
                'delete' => static function ($url, $model, $key) {
                    return Yii::$app->user->can(UserUpdatePermission::getName())
                        ? Html::a('<i class="bi bi-trash text-info"></i>', $url, [
                            'title' => 'Удалить',
                            'class' => 'btn btn-sm',
                            'data-confirm' => 'Вы уверены, что хотите удалить эту задачу?',
                            'data-method' => 'post',
                            'data-pjax' => '0',
                        ]) : '';
                },
            ],
        ],
    ],
])

?>
