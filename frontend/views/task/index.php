<?php

use frontend\enum\task\TaskPriorityEnum;
use yii\bootstrap5\Modal;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JqueryAsset;

/**
 * @var $newTaskModel
 * @var $tasks
 */


$this->title = 'Задачи';

$statuses = [
    'new' => 'Новые',
    'in_progress' => 'В работе',
    'done' => 'Выполнено',
    'canceled' => 'Отменено',
];

$groupedTasks = [];
foreach ($tasks as $task) {
    $groupedTasks[$task->status][] = $task;
}
?>


<?= $this->render('_header') ?>

<div class="task-index">
    <div class="row">
        <?php foreach ($statuses as $statusCode => $statusLabel): ?>
            <div class="col-md-3">
                <div class="card mb-3">
                    <div class="card-header bg-info text-white">
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
                                        <small style="color:#6c757d;"><?= Html::encode($task->description) ?></small>
                                        <div class="d-flex justify-content-between mt-2">
                                            <?= Html::a('Подробнее', ['view', 'id' => $task->id], ['class' => 'btn btn-sm btn-info text-light']) ?>
                                            <?= Html::button('Редактировать', [
                                                'class' => 'btn btn-sm btn-cus-success update-task-btn',
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
echo $this->render('_form', ['model' => $newTaskModel]);
Modal::end();

Modal::begin([
    'title' => 'Обновить задачу',
    'id' => 'updateTaskModal',
    'size' => Modal::SIZE_LARGE,
    'options' => [
        'class' => 'custom-modal',
    ],
]);
echo '<div id="updateTaskModalContent">Загрузка...</div>';
Modal::end();
?>

<?php
$indexUrl = Url::to(['task/index']);

$this->registerCssFile('https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css');
$this->registerJsFile('https://code.jquery.com/ui/1.13.2/jquery-ui.min.js', ['depends' => JqueryAsset::class]);

$this->registerJsFile('@web/js/task/index.js', ['depends' => JqueryAsset::class]);
$this->registerCssFile('@web/css/task/index.css');

?>

<script>
    const updateUrl = "<?= Url::to(['task/change-status']) ?>";
    const updateFormUrl = "<?= Url::to(['task/update']) ?>";
    const createFormUrl = "<?= Url::to(['task/create']) ?>";
</script>