<?php

use common\services\RecordService;
use common\services\SectionService;
use dosamigos\ckeditor\CKEditor;
use frontend\enum\task\TaskPriorityEnum;
use frontend\enum\user\UserEnum;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Record $model */

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
                    <div class="col-md-4">
                        <div class="mb-3">
                            <?= $form->field($model, 'section_id')->dropDownList(SectionService::getSectionList() ,[
                                'placeholder' => 'Введите название',
                                'class' => 'form-control',
                            ])->label('Раздел') ?>
                        </div>

                        <div class="mb-3">
                            <?= $form->field($model, 'title')->textInput([
                                'placeholder' => 'Введите название',
                                'class' => 'form-control',
                            ])->label('Наименование') ?>
                        </div>

                        <div class="mb-3">
                            <?= $form->field($model, 'content')->widget(CKEditor::class, [
                                'options' => ['rows' => 6],
                                'preset' => 'full'
                            ]) ?>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <?= $form->field($model, 'type')->dropDownList(RecordService::getTypeForSelect() ,[
                                'placeholder' => 'Тип записи',
                                'class' => 'form-control',
                            ])->label('Тип записи') ?>
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
