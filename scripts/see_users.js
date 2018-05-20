window.onload = function() {
    RefreshUsers();
};

function RefreshUsers(){
    $.ajax({
        type: "GET",
        dataType: "json",
        url: "rest/request_handler.php?action=get_users",
        //data: data,
        success: function(data) {
            if (CheckResponce(data)) {
                UpdateSelectContent(data, "UsersListSelect", StringifyUsers);
                ApplyDefaultUserData();
            }
        },
        error: function(data){
            ResponceFailed(data);
        }
    });
}

function ApplyDefaultUserData(){
    document.getElementById('login').value = '';
    document.getElementById('pass').value = '';
    document.getElementById('level').value = 1;
}

function CollectUserDataToObject() {
    var user = {};
    user['login'] = document.getElementById('login').value;
    user['pass'] = document.getElementById('pass').value;
    user['level'] = document.getElementById('level').value;
    return user;
}

function AddUser() {
    var user = CollectUserDataToObject();
    if (CheckIfValid(user))
    {
        $.post({
            dataType: "json",
            url: 'rest/request_handler.php?action=add_user',
            data: user,
            success: function (data) {
                if (CheckResponce(data)) {
                    ApplyDefaultUserData();
                    RefreshUsers();
                }
            },
            error: function (data) {
                ResponceFailed(data);
            }
        });
    }
}

function DeleteUsers() {
    var user = GetSelectedValue("UsersListSelect");
    if (CheckIfValid(user)) {
        var index = (user['m_index']);
        Submit(submit_delete_element, DeleteUserByIndex, index);
    }
    else
        Falue(error_element_not_selected);
}

function DeleteUserByIndex(index){
    if (CheckIfValid(index)) {
        $.get({
            url: 'rest/request_handler.php?action=delete_user',
            dataType: "json",
            data: {'user': index},
            success: function (data) {
                if (CheckResponce(data)) {
                    RefreshUsers(data);
                }
            },
            error: function(data){
                ResponceFailed(data);
            }
        });
    }
}