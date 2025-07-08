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
        let taskId = ui.item.data("id");
        let newStatus = $(this).data("status");

        $.ajax({
            url: updateUrl,
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
    let id = $(this).data("id");
    $("#updateTaskModalContent").html("Загрузка...");
    $("#updateTaskModal").modal("show");

    $.get(updateFormUrl, {id: id}, function(data) {
        $("#updateTaskModalContent").html(data);

        // После вставки контента — принудительная инициализация Select2
        $('#updateTaskModalContent').find('select').select2({
            dropdownParent: $('#updateTaskModal')
        });
    });
});

$("#createTaskModal").on("submit", "#task-form", function(e) {
    e.preventDefault();
    let form = $(this);

    $.ajax({
        url: createFormUrl,
        type: form.attr("method"),
        data: form.serialize(),
        dataType: "json",
        success: function(response) {
            if (response.success) {
                location.reload();
                $("#createTaskModal").modal("hide");
            } else {
                form.yiiActiveForm("updateMessages", response.errors, true);
            }
        },
        error: function() {
            alert("Ошибка при создании задачи");
        }
    });
});

$("#updateTaskModal").on("submit", "#task-form", function(e) {
    e.preventDefault();
    let form = $(this);

    $.ajax({
        url: updateFormUrl,
        type: form.attr("method"),
        data: form.serialize(),
        dataType: "json",
        success: function(response) {
            if (response.success) {
                let task = response.task;
                let card = $('.task-item[data-id="' + task.id + '"]');
                let newColumn = $('.task-column[data-status="' + task.status + '"]');

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

                $("#updateTaskModal").modal("hide");
                updateEmptyPlaceholders();
            } else {
                let errors = response.errors;
                form.yiiActiveForm("updateMessages", errors, true);
            }
        },
        error: function() {
            alert("Ошибка при сохранении задачи");
        }
    });
});