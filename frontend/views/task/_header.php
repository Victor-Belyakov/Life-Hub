<?php

use yii\helpers\Html;

?>

<div style="display: flex; justify-content: left; margin-bottom: 15px;">
    <div class="me-3">
        <?= Html::button('Создать задачу', [
            'class' => 'btn btn-cus-success text-light',
            'data-bs-toggle' => 'modal',
            'data-bs-target' => '#createTaskModal'
        ]) ?>
    </div>

    <div class="me-3">
        <?= Html::a('Доска', ['task/index'], [
            'class' => 'btn btn-info text-light'
        ]) ?>
    </div>

    <div class="me-3">
        <?= Html::a('Список', ['task/list'], [
            'class' => 'btn btn-info text-light'
        ]) ?>
    </div>
</div>