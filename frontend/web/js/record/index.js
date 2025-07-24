$(document).on("submit", "#record-form", function(e) {
    e.preventDefault();
    var form = $(this);
    $.ajax({
        url: form.attr('action'),
        type: form.attr('method'),
        data: form.serialize(),
        dataType: "json",
        success: function(response) {
            if (response.success) {
                location.reload();
            } else if (response.errors) {
                form.yiiActiveForm("updateMessages", response.errors, true);
            }
        },
        error: function() {
            alert("Ошибка при сохранении");
        }
    });
});

$('#createRecordModal').on('show.bs.modal', function (event) {
    let button = $(event.relatedTarget);
    let url = button.data('url');
    $('#createRecordModal .modal-body').html('<div class="text-center p-3">Загрузка...</div>');
    $.get(url, function(data) {
        $('#createRecordModal .modal-body').html(data);
    });
});

$('#updateRecordModal').on('show.bs.modal', function (event) {
    let button = $(event.relatedTarget);
    let url = button.data('url');
    $('#updateRecordContent').html('<div class="text-center p-3">Загрузка...</div>');
    $.get(url, function(data) {
        $('#updateRecordContent').html(data);
    });
});

$('#viewRecordModal').on('show.bs.modal', function (event) {
    let button = $(event.relatedTarget);
    let url = button.data('url');
    $('#viewRecordModal .modal-body').html('<div class="text-center p-3">Загрузка...</div>');
    $.get(url, function(data) {
        $('#viewRecordModal .modal-body').html(data);
    });
});

$(function() {
    $(".sortable-records").sortable({
        items: ".sortable-item",
        placeholder: "sortable-placeholder",
        update: function(event, ui) {
            var order = $(this).children('.sortable-item').map(function() {
                return $(this).data('id');
            }).get();
            $.post('/record/sort', {order: order});
        }
    });
    $(".sortable-records").disableSelection();
});