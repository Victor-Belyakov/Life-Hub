<?php

use frontend\enum\task\TaskPriorityEnum;
use frontend\enum\user\UserEnum;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Task $model */

$this->title = 'Редактирование: ' . $model->title;
?>

<div class="row justify-content-center">
    <div class="col-md-10"> <!-- Ширина карточки -->
        <div class="card shadow">
            <div class="card-header bg-main text-white">
                <h3 class="mb-0"><?= Html::encode($this->title) ?></h3>
            </div>
            <style>
                .card-body {
                    color: #6c757d;
                    font-weight: 500;
                }
            </style>
            <div class="card-body">
                <?php $form = ActiveForm::begin([
                    'id' => 'task-update-form',
                    'enableClientValidation' => true,
                ]); ?>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <?= $form->field($model, 'title')->textInput([
                                'placeholder' => 'Введите название',
                                'class' => 'form-control',
                            ])->label('Название') ?>
                        </div>

                        <div class="mb-3">
                            <?= $form->field($model, 'description')->textInput([
                                'placeholder' => 'Введите описание',
                                'class' => 'form-control',
                            ])->label('Описание') ?>
                        </div>

                        <div class="mb-3" style="color: #6c757d">
                            <?= $form->field($model, 'priority')->dropDownList([
                                TaskPriorityEnum::LOW->value => TaskPriorityEnum::LOW->label(),
                                TaskPriorityEnum::MEDIUM->value => TaskPriorityEnum::MEDIUM->label(),
                                TaskPriorityEnum::HIGH->value => TaskPriorityEnum::HIGH->label(),
                            ]) ?>
                        </div>

                    </div>

                    <div class="col-md-6">

                        <div class="mb-3" style="color: #6c757d">
                            <?= $form->field($model, 'executor_id')->widget(Select2::class, [
                                'options' => ['placeholder' => 'Выберите исполнителя...'],
                                'initValueText' => $model->executor ? $model->executor->fullName : '',
                                'pluginOptions' => [
                                    'minimumInputLength' => 2,
                                    'ajax' => [
                                        'url' => Url::to(['user/executor-list']),
                                        'dataType' => 'json',
                                        'delay' => 250,
                                        'data' => new JsExpression('function(params) { return {q:params.term}; }'),
                                        'processResults' => new JsExpression('function(data) { return {results:data.items}; }'),
                                        'cache' => true,
                                    ],
                                    'escapeMarkup' => new JsExpression('function(markup) { return markup; }'),
                                    'templateResult' => new JsExpression('function(data) { return data.text; }'),
                                    'templateSelection' => new JsExpression('function(data) { return data.text; }'),
                                ],
                            ]) ?>
                        </div>

                        <div class="mb-3" style="color: #6c757d">
                            <?= $form->field($model, 'deadline')->input('date', ['class' => 'datepicker form-control']) ?>
                        </div>
                    </div>
                </div>

                <div class="form-group mt-4 text-center">
                    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success text-light']) ?>
                    <?= Html::a('Отмена', ['view', 'id' => $model->id], ['class' => 'btn btn-secondary ms-2']) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
