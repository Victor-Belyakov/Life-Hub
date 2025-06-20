<?php

use frontend\models\form\user\SignupForm;
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var SignupForm $model */

$this->title = 'Авторизация';
?>
    <div class="site-signup d-flex justify-content-center align-items-start" style="min-height: 100vh; padding-top: 200px;">
        <div class="form-container" style="width: 350px;">
            <h1 class="text-center text-info" style="font-weight: 700; text-shadow: 1px 1px 2px rgba(0,0,0,0.3);">Life Hub</h1>

            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>
            <?= $form->field($model, 'email')->textInput(['placeholder' => 'Введите Email'])->label(false) ?>
            <?= $form->field($model, 'password')->passwordInput(['placeholder' => 'Введите Пароль'])->label(false) ?>

            <div class="form-group text-center">
                <?= Html::submitButton('Вход', ['class' => 'btn btn-info text-light', 'name' => 'login-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>

<?php
