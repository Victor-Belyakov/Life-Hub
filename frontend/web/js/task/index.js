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

$(document).on("submit", "#task-form", function(e) {
    e.preventDefault();
    var form = $(this);
    $.ajax({
        url: form.attr('action'),
        type: 'POST',
        data: form.serialize(),
        dataType: "json",
        success: function(response) {
            if (response.success) {
                $("#createTaskModal").modal("hide");
                location.reload();
            } else if (response.errors) {
                form.yiiActiveForm("updateMessages", response.errors, true);
            }
        },
        error: function() {
            alert("Ошибка при создании задачи");
        }
    });
});

$(document).on("submit", "#task-update-form", function(e) {
    e.preventDefault();
    var form = $(this);
    $.ajax({
        url: form.attr('action'),
        type: 'POST',
        data: form.serialize(),
        dataType: "json",
        success: function(response) {
            if (response.success) {
                $("#updateTaskModal").modal("hide");
                location.reload();
            } else if (response.errors) {
                form.yiiActiveForm("updateMessages", response.errors, true);
            }
        },
        error: function() {
            alert("Ошибка при обновлении задачи");
        }
    });
});

$('#createTaskModal').on('show.bs.modal', function (event) {
    let button = $(event.relatedTarget);
    let url = button.data('url');
    $('#createTaskModal .modal-body').html('<div class="text-center p-3">Загрузка...</div>');
    $.get(url, function(data) {
        $('#createTaskModal .modal-body').html(data);
        initDatePicker("#createTaskModal")
    });
});

$('#updateTaskModal').on('show.bs.modal', function (event) {
    let button = $(event.relatedTarget);
    let url = button.data('url');
    $('#updateTaskModal .modal-body').html('<div class="text-center p-3">Загрузка...</div>');
    $.get(url, function(data) {
        $('#updateTaskModal .modal-body').html(data);
        initDatePicker("#updateTaskModal")
    });
});

$('#viewTaskModal').on('show.bs.modal', function (event) {
    let button = $(event.relatedTarget);
    let url = button.data('url');
    $('#viewTaskModal .modal-body').html('<div class="text-center p-3">Загрузка...</div>');
    $.get(url, function(data) {
        $('#viewTaskModal .modal-body').html(data);
    });
});

function initDatePicker(id) {
    flatpickr(`${id} .modal-body .datepicker`, {
        altInput: true,
        altFormat: "d-m-Y",
        dateFormat: "Y-m-d",
        locale: "ru"
    });
}
