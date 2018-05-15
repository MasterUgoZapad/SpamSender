// global data
var current_man_index = undefined;

window.onload = function () {
    GetEmailsFromRequest();
};

function GetEmailsFromRequest() {
    var params = GetURLParamsArray();
    if (CheckIfValid(params)) {
        var man_string = params['man'];
        var index = decodeURI(man_string);
        if (CheckIfValid(index)) {
            GetHumanData(index, ApplyManData);
            RefreshHumanEmails(index);
        }
        else
            Falue(error_url_invalid_parameters);
    }
}

function ApplyManData(man) {
    current_man_index = man['m_index'];
    var label = document.getElementById("ManDecription");
    label.textContent = "Mails Of: " + StringifyPeople(man);
}

function RefreshHumanEmails(index) {
    if (CheckIfValid(index)) {
        $.get({
            dataType: "json",
            url: "rest/request_handler.php?action=get_emails",
            data: {"index": index},
            success: function (data) {
                if (CheckResponce(data)) {
                    UpdateSelectContent(data, "EmailListSelect", StringifyEmail);
                }
            },
            error: function(data){
                ResponceFailed(data);
            }
        });
    }
}

function DeleteEmail() {
    var email = GetSelectedValue("EmailListSelect");
    if (CheckIfValid(email)) {
        var mail_index = email['m_index'];
        Submit(submit_delete_element, DeleteEmailByIndex, mail_index);
    }
    else
        Falue(error_element_not_selected);
}

function DeleteEmailByIndex(mail_index){
    if (CheckIfValid(mail_index)) {
        $.get({
            url: 'rest/request_handler.php?action=delete_email',
            dataType: "json",
            data: {'mail': mail_index},
            success: function (data) {
                if (CheckResponce(data)) {
                    RefreshHumanEmails(current_man_index);
                }
            },
            error: function(data){
                ResponceFailed(data);
            }
        });
    }
}

function AddEmail() {
    var mail = document.getElementById('mail').value;
    $.post({
        dataType: "json",
        url: 'rest/request_handler.php?action=add_email',
        data: {'index': current_man_index, 'mail': mail},
        success: function (data) {
            if (CheckResponce(data)) {
                RefreshHumanEmails(current_man_index);
            }
        },
        error: function(data){
            ResponceFailed(data);
        }
    });
}