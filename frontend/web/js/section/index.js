$(document).on('click', '.update-tag-btn', function() {
    const id = $(this).data('id');

    $.ajax({
        url: '/tag/update',
        data: { id: id },
        success: function(html) {
            $('#updateTagModal .modal-body').html(html);
            $('#updateTagModal').modal('show');
        },
        error: function() {
            alert('Ошибка загрузки формы редактирования');
        }
    });
});

$("#createTagModal").on("submit", "#tag-form", function(e) {
    e.preventDefault();
    let form = $(this);

    $.ajax({
        url: form.attr("action"),
        type: form.attr('action', '/tag/create'),
        data: form.serialize(),
        dataType: "json",
        success: function(response) {
            if (response.success) {
                $("#createTagModal").modal("hide");
                location.reload();
            } else {
                form.yiiActiveForm("updateMessages", response.errors, true);
            }
        },
        error: function() {
            alert("Ошибка при создании раздела для записей");
        }
    });
});

$("#updateTagModal").on("submit", "#tag-form", function(e) {
    e.preventDefault();
    let id = button.data('id');
    let form = $(this);

    $.ajax({
        url: form.attr("action"),
        type: form.attr('action', '/tag/update?id=' + id),
        data: form.serialize(),
        dataType: "json",
        success: function(response) {
            if (response.success) {
                $("#updateTagModal").modal("hide");
                location.reload();
            } else {
                form.yiiActiveForm("updateMessages", response.errors, true);
            }
        },
        error: function() {
            alert("Ошибка при редактировании раздела для записей");
        }
    });
});
