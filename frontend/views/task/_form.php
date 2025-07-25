<?php

use frontend\enum\task\TaskPriorityEnum;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Task $model */

$isView = Yii::$app->controller->action->id === 'view';
$isCreate = Yii::$app->controller->action->id === 'create';
?>

<div class="task-form">
    <?php $form = ActiveForm::begin([
        'id' => 'task-form',
        'enableClientValidation' => true,
        'action' => Url::to(['/task/create']),
        'options' => ['data-pjax' => true],
    ]); ?>

    <div class="mb-3" style="color: #6c757d">
        <?= $form->field($model, 'title')->textInput(['maxlength' => true, 'disabled' => $isView]) ?>
    </div>

    <div class="mb-3" style="color: #6c757d">
        <?= $form->field($model, 'description')->textarea(['rows' => 3, 'disabled' => $isView]) ?>
    </div>

    <div class="mb-3" style="color: #6c757d">
        <?= $form->field($model, 'priority')->dropDownList([
            TaskPriorityEnum::LOW->value => TaskPriorityEnum::LOW->label(),
            TaskPriorityEnum::MEDIUM->value => TaskPriorityEnum::MEDIUM->label(),
            TaskPriorityEnum::HIGH->value => TaskPriorityEnum::HIGH->label(),
        ], ['disabled' => $isView]) ?>
    </div>

    <div class="mb-3" style="color: #6c757d">
        <?= $form->field($model, 'executor_id')->widget(Select2::class, [
            'options' => [
                'placeholder' => 'Выберите исполнителя...',
                'disabled' => $isView
            ],
            'initValueText' => $model->executor ? $model->executor->fullName : '',
            'pluginOptions' => [
                'minimumInputLength' => 2,
                'dropdownParent' => $isCreate ? '#createTaskModal' : '#updateTaskModal',
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
        <?= $form->field($model, 'deadline')
            ->textInput([
                'class' => 'datepicker form-control',
                'disabled' => $isView,
                'autocomplete' => 'off',
                'value' => $model->deadline ? substr($model->deadline, 0, 10) : null
            ]) ?>
<!--        --><?php //= $form->field($model, 'deadline')->input('date', ['class' => 'datepicker form-control', 'disabled' => $isView, 'value' => $model->deadline ? substr($model->deadline, 0, 10) : null]) ?>
    </div>

    <?php if (!$isView): ?>
    <div class="form-group">
        <?= Html::submitButton('Создать', ['class' => 'btn btn-success text-light', 'data-url' => 'task/create',]) ?>
    </div>
    <?php endif; ?>

    <?php ActiveForm::end(); ?>
</div>
