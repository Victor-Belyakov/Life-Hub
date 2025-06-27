<?php
use frontend\enum\TaskPriorityEnum;
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

<div class="task-index">
    <p>
        <?= Html::button('Создать задачу', [
            'class' => 'btn btn-success text-light',
            'data-bs-toggle' => 'modal',
            'data-bs-target' => '#createTaskModal'
        ]) ?>
    </p>

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
                                                'class' => 'btn btn-sm btn-success update-task-btn',
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
// Модалка для создания
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
$updateUrl = Url::to(['task/change-status']);
$formUrl = Url::to(['task/update']);
?>

<?php
$updateUrl = Url::to(['task/change-status']);
$updateFormUrl = Url::to(['task/update']);
$indexUrl = Url::to(['task/index']);

$js = <<<JS
function updateEmptyPlaceholders() {
    $(".task-column").each(function() {
        let column = $(this);
        let emptyText = column.find(".empty-placeholder");
        if (column.find(".task-item").length === 0) {
            if (emptyText.length === 0) {
                column.append('<p class="text-muted empty-placeholder">Нет задач</p>');
            }
        } else {
            emptyText.remove();
        }
    });
}

$(".task-column").sortable({
    connectWith: ".task-column",
    placeholder: "ui-state-highlight",
    receive: function(event, ui) {
        var taskId = ui.item.data("id");
        var newStatus = $(this).data("status");
        $.ajax({
            url: "$updateUrl",
            type: "POST",
            data: {
                id: taskId,
                status: newStatus,
                _csrf: yii.getCsrfToken()
            },
            error: function() {
                alert("Ошибка при изменении статуса");
            }
        });
        updateEmptyPlaceholders();
    },
    update: function() {
        updateEmptyPlaceholders();
    }
}).disableSelection();

updateEmptyPlaceholders();

$(".task-index").on("click", ".update-task-btn", function() {
    var id = $(this).data("id");
    $("#updateTaskModalContent").html("Загрузка...");
    $("#updateTaskModal").modal("show");
    $.get("$updateFormUrl", {id: id}, function(data) {
        $("#updateTaskModalContent").html(data);
        
         // После вставки контента — принудительная инициализация Select2
        $('#updateTaskModalContent').find('select').select2({
            dropdownParent: $('#updateTaskModal')
        });
    });
});

$("#updateTaskModal").on("submit", "#task-form", function(e) {
    e.preventDefault();
    var form = $(this);
    $.ajax({
        url: form.attr("action"),
        type: form.attr("method"),
        data: form.serialize(),
        dataType: "json",
        success: function(response) {
            if (response.success) {
                var task = response.task;
                var card = $('.task-item[data-id="' + task.id + '"]');
                var newColumn = $('.task-column[data-status="' + task.status + '"]');
        
                // Перемещаем карточку в новую колонку, если статус изменился
                if (card.parent().data('status') !== task.status) {
                    card.appendTo(newColumn);
                }
        
                // Обновляем текст заголовка и описания
                card.find("strong").text(task.title);
                card.find("small").text(task.description);
        
                // Обновляем бейдж приоритета
                card.find(".badge")
                    .text(task.priorityLabel)
                    .removeClass("badge-low badge-medium badge-high")
                    .addClass(task.priorityClass);
        
                // Обновляем цвет обводки — удаляем все возможные классы border и добавляем нужный
                card
                    .removeClass("border-low border-medium border-high")
                    .addClass("border-" + task.priorityClass.replace('badge-', ''));

                // Закрываем модалку
                $("#updateTaskModal").modal("hide");
                updateEmptyPlaceholders();
            } else {
                // Показать ошибки
                var errors = response.errors;
                form.yiiActiveForm("updateMessages", errors, true);
            }
        },
        error: function() {
            alert("Ошибка при сохранении задачи");
        }
    });
});
JS;

$this->registerJsFile('https://code.jquery.com/jquery-3.6.0.min.js', ['position' => \yii\web\View::POS_HEAD]);
$this->registerCssFile('https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css');
$this->registerJsFile('https://code.jquery.com/ui/1.13.2/jquery-ui.min.js', ['depends' => JqueryAsset::class]);
$this->registerCssFile('@web/css/task/index.css');

?>
