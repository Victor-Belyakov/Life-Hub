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