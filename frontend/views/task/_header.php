<?php

use yii\helpers\Html;
use yii\helpers\Url;

?>

<div class="mb-3" style="display: flex; justify-content: left; gap: 1rem;">
    <?= Html::button('Создать задачу', [
        'class' => 'btn btn-success text-light',
        'data-bs-toggle' => 'modal',
        'data-url' => Url::to(['task/create']),
        'data-bs-target' => '#createTaskModal'
    ]) ?>

    <?= Html::a('Доска', ['task/index'], [
        'class' => 'btn btn-cus-main text-light'
    ]) ?>

    <?= Html::a('Список', ['task/list'], [
        'class' => 'btn btn-cus-main text-light'
    ]) ?>
</div>
