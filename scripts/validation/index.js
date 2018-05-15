$(function () {
    $("form[name='formLogin']").validate({
        rules: {
            login: "required",
            pass: "required",
        },
        messages: {
            login: "required",
            pass: "required",
        },
        submitHandler: function (form) {
            //Submit(submit_save_data,SubmitData);
        }
    });
});
