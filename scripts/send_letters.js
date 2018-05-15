// global data
var current_template_index = undefined;
var current_group_index = undefined;
var current_man_index = undefined;

window.onload = function () {
    RefreshGroups();
    RefreshTemplates();
    GetHumanFromRequest();
};

function GetTemplateFromRequest() {
    var params = GetURLParamsArray();
    if (CheckIfValid(params)) {
        var index = params['template'];
        if (CheckIfValid(index)) {
            GetTemplateData(index, ApplyTemplateData);
        }
    }
}

function GetHumanFromRequest() {
    var params = GetURLParamsArray();
    if (CheckIfValid(params)) {
        var index = params['man'];
        if (CheckIfValid(index)) {
            GetHumanData(index, ApplyHumanData);
        }
    }
}

function GetGroupFromRequest() {
    var params = GetURLParamsArray();
    if (CheckIfValid(params)) {
        var index = params['group'];
        if (CheckIfValid(index)) {
            $.get({
                dataType: "json",
                url: "rest/request_handler.php?action=get_group_name",
                data: {'index': index},
                success: function (data) {
                    if (CheckResponce(data)) {
                        ApplyGroupNameData(data);
                    }
                },
                error: function(data){
                    ResponceFailed(data);
                }
            });
        }
    }
}

function ApplyHumanData(human) {
    current_man_index = human['m_index'];
    SetDestination(StringifyPeople(human));
    $.get({
        dataType: "json",
        url: "rest/request_handler.php?action=get_emails",
        data: {"index": human['m_index']},
        success: function (data) {
            if (CheckResponce(data)) {
                document.getElementById('to').value = MailToString(data, 30);
            }
        },
        error: function(data){
            ResponceFailed(data);
        }
    });
}

function ApplyTemplateData(template) {
    current_template_index = template['m_index'];
    var buffer = template['m_theme'];
    document.getElementById('theme').value = BlankOrValue(buffer);
    buffer = template['m_text'];
    document.getElementById('text').textContent = BlankOrValue(buffer);
    if (CheckIfValid(current_template_index))
        document.getElementById('templateSelect' + current_template_index).selected = true;
}

function ApplyGroupNameData(group) {
    current_group_index = group['m_index'];
    var buffer = group['m_name'];
    if (CheckIfValid(buffer)) {
        SetDestination(buffer + ' predefined group');
        document.getElementById('to').value = buffer + ' emails';
    }
    if (CheckIfValid(current_group_index))
        document.getElementById('groupSelect' + current_group_index).selected = true;
    else
        document.getElementById('groupSelect' + "nullOptionId").selected = true;
}

function ClearToFields(){
    SetDestination('');
    document.getElementById('to').value = '';
}

function RefreshGroups() {
    $.get({
        dataType: "json",
        url: "rest/request_handler.php?action=get_groups",
        success: function (data) {
            if (CheckResponce(data)) {
                UpdateSelectContent(data, "groupSelect", StringifyGroup);
                AddSelectNullOption("groupSelect", "None group select");
                GetGroupFromRequest();
            }
        },
        error: function(data){
            ResponceFailed(data);
        }
    });
}

function RefreshTemplates() {
    $.get({
        dataType: "json",
        url: "rest/request_handler.php?action=get_templates",
        success: function (data) {
            if (CheckResponce(data)) {
                UpdateSelectContent(data, "templateSelect", StringifyTemplate);
                AddSelectNullOption("templateSelect", "None template select");
                GetTemplateFromRequest();
            }
        },
        error: function(data){
            ResponceFailed(data);
        }
    });
}

function OnTemplateSelect() {
    var template = GetSelectedValue("templateSelect");
    if (CheckIfValid(template))
        $.get({
            dataType: "json",
            url: "rest/request_handler.php?action=get_template_data",
            data: {'index': template['m_index']},
            success: function (data) {
                if (CheckResponce(data)) {
                    ApplyTemplateData(data['template']);
                }
            },
            error: function(data){
                ResponceFailed(data);
            }
        });
    else
        ApplyTemplateData({});
}

function OnGroupSelect() {
    var group = GetSelectedValue("groupSelect");
    if (CheckIfValid(group))
        ApplyGroupNameData(group);
    else
        ClearToFields();
}

function SendLetters() {
    var data = {};
    if (CheckIfValid(current_group_index))
        data['group'] = current_group_index;
    else if (CheckIfValid(current_man_index))
        data['man'] = current_man_index;
    else {
        var raw_email = document.getElementById('to').value;
        if (CheckIfValidEmail(raw_email))
            data['mail'] = raw_email;
        else {
            Falue(error_no_email_to_send);
            return;
        }
    }
    data['theme'] = document.getElementById('theme').value;
    data['text'] = document.getElementById('text').value;
    $.post({
        dataType: "json",
        url: "rest/request_handler.php?action=send_letters",
        data: data,
        success: function (data) {
            CheckResponce(data);
        },
        error: function(data){
            ResponceFailed(data);
        }
    });
}

function OnChangeEmail(){
    current_group_index = undefined;
    current_man_index = undefined;
    SetDestination(document.getElementById('to').value);
    ApplyGroupNameData({});
}

function SetDestination(string){
    if (CheckIfValidOrEmpty(string))
        document.getElementById('labelTo').textContent = "Send letter to :" +string;
    else
        document.getElementById('labelTo').textContent = "";
}