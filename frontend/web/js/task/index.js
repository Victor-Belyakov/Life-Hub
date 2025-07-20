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

$("#createTaskModal").on("submit", "#task-form", function(e) {
    e.preventDefault();
    let form = $(this);

    $.ajax({
        url: form.attr('action'),
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
