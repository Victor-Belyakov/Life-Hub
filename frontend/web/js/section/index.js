$("#createSectionModal").on("submit", "#section-form", function(e) {
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
                $("#createSectionModal").modal("hide");
            } else {
                form.yiiActiveForm("updateMessages", response.errors, true);
            }
        },
        error: function() {
            alert("Ошибка при создании раздела для записей");
        }
    });
});
