<?php

use yii\helpers\Html;

?>

<div style="display: flex; justify-content: left; margin-bottom: 15px; gap: 1rem;">
    <?= Html::button('Создать задачу', [
        'class' => 'btn btn-success text-light',
        'data-bs-toggle' => 'modal',
        'data-bs-target' => '#createTaskModal'
    ]) ?>

    <?= Html::a('Доска', ['task/index'], [
        'class' => 'btn btn-cus-main text-light'
    ]) ?>

    <?= Html::a('Список', ['task/list'], [
        'class' => 'btn btn-cus-main text-light'
    ]) ?>
</div>