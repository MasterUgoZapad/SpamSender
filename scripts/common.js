var mass_operation_in_progress = false;

function StringifyPeople(man) {
    return BlankOrValue(man["m_name"]) + ' ' + BlankOrValue(man["m_surname"]) + ' ' + BlankOrValue(man["m_fname"]);
}

function StringifyUsers(user) {
    var login = BlankOrValue(user["m_login"]);
    var level = user["m_level"];
    if (level == 1)
        return login + " User";
    else if (level ==2)
        return login + " Admin";
    return login + " Undefined";
}

function StringifyGroup(group) {
    return group["m_name"];
}

function StringifyTemplate(template) {
    return template["m_name"];
}

function StringifyAlias(aliase) {
    return "For " + aliase['m_field'] + " field : " + aliase['m_aliase'];
}

function StringifyEmail(email) {
    return email["m_value"];
}

function Falue(message, server_message) {
    var error_message = document.getElementById("labelError");
    error_message.textContent = message;
    var info_message = document.getElementById("labelAdditionalInfo");
    if (CheckIfValidOrEmpty(server_message))
        info_message.textContent = "With message : " + server_message;
    else
        info_message.textContent = "";
    var error = document.getElementById("wrapError");
    error.style.display = "flex";
    HideProgress();
}

function HideFalue() {
    var error = document.getElementById("wrapError");
    error.style.display = "none";
}

function Submit(message, on_sunbmit_function, parameters) {
    var message_label = document.getElementById("labelSubmit");
    message_label.textContent = message;
    document.getElementById("submit_button_ok").onclick = function() {
        HideSubmit();
        on_sunbmit_function(parameters);
    };
    var wrap = document.getElementById("wrapSubmit");
    wrap.style.display = "flex";
}

function HideSubmit() {
    document.getElementById("submit_button_ok").onclick = function() {
        HideSubmit();
    };
    var wrap = document.getElementById("wrapSubmit");
    wrap.style.display = "none";
}

function Progress(message, new_operation){
    if(new_operation){
        if (mass_operation_in_progress) {
            Falue("Another operation in progress");
            return false;
        }
        mass_operation_in_progress = true;
    }
    else {
        if (!mass_operation_in_progress) {
            Falue("Operation was cancelled");
            return false;
        }
    }
    var message_label = document.getElementById("labelOperation");
    message_label.textContent = message;
    var wrap = document.getElementById("progress");
    wrap.style.display = "flex";
    return true;
}

function HideProgress(){
    mass_operation_in_progress = false;
    var wrap = document.getElementById("progress");
    wrap.style.display = "none";
}

function RemoveOptions(select_id) {
    var select = document.getElementById(select_id);
    while (select.options.length) {
        select.remove(0);
    }
}

function UpdateSelectContent(responce, select_id, stringify_func) {
    if (CheckIfValid(responce["size"])) {
        // Clear select
        var select = document.getElementById(select_id);
        RemoveOptions(select_id);
        // Populate select
        var list_size = responce["size"];
        for (var i = 0; i < list_size; ++i) {
            var description = stringify_func(responce[i]);
            var new_option = document.createElement("option");
            new_option.text = description;
            var string_object = JSON.stringify(responce[i]);
            new_option.value = string_object;
            var id = select_id + responce[i]['m_index']
            new_option.id = id;
            select.appendChild(new_option);
        }
    }
    else
        Falue(error_server_invalid_responce);
}

function PopulateDatalist(values, datalistid) {
    RemoveOptions(datalistid);
    var list = document.getElementById(datalistid);
    var list_size = values["size"];
    if (CheckIfValid(list_size)) {
        for (var i = 0; i < list_size; ++i) {
            var option = document.createElement('option');
            option.value = values[i];
            list.appendChild(option);
        }
    }
    else
        Falue(error_server_invalid_responce);
}

function AddSelectNullOption(select_id, option_name) {
    var select = document.getElementById(select_id);
    if (CheckIfValid(select)) {
        var new_option = document.createElement("option");
        new_option.text = option_name;
        new_option.value = null;
        var id = select_id + "nullOptionId";
        new_option.id = id;
        select.appendChild(new_option);
        new_option.selected = true;
    }
}

function BlankOrValue(value) {
    if (CheckIfValid(value))
        return value;
    else
        return '';
}

function GetURLParamsArray() {
    var params = {};
    var url = window.location.href;
    var url_params = url.split('?');
    if (url_params.length > 1) {
        var param_array = url_params[1].split('&');
        for (var i in param_array) {
            x = param_array[i].split('=');
            params[x[0]] = x[1];
        }
        return params;
    }
    return null;
}

function CheckIfValid(value) {
    if (value !== undefined && value !== null)
        return true;
    else
        return false;
}

function CheckIfValidOrEmpty(value) {
    if (CheckIfValid(value) && value != '')
        return true;
    else
        return false;
}

function CheckIfValidEmail(mail)
{
    if (CheckIfValidOrEmpty(mail) &&  /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(mail))
    {
        return true;
    }
    return false;
}

function GetSelectedValue(select_id) {
    var list = document.getElementById(select_id);
    var current_index = list.selectedIndex;
    if (current_index != -1) {
        var option = list.options[current_index];
        var string = option.value;
        return JSON.parse(string);
    }
    return null;
}

function ApplyGroupData(group_members, list_size, text_area_id, value_handler) {
    var text_area = document.getElementById(text_area_id);
    text_area.textContent = "";
    for (var i = 0; i < list_size; ++i) {
        var description = value_handler(group_members[i]);
        text_area.textContent = text_area.textContent + description + "\n";
    }
    if (list_size > 50)
        list_size = 50;
    if (list_size < 10)
        list_size = 10;
    text_area.rows = list_size;
}

function RefreshRoles() {
    $.get({
        dataType: "json",
        url: "rest/request_handler.php?action=get_roles",
        //data: data,
        success: function (data) {
            if (CheckResponce(data)) {
                PopulateDatalist(data, "defined_roles");
            }
        },
        error: function(data){
            ResponceFailed(data);
        }
    });
}

function RefreshTowns() {
    $.get({
        dataType: "json",
        url: "rest/request_handler.php?action=get_towns",
        success: function (data) {
            if (CheckResponce(data)) {
                PopulateDatalist(data, "defined_town");
            }
        },
        error: function(data){
            ResponceFailed(data);
        }
    });
}

function RefreshAreas() {
    $.get({
        dataType: "json",
        url: "rest/request_handler.php?action=get_areas",
        success: function (data) {
            if (CheckResponce(data)) {
                PopulateDatalist(data, "defined_area");
            }
        },
        error: function(data){
            ResponceFailed(data);
        }
    });
}

function RefreshOrigins() {
    $.get({
        dataType: "json",
        url: "rest/request_handler.php?action=get_origins",
        success: function (data) {
            if (CheckResponce(data)) {
                PopulateDatalist(data, "defined_origin");
            }
        },
        error: function(data){
            ResponceFailed(data);
        }
    });
}

function GetHumanData(index, data_handler) {
    $.get({
        dataType: "json",
        url: "rest/request_handler.php?action=get_human_data",
        data: {"index": index},
        success: function (data) {
            if (CheckResponce(data)) {
                data_handler(data['human']);
            }
        },
        error: function(data){
            ResponceFailed(data);
        }
    });
}

function GetTemplateData(index, data_handler) {
    $.get({
        dataType: "json",
        url: "rest/request_handler.php?action=get_template_data",
        data: {'index': index},
        success: function (data) {
            if (CheckResponce(data)) {
                data_handler(data['template']);
            }
        },
        error: function(data){
            ResponceFailed(data);
        }
    });
}

function MailToString(responce, maxlen){
    var email_string = '';
    if (CheckIfValid(responce["size"])) {
        var list_size = responce["size"];
        for (var i = 0; i < list_size; ++i) {
            email_string += responce[i]['m_value'];
            var length = email_string.length;
            if (length >= maxlen) {
                email_string = email_string.substr(0, maxlen);
                email_string += '...';
                return email_string;
            }
            if (i < list_size-1) {
                email_string += ', ';
            }
        }
    }
    return email_string;
}

function CheckResponce(response){
    var status = response['status'];
    var error_code = response['error_code'];
    var error_message = response['error_message'];
    if (!CheckIfValid(status) || status == false){
        if (CheckIfValid(error_code))
            var message = GetErrorMessageByServerErrorSode(error_code);
        else
            message = error_server_default;
        Falue(message, error_message);
        return false;
    }
    else
        return true;
}

function ResponceFailed(response){
    Falue(error_rest_failed);
}

function LogOut(){
    $.get({
        url: 'rest/request_handler.php?action=logout',
        dataType: "json",
        success: function (data) {
            CheckResponce(data);
            location.href = "index.php";
        },
        error: function(data){
            ResponceFailed(data);
        }
    });
}