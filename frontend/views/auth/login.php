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
        <div class="text-center mb-4">
            <div class="logo">
                <div href="<?= Yii::$app->homeUrl ?>" style="color: inherit; text-decoration: none;">
                    <img src="<?= Yii::getAlias('@web') ?>/favicon/novera.png" alt="favicon">overa
                </div>
            </div>
        </div>

        <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>
        <?= $form->field($model, 'email')->textInput(['placeholder' => 'Введите Email'])->label(false) ?>
        <?= $form->field($model, 'password')->passwordInput(['placeholder' => 'Введите Пароль'])->label(false) ?>

        <div class="form-group text-center">
            <?= Html::submitButton('Вход', ['class' => 'btn btn-cus-main text-light', 'name' => 'login-button']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
