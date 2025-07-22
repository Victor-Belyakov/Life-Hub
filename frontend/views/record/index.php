<?php

use frontend\enum\record\RecordTypeEnum;
use yii\bootstrap5\Modal;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JqueryAsset;

/**
 * @var common\models\Record[] $models
 * @var common\models\Record $newModel
 * @var array $sections
 */
$this->title = 'Записи'

?>

<?= $this->render('_header') ?>

<div class="row">
    <?php foreach ($models as $record): ?>
        <div class="mb-2" style="max-width: 20%;">
            <div class="card" style="height: 100%;">
                    <div class="card-img-top d-flex align-items-center justify-content-center bg-main"
                         style="height: 50px; font-weight: bold; font-size: 1.5rem; color: white;">
                        <?= Html::encode($record->section->name ?? 'Без раздела') ?>
                    </div>
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title" style="color:#6c757d;">
                        <?= Html::encode($record->title) ?>
                    </h5>

                    <?php
                    $text = strip_tags($record->content);
                    $short = mb_substr($text, 0, 100);
                    $isLong = mb_strlen($text) > 100;
                    ?>
                    <p class="card-text text-muted" style="flex-grow: 1; color:#6c757d;">
                        <?= Html::encode($short) ?><?= $isLong ? '...' : '' ?>
                    </p>

                    <div  class="d-flex justify-content-between mt-2">
                        <?= Html::button('Редактировать', [
                            'class' => 'btn btn-sm btn-success mt-auto text-light',
                            'data-bs-toggle' => 'modal',
                            'data-bs-target' => '#updateRecordModal',
                            'data-url' => Url::to(['record/update', 'id' => $record->id]),
                            'data-id' => $record->id
                        ]) ?>

                        <a href="<?= Url::to(['record/view', 'id' => $record->id]) ?>" class="btn btn-sm btn-cus-main mt-auto text-light">Подробнее</a>
                    </div>

                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>


<?php
Modal::begin([
    'title' => 'Создать запись',
    'id' => 'createRecordModal',
    'size' => Modal::SIZE_LARGE,
    'options' => [
        'class' => 'custom-modal',
    ],
]);
?>
<div id="createRecordContent"></div>
<?php Modal::end(); ?>

<?php
Modal::begin([
    'title' => 'Редактировать запись',
    'id' => 'updateRecordModal',
    'size' => Modal::SIZE_LARGE,
    'options' => [
        'class' => 'custom-modal',
    ],
]);
?>
<div id="updateRecordContent"></div>
<?php Modal::end(); ?>


<?php
$this->registerJs(<<<JS
$('#createRecordModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var url = button.data('url');
    $('#createRecordModal .modal-body').html('<div class="text-center p-3">Загрузка...</div>');
    $.get(url, function(data) {
        $('#createRecordModal .modal-body').html(data);
    });
});

$('#updateRecordModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var url = button.data('url');
    $('#updateRecordContent').html('<div class="text-center p-3">Загрузка...</div>');
    $.get(url, function(data) {
        $('#updateRecordContent').html(data);
    });
});
JS);

$this->registerCssFile('https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css');
$this->registerJsFile('https://code.jquery.com/ui/1.13.2/jquery-ui.min.js', ['depends' => JqueryAsset::class]);

$this->registerJsFile('@web/js/record/index.js', ['depends' => JqueryAsset::class]);
$this->registerCssFile('@web/css/task/index.css');

?>