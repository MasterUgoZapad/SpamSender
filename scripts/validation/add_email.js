$(function () {
    $("form[name='mailForm']").validate({
        rules: {
            mail: {
                required: true,
                email: true
            },
        },
        messages: {
            mail: "Valid emil is requaired",
        },
        submitHandler: function (form) {
            AddEmail();
        }
    });
});