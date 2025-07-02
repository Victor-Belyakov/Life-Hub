<?php

use console\rbac\permissions\user\UserUpdatePermission;
use frontend\enum\user\UserEnum;
use yii\grid\ActionColumn;
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
        $url = Url::to(['user/view', 'id' => $model->id]);
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
            'label' => '<span class="text-info">Email</span>',
            'value' => static function($model) { return $model->email; },
            'encodeLabel' => false,
            'contentOptions' => ['style' => 'color: #6c757d;'],
        ],
        [
            'label' => '<span class="text-info">ФИО</span>',
            'value' => static function($searchModel) {
                return trim($searchModel->first_name . ' ' . $searchModel->middle_name . ' ' . $searchModel->last_name);
            },
            'encodeLabel' => false,
            'contentOptions' => ['style' => 'color: #6c757d;'],
        ],
        [
            'label' => '<span class="text-info">Роль</span>',
            'value' => static function($model) { return $model->getRoleName(); },
            'encodeLabel' => false,
            'contentOptions' => ['style' => 'color: #6c757d;'],
        ],
        [
            'label' => '<span class="text-info">День рождения</span>',
            'value' => static function($model) {
                return (new DateTime($model->birth_date))->format('d-m-Y');
            },
            'encodeLabel' => false,
            'contentOptions' => ['style' => 'color: #6c757d;'],
        ],
        [
            'label' => '<span class="text-info">Статус</span>',
            'value' => static function($model) {
                $status = UserEnum::fromValue((int)$model->status);
                return $status ? $status->label() : 'Неизвестно';
            },
            'encodeLabel' => false,
            'contentOptions' => static function($model) {
                $status = (int)$model->status;
                return match ($status) {
                    UserEnum::STATUS_ACTIVE->value => ['class' => 'text-success'],
                    UserEnum::STATUS_DELETED->value => ['class' => 'text-danger'],
                    UserEnum::STATUS_INACTIVE->value => ['class' => 'text-warning'],
                    default => ['class' => 'text-secondary'],
                };
            },
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
                            'data-confirm' => 'Вы уверены, что хотите удалить этого пользователя?',
                            'data-method' => 'post',
                            'data-pjax' => '0',
                        ]) : '';
                },
            ],
        ],
    ],
])
?>
