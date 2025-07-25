<?php

use frontend\enum\task\TaskPriorityEnum;
use frontend\enum\task\TaskStatusEnum;
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
        $url = Url::to(['record/view', 'id' => $model->id]);
        return [
            'style' => 'cursor: pointer;',
            'onclick' => "if(!event.target.closest('.action-buttons')) { window.location.href='$url'; }",
        ];
    },
    'columns' => [
        [
            'label' => '<span class="text-main">Id</span>',
            'value' => static function($model) { return $model->id; },
            'encodeLabel' => false,
            'contentOptions' => ['style' => 'color: #6c757d;'],
        ],
        [
            'label' => '<span class="text-main">Раздел</span>',
            'value' => static function($model) { return $model->section->name; },
            'encodeLabel' => false,
            'contentOptions' => ['style' => 'color: #6c757d;'],
        ],
        [
            'label' => '<span class="text-main">Название</span>',
            'value' => static function($model) { return $model->title; },
            'encodeLabel' => false,
            'contentOptions' => ['style' => 'color: #6c757d;'],
        ],
        [
            'label' => '<span class="text-main">Контент</span>',
            'value' => static function($model) {
                $text = strip_tags($model->content);
                return mb_strimwidth($text, 0, 100, '...');
            },
            'encodeLabel' => false,
            'contentOptions' => ['style' => 'color: #6c757d;'],
        ],
        [
            'class' => ActionColumn::class,
            'header' => '<span class="text-main">Действия</span>',
            'template' => '{update} {delete}',
            'contentOptions' => ['class' => 'action-buttons'],
            'buttons' => [
                'update' => static function ($url) {
                    return Yii::$app->user->can(UserUpdatePermission::getName())
                        ? Html::a('<i class="bi bi-pencil text-main"></i>', $url, [
                            'title' => 'Редактировать',
                            'class' => 'btn btn-sm me-1',
                            'data-pjax' => '0',
                        ]) : '';
                },
                'delete' => static function ($url) {
                    return Yii::$app->user->can(UserUpdatePermission::getName())
                        ? Html::a('<i class="bi bi-trash text-main"></i>', $url, [
                            'title' => 'Удалить',
                            'class' => 'btn btn-sm',
                            'data-confirm' => 'Вы уверены, что хотите удалить эту запись?',
                            'data-method' => 'post',
                            'data-pjax' => '0',
                        ]) : '';
                },
            ],
        ],
    ],
])

?>
