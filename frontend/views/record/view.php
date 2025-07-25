<?php

use frontend\enum\record\RecordStatusEnum;
use frontend\enum\record\RecordTypeEnum;
use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Record $model */

$this->title = $model->title;
?>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-main text-white">
                    <h3 class="mb-0"><?= Html::encode($this->title) ?></h3>
                </div>

                <div class="user-view p-4">

                    <?= DetailView::widget([
                        'model' => $model,
                        'options' => ['class' => 'table table-bordered table-hover'],
                        'attributes' => [
                            [
                                'label' => 'Идентификатор',
                                'value' => $model->id
                            ],
                            [
                                'label' => 'Раздел',
                                'value' => $model->section->name
                            ],
                            [
                                'label' => 'Название',
                                'value' => $model->title,
                            ],
                            [
                                'label' => 'Контент',
                                'value' => static function($model) {
                                    $text = strip_tags($model->content);
                                    return mb_strimwidth($text, 0, 100, '...');
                                },
                            ],
                            [
                                'label' => 'Тип',
                                'value' => RecordTypeEnum::fromValue($model->type)->label(),
                            ],
                            [
                                'label' => 'Статус',
                                'value' => RecordStatusEnum::fromValue($model->status)->label(),
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
                            'class' => 'btn btn-success text-light'
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

<?php
$this->registerCssFile('@web/css/user/view.css');
