<?php

use common\models\Record;
use common\services\RecordService;
use frontend\enum\record\RecordTypeEnum;
use kartik\select2\Select2;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use app\models\search\RecordSearch;

/**
 * @var RecordSearch $searchModel
 */

$action = Yii::$app->controller->action->id;
?>

<div class="mb-3" style="display: flex; justify-content: left; gap: 1rem; align-items: center;">
    <?= Html::button('Создать запись', [
        'class' => 'btn btn-success text-light',
        'data-bs-toggle' => 'modal',
        'data-url' => Url::to(['record/create']),
        'data-bs-target' => '#createRecordModal'
    ]) ?>

    <?= Html::a('Стикеры', ['record/index'], [
        'class' => 'btn btn-cus-main text-light'
    ]) ?>

    <?= Html::a('Список', ['record/list'], [
        'class' => 'btn btn-cus-main text-light'
    ]) ?>

    <?php $form = ActiveForm::begin([
        'method' => 'get',
        'action' => Url::to(["record/{$action}"]),
        'options' => ['style' => 'margin: 0; display: flex; align-items: center; gap: 1rem; justify-content: center;'],
    ]); ?>

    <?= $form->field($searchModel, 'section_id', [
        'options' => ['style' => 'margin: 0; min-width: 200px;']
    ])->widget(Select2::class, [
        'data' => RecordService::getSectionsForSelect(),
        'options' => [
            'placeholder' => 'Раздел записи',
            'onchange' => 'this.form.submit()',
        ],
        'pluginOptions' => [
            'allowClear' => true,
        ],
    ])->label(false) ?>

    <?= $form->field($searchModel, 'type', [
        'options' => ['style' => 'margin: 0;min-width: 200px;'],
    ])->widget(Select2::class, [
        'data' => RecordService::getTypesForSelect(),
        'options' => [
            'placeholder' => 'Тип записи',
            'onchange' => 'this.form.submit()',
        ],
        'pluginOptions' => [
            'allowClear' => true,
        ],
    ])->label(false) ?>

    <?php ActiveForm::end(); ?>
</div>
