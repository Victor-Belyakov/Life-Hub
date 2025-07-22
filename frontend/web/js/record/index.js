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