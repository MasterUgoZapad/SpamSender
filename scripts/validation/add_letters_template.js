$(function () {
    $("form[name='formTemplate']").validate({
        rules: {
            name: "required",
            theme: "required",
        },
        messages: {
            name: "Name is required",
            theme: "Theme is required",
        },
        submitHandler: function (form) {
            Submit(submit_save_data,SubmitData);
        }
    });
});
