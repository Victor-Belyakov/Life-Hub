<?php

use frontend\enum\user\UserEnum;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\User $model */

$this->title = 'Редактирование: ' . $model->email;
?>

<div class="row justify-content-center">
    <div class="col-md-10"> <!-- Ширина карточки -->
        <div class="card shadow">
            <div class="card-header bg-info text-white">
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
                    'id' => 'user-update-form',
                    'enableClientValidation' => true,
                ]); ?>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <?= $form->field($model, 'first_name')->textInput([
                                'placeholder' => 'Введите имя',
                                'class' => 'form-control',
                            ])->label('Имя') ?>
                        </div>

                        <div class="mb-3">
                            <?= $form->field($model, 'middle_name')->textInput([
                                'placeholder' => 'Введите отчество',
                                'class' => 'form-control',
                            ])->label('Отчество') ?>
                        </div>

                        <div class="mb-3">
                            <?= $form->field($model, 'last_name')->textInput([
                                'placeholder' => 'Введите фамилию',
                                'class' => 'form-control',
                            ])->label('Фамилия') ?>
                        </div>

                        <div class="form-check mb-3">
                            <?= $form->field($model, 'status', [
                                'template' => "<div class=\"form-check\">{input} {label}\n{error}</div>",
                            ])->checkbox([
                                'label' => 'Активен',
                                'uncheck' => UserEnum::STATUS_INACTIVE->value,
                                'value' => UserEnum::STATUS_ACTIVE->value,
                                'class' => 'form-check-input',
                            ], false)->label('Активен', ['class' => 'form-check-label']) ?>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <?= $form->field($model, 'birth_date')->textInput([
                                'class' => 'form-control datepicker',
                                'placeholder' => 'Введите дату рождения',
                                'autocomplete' => 'off',
                            ])->label('Дата рождения') ?>
                        </div>

                        <div class="mb-3">
                            <?= $form->field($model, 'email')->textInput([
                                'placeholder' => 'Введите email',
                                'class' => 'form-control',
                            ])->label('Email') ?>
                        </div>

                        <div class="mb-3">
                            <?= $form->field($model, 'role')->dropDownList([
                                'guest' => 'Гость',
                                'user' => 'Пользователь',
                                'admin' => 'Администратор',
                            ], [
                                'class' => 'form-control',
                            ])->label('Роль') ?>
                        </div>
                    </div>
                </div>

                <div class="form-group mt-4 text-center">
                    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-cus-success text-light']) ?>
                    <?= Html::a('Отмена', ['view', 'id' => $model->id], ['class' => 'btn btn-secondary ms-2']) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
