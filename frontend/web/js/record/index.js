
$("#createRecordModal").on("submit", "#record-form", function(e) {
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
            alert("Ошибка при создании записи");
        }
    });
});
