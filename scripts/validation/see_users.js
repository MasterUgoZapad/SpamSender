$(function () {
    $("form[name='userForm']").validate({
        rules: {
            login: {
                required: true,
                minlength: 4
            },
            pass: {
                required: true,
                minlength: 4
            },
        },
        messages: {
            login: {
                required: "Login is required",
                minlength: "Login is too short"
            },
            pass: {
                required: "Password is required",
                minlength: "Password is too short"
            },
        },
        submitHandler: function (form) {
            Submit(submit_save_data, AddUser);
        }
    });
});
