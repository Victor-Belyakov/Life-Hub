<?php

use frontend\models\form\user\SignupForm;
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

/* @var $this yii\web\View */
/* @var $model SignupForm */

$this->title = 'Регистрация пользователя';
?>

<div class="row justify-content-center">
    <div class="col-md-6"> <!-- Ширина карточки -->
        <div class="card shadow">
            <div class="card-header bg-main text-white">
                <h4 class="mb-0"><?= Html::encode($this->title) ?></h4>
            </div>
            <div class="card-body" style="color: #6c757d; font-weight: 500">

                <?php $form = ActiveForm::begin([
                    'id' => 'user-create-form',
                    'enableClientValidation' => true,
                ]); ?>

                <?= Html::hiddenInput('returnUrl', $returnUrl ?? Yii::$app->homeUrl) ?>

                <?= $form->field($model, 'first_name')->textInput([
                    'placeholder' => 'Введите Имя',
                    'autofocus' => true,
                ])->label(false) ?>

                <?= $form->field($model, 'last_name')->textInput([
                    'placeholder' => 'Введите Фамилию',
                ])->label(false) ?>

                <?= $form->field($model, 'middle_name')->textInput([
                    'placeholder' => 'Введите Отчество',
                ])->label(false) ?>

                <?= $form->field($model, 'birth_date')->textInput([
                    'placeholder' => 'Введите Дату рождения',
                    'class' => 'form-control datepicker',
                    'autocomplete' => 'off',
                ])->label(false) ?>

                <?= $form->field($model, 'email')->textInput([
                    'placeholder' => 'Введите Email',
                ])->label(false) ?>

                <?= $form->field($model, 'password')->passwordInput([
                    'placeholder' => 'Введите Пароль',
                ])->label(false) ?>

                <div class="form-group mt-3 text-center">
                    <?= Html::submitButton('Зарегистрировать', ['class' => 'btn btn-success text-light', 'style' => 'width: 30%;']) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
