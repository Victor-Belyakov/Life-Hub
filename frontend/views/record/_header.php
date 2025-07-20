<?php

use yii\helpers\Html;

?>

<div class="mb-3" style="display: flex; justify-content: left; gap: 1rem;">
    <?= Html::button('Создать запись', [
        'class' => 'btn btn-success text-light',
        'data-bs-toggle' => 'modal',
        'data-bs-target' => '#createRecordModal'
    ]) ?>

    <?= Html::a('Стикеры', ['record/index'], [
        'class' => 'btn btn-cus-main text-light'
    ]) ?>

    <?= Html::a('Список', ['record/list'], [
        'class' => 'btn btn-cus-main text-light'
    ]) ?>
</div>
