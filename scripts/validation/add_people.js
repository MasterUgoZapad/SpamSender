$(function () {
    $("form[name='formHuman']").validate({
        rules: {
            name: "required",
            sname: "required",
            //fname: "required",
            //age: "required",
            role: "required",
            area: "required",
            town: "required",
            origin: "required",
        },
        messages: {
            name: "Name is required",
            sname: "Surame is required",
            //fname: "Father's name is required",
            //age: "Birthdate is required",
            role: "You should specify a role",
            area: "Area is required",
            town: "Town is required",
            origin: "Origin is required",
        },
        submitHandler: function (form) {
            Submit(submit_save_data,SubmitData);
        }
    });
});