<?php

use frontend\enum\task\TaskPriorityEnum;
use frontend\enum\task\TaskStatusEnum;
use yii\bootstrap5\Modal;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JqueryAsset;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/**
 * @var $newTaskModel
 * @var $groupedTasks
 * @var $searchModel
 */


$this->title = 'Задачи';


$statuses = TaskStatusEnum::labels();

?>

<?= $this->render('_header', [
    'searchModel' => $searchModel,
]) ?>

<div class="task-index">
    <div class="row flex-nowrap overflow-auto">

        <?php foreach ($statuses as $statusCode => $statusLabel): ?>
            <div class="col-md-2" style="min-width: 325px;">
                <div class="card mb-3">
                    <div class="card-header bg-main text-white">
                        <?= Html::encode($statusLabel) ?>
                    </div>

                    <div class="card-body task-column" data-status="<?= $statusCode ?>" style="min-height: 200px;">
                        <?php if (!empty($groupedTasks[$statusCode])): ?>

                            <?php foreach ($groupedTasks[$statusCode] as $task): ?>

                                <?php $priorityEnum = TaskPriorityEnum::fromValue($task->priority); ?>
                                <div class="card mb-2 task-item border-<?= $priorityEnum?->value ?>" data-id="<?= $task->id ?>">
                                    <div class="card-body p-2">
                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                            <strong style="color:#6c757d;"><?= Html::encode($task->title) ?></strong>
                                            <span class="badge <?= $priorityEnum?->badgeClass() ?>">
                                                <?= Html::encode($priorityEnum?->label()) ?>
                                            </span>
                                        </div>
                                        <div>
                                            <strong style="color:#6c757d;">Исполнитель: </strong>
                                            <small style="color:#6c757d;"><?= Html::encode($task->executor->fullName) ?></small>
                                        </div>

                                        <div class="d-flex justify-content-between mt-2">
                                            <?= Html::button('Редактировать', [
                                                'class' => 'btn btn-sm btn-success mt-auto text-light',
                                                'data-bs-toggle' => 'modal',
                                                'data-bs-target' => '#updateTaskModal',
                                                'data-url' => Url::to(['task/update', 'id' => $task->id]),
                                                'data-id' => $task->id
                                            ]) ?>

                                            <?= Html::button('Подробнее', [
                                                'class' => 'btn btn-sm btn-cus-main mt-auto text-light',
                                                'data-bs-toggle' => 'modal',
                                                'data-bs-target' => '#viewTaskModal',
                                                'data-url' => Url::to(['task/view', 'id' => $task->id]),
                                                'data-id' => $task->id
                                            ]) ?>
                                        </div>
                                    </div>
                                </div>

                            <?php endforeach; ?>

                        <?php else: ?>
                            <p class="text-muted empty-placeholder">Нет задач</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>

    </div>
</div>

<?php
Modal::begin([
    'title' => 'Создать задачу',
    'id' => 'createTaskModal',
    'size' => Modal::SIZE_LARGE,
    'options' => [
        'class' => 'custom-modal',
    ],
]);
?>
<div id="createTaskContent"></div>
<?php Modal::end(); ?>

<?php
Modal::begin([
    'title' => 'Редактировать задачу',
    'id' => 'updateTaskModal',
    'size' => Modal::SIZE_LARGE,
    'options' => [
        'class' => 'custom-modal',
    ],
]);
?>
<div id="updateTaskContent"></div>
<?php Modal::end(); ?>

<?php
Modal::begin([
    'title' => 'Просмотр задачи',
    'id' => 'viewTaskModal',
    'size' => Modal::SIZE_LARGE,
    'options' => [
        'class' => 'custom-modal',
    ],
]);
?>
<div id="viewTaskContent"></div>
<?php Modal::end(); ?>


<?php
$indexUrl = Url::to(['task/index']);

$this->registerCssFile('https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css');
$this->registerJsFile('https://code.jquery.com/ui/1.13.2/jquery-ui.min.js', ['depends' => JqueryAsset::class]);

$this->registerJsFile('@web/js/task/index.js', ['depends' => JqueryAsset::class]);
$this->registerCssFile('@web/css/task/index.css');

?>

<script>
    const updateUrl = "<?= Url::to(['task/change-status']) ?>";
</script>