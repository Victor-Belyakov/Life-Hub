<?php

use common\services\TaskService;
use kartik\select2\Select2;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JsExpression;

/**
 * @var $searchModel
 */

$action = Yii::$app->controller->action->id;
?>

<div class="mb-3" style="display: flex; justify-content: left; gap: 1rem;">
    <?= Html::button('Создать задачу', [
        'class' => 'btn btn-success text-light',
        'data-bs-toggle' => 'modal',
        'data-url' => Url::to(['task/create']),
        'data-bs-target' => '#createTaskModal'
    ]) ?>

    <?= Html::a('Доска', ['task/index'], [
        'class' => 'btn btn-cus-main text-light'
    ]) ?>

    <?= Html::a('Список', ['task/list'], [
        'class' => 'btn btn-cus-main text-light'
    ]) ?>

    <?php $form = ActiveForm::begin([
        'method' => 'get',
        'action' => Url::to(["task/{$action}"]),
        'options' => ['style' => 'margin: 0; display: flex; align-items: center; gap: 1rem; justify-content: center;'],
    ]); ?>

    <?= $form->field($searchModel, 'executor_id', [
        'options' => ['style' => 'margin: 0; min-width: 200px;']
    ])->widget(Select2::class, [
        'data' => TaskService::getUsersForSelect(),
        'options' => [
            'placeholder' => 'Исполнитель',
            'onchange' => 'this.form.submit()',
        ],
        'pluginOptions' => [
            'allowClear' => true,
        ],
    ])->label(false) ?>

    <?php ActiveForm::end(); ?>
</div>
