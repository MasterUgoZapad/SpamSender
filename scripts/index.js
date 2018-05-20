function CollectLoginDataToObject() {
    var user = {};
    user['login'] = document.getElementById('login').value;
    user['pass'] = document.getElementById('pass').value;
    return user;
}

function Login() {
    var user = CollectLoginDataToObject();
    if (CheckIfValid(user))
    {
        $.post({
            dataType: "json",
            url: 'rest/request_handler.php?action=login',
            data: user,
            success: function (data) {
                if (CheckResponce(data)) {
                    location.href = "main.php";
                }
            },
            error: function (data) {
                ResponceFailed(data);
            }
        });
    }
}
