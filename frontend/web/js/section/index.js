$(document).on('click', '.update-section-btn', function() {
    let id = $(this).data('id');
    $.ajax({
        url: '/section/update',
        data: {id: id},
        success: function(html) {
            console.log(html)
            $('#updateSectionModal .modal-body').html(html);
            $('#updateSectionModal').modal('show');
        },
        error: function() {
            alert('Ошибка загрузки формы редактирования');
        }
    });
});



$("#createSectionModal").on("submit", "#section-form", function(e) {
    e.preventDefault();
    let form = $(this);

    $.ajax({
        url: form.attr("action"),
        type: form.attr("method"),
        data: form.serialize(),
        dataType: "json",
        success: function(response) {
            if (response.success) {
                $("#createSectionModal").modal("hide");
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

$("#updateSectionModal").on("submit", "#section-form", function(e) {
    e.preventDefault();
    let form = $(this);

    $.ajax({
        url: form.attr("action"),
        type: form.attr("method"),
        data: form.serialize(),
        dataType: "json",
        success: function(response) {
            if (response.success) {
                $("#updateSectionModal").modal("hide");
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
