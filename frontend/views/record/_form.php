<?php

use frontend\enum\task\TaskPriorityEnum;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var common\models\Task $model
 * @var array $sections
 */

?>

<div class="record-form">
    <?php $form = ActiveForm::begin([
        'id' => 'record-form',
        'enableClientValidation' => true,
        'action' => Url::to(['/record/create']),
        'options' => ['data-pjax' => true],
    ]); ?>

    <div class="mb-3" style="color: #6c757d">
        <?= $form->field($model, 'section_id')->dropDownList(
            $sections,
            ['prompt' => 'Выберите раздел...']
        ) ?>
    </div>

    <div class="mb-3" style="color: #6c757d">
        <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
    </div>

    <div class="mb-3" style="color: #6c757d">
        <?= $form->field($model, 'content')->textarea(['rows' => 3]) ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Создать', ['class' => 'btn btn-success text-light', 'data-url' => 'task/create',]) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
