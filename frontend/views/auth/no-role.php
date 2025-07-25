<?php
use yii\helpers\Html;

$this->title = 'Нет роли';
?>

<div class="container text-center">
    <div class="alert alert-danger" role="alert" style="font-size: 1.25rem;">
        <strong>Ошибка:</strong> За Вами не закреплена роль, обратитесь к администратору.
    </div>

    <?= Html::beginForm(['/auth/logout'], 'post') ?>
    <?= Html::submitButton('Вернуться к авторизации', ['class' => 'btn btn-cus-main text-light']) ?>
    <?= Html::endForm() ?>
</div>
