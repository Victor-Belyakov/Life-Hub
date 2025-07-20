<?php

use frontend\enum\task\TaskPriorityEnum;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Section $model */

?>

<div class="section-form">
    <?php $form = ActiveForm::begin([
        'id' => 'section-form',
        'enableClientValidation' => true,
        'options' => ['data-pjax' => true],
        'action' => $action ?? Url::to(['/section/create']),
    ]); ?>

    <div class="mb-3" style="color: #6c757d">
        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
