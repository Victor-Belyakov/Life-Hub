<?php

use frontend\models\form\user\SignupForm;
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

/* @var $this yii\web\View */
/* @var $model SignupForm */

$this->title = 'Регистрация пользователя';
?>

<div class="user-create">

    <div class="row justify-content-center">
        <div class="col-md-4">
            <h1 class="mb-4"><?= Html::encode($this->title) ?></h1>

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
                <?= Html::submitButton('Зарегистрировать', ['class' => 'btn btn-info text-light', 'style' => 'width: 40%;']) ?>
            </div>

            <?php ActiveForm::end(); ?>

        </div>
    </div>
</div>

<?php
// Подключаем flatpickr для datepicker
$this->registerCssFile('https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css');
$this->registerJsFile('https://cdn.jsdelivr.net/npm/flatpickr', ['depends' => \yii\web\JqueryAsset::class]);

$js = <<<JS
flatpickr(".datepicker", {
    dateFormat: "d-m-Y",
    maxDate: "today",
    locale: "ru"
});
JS;

$this->registerJs($js);
?>
