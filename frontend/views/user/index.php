<?php

use frontend\enum\UserEnum;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @var $dataProvider
 * @var $searchModel
 */
?>

<p>
    <?= Html::a('Зарегистрировать', ['/auth/signup', 'returnUrl' => Yii::$app->request->referrer], ['class' => 'btn btn-success']) ?>
</p>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'layout' => "{items}\n{summary}\n{pager}",
    'rowOptions' => function($model) {
        $url = Url::to(['user/view', 'id' => $model->id]);
        return [
            'style' => 'cursor: pointer;',
            'onclick' => "if(!event.target.closest('.action-buttons')) { window.location.href='$url'; }",
        ];
    },
    'columns' => [
        [
            'label' => '<span class="text-info">Email</span>',
            'value' => function($model) { return $model->email; },
            'encodeLabel' => false,
            'contentOptions' => ['style' => 'color: #6c757d;'],
        ],
        [
            'label' => '<span class="text-info">ФИО</span>',
            'value' => function($searchModel) {
                return trim($searchModel->first_name . ' ' . $searchModel->middle_name . ' ' . $searchModel->last_name);
            },
            'encodeLabel' => false,
            'contentOptions' => ['style' => 'color: #6c757d;'],
        ],
        [
            'label' => '<span class="text-info">День рождения</span>',
            'value' => function($model) {
                $date = \DateTime::createFromFormat('Y-m-d', $model->birth_date);
                return $date ? $date->format('d.m.Y') : $model->birth_date;
            },
            'encodeLabel' => false,
            'contentOptions' => ['style' => 'color: #6c757d;'],
        ],
        [
            'label' => '<span class="text-info">Статус</span>',
            'value' => function($model) {
                $status = UserEnum::fromValue((int)$model->status);
                return $status ? $status->label() : 'Неизвестно';
            },
            'encodeLabel' => false,
            'contentOptions' => function($model) {
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
            'class' => 'yii\grid\ActionColumn',
            'header' => '<span class="text-info">Действия</span>',
            'template' => '{update} {delete}',
            'contentOptions' => ['class' => 'action-buttons'],
            'buttons' => [
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
