<?php

use yii\helpers\Html;

?>
<div style="display: flex; justify-content: left; margin-bottom: 15px;">
    <div class="me-3">
        <?= Html::button('Создать секцию', [
            'class' => 'btn btn-success text-light',
            'data-bs-toggle' => 'modal',
            'data-bs-target' => '#createSectionModal'
        ]) ?>
    </div>
</div>