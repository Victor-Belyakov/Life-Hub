<?php

use dosamigos\ckeditor\CKEditor;
use frontend\enum\record\RecordTypeEnum;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var common\models\Task $model
 * @var array $sections
 */

$isView = Yii::$app->controller->action->id === 'view';
?>

<div class="record-form">
    <?php $form = ActiveForm::begin([
        'id' => 'record-form',
        'enableClientValidation' => true
    ]); ?>

    <div class="mb-3" style="color: #6c757d">
        <?= $form->field($model, 'section_id')->dropDownList(
            $sections,
            ['prompt' => 'Выберите раздел...', 'disabled' => $isView]
        ) ?>
    </div>

    <div class="mb-3" style="color: #6c757d">
        <?= $form->field($model, 'title')->textInput(['maxlength' => true, 'disabled' => $isView]) ?>
    </div>

    <div class="mb-3" style="color: #6c757d">
        <?= $form->field($model, 'content')->widget(CKEditor::class, [
            'options' => ['rows' => 6, 'disabled' => $isView],
            'preset' => 'full'
        ]) ?>
    </div>

    <div class="mb-3" style="color: #6c757d">
        <?= $form->field($model, 'type')->dropDownList([
            RecordTypeEnum::NOTE->value => RecordTypeEnum::NOTE->label(),
            RecordTypeEnum::TARGET->value => RecordTypeEnum::TARGET->label(),
        ], ['disabled' => $isView]) ?>
    </div>

    <?php if (!$isView): ?>
        <div class="form-group">
            <?= Html::submitButton(
                $model->isNewRecord ? 'Создать' : 'Сохранить',
                ['class' => 'btn btn-success text-light']
            ) ?>
        </div>
    <?php endif; ?>

    <?php ActiveForm::end(); ?>
</div>