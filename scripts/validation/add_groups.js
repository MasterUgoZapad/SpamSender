$(function () {
    $("form[name='formGroup']").validate({
        rules: {
            group_name: "required",
        },
        messages: {
            group_name: "Name is required",
        },
        submitHandler: function (form) {
            Submit(submit_save_data,AddGroup);
        }
    });
});