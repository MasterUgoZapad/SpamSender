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
        GetHumanData(index, ApplyManData);
        RefreshHumanEmails(index);
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
                UpdateSelectContent(data, "EmailListSelect", StringifyEmail);
            }
        });
    }
}

function DeleteEmail() {
    var email = GetSelectedValue("EmailListSelect");
    if (CheckIfValid(email)) {
        var mail_index = email['m_index'];
        $.get({
            url: 'rest/request_handler.php?action=delete_email',
            dataType: "json",
            data: {'mail': mail_index},
            success: function (responce) {
                RefreshHumanEmails(current_man_index);
            }
        });
    }
}

function AddEmail() {
    var mail = document.getElementById('mail').value;
    $.post({
        url: 'rest/request_handler.php?action=add_email',
        data: {'index': current_man_index, 'mail': mail},
        success: function (responce) {
            RefreshHumanEmails(current_man_index);
        },
        error: function (responce) {
            Falue(responce);
        }
    });
}