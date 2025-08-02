<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Exercise $model */

?>

<div class="exercise-form">
    <?php $form = ActiveForm::begin([
        'id' => 'exercise-form',
        'enableClientValidation' => true,
        'options' => ['data-pjax' => true],
        'action' => $action ?? Url::to(['/exercise/create']),
    ]); ?>

    <div class="mb-3" style="color: #6c757d">
        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
