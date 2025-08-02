<?php

use console\rbac\permissions\user\UserUpdatePermission;
use yii\bootstrap5\Modal;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Html;

/**
 * @var $dataProvider
 * @var $searchModel
 * @var $newModel
 */

$this->title = 'Упражнения'
?>

<?= $this->render('_header') ?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'emptyText' => '<span style="color: #6c757d">Ничего не найдено</span>',
    'filterModel' => $searchModel,
    'layout' => "{items}\n{summary}\n{pager}",
    'columns' => [
        [
            'label' => '<span class="text-main">Id</span>',
            'value' => static function($model) { return $model->id; },
            'encodeLabel' => false,
            'contentOptions' => ['style' => 'color: #6c757d;'],
        ],
        [
            'label' => '<span class="text-main">Название</span>',
            'value' => static function($model) { return $model->name; },
            'encodeLabel' => false,
            'contentOptions' => ['style' => 'color: #6c757d;'],
        ],
        [
            'class' => ActionColumn::class,
            'header' => '<span class="text-main">Действия</span>',
            'template' => '{update} {delete}',
            'contentOptions' => ['class' => 'action-buttons'],
            'buttons' => [
                'update' => static function ($url, $model) {
                    return Html::button('', [
                        'class' => 'bi bi-pencil text-main update-exercise-btn',
                        'data-bs-toggle' => 'modal',
                        'data-bs-target' => '#updateExerciseModal',
                        'style' => 'border: none; background: transparent;',
                        'data-id' => $model->id
                    ]);
                },
                'delete' => static function ($url) {
                    return Yii::$app->user->can(UserUpdatePermission::getName())
                        ? Html::a('<i class="bi bi-trash text-main"></i>', $url, [
                            'title' => 'Удалить',
                            'class' => 'btn btn-sm',
                            'data-confirm' => 'Вы уверены, что хотите удалить упражнение?',
                            'data-method' => 'post',
                            'data-pjax' => '0',
                        ]) : '';
                },
            ],
        ],
    ],
]);

Modal::begin([
    'title' => 'Создать упражнение',
    'id' => 'createExerciseModal',
    'size' => Modal::SIZE_LARGE,
    'options' => [
        'class' => 'custom-modal',
    ],
]);
echo $this->render('_form', ['model' => $newModel]);
Modal::end();

Modal::begin([
    'title' => 'Редактировать упражнение',
    'id' => 'updateExerciseModal',
    'size' => Modal::SIZE_LARGE,
    'options' => [
        'class' => 'custom-modal',
    ],
]);
echo '<div class="modal-body"></div>';

Modal::end();


$this->registerCssFile('@web/css/setting/exercise.css');
?>
