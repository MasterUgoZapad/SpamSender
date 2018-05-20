// global data
var current_man_index = undefined;

window.onload = function () {
    RefreshRoles();
    RefreshTowns();
    RefreshAreas();
    RefreshOrigins();
    GetManFromRequest();
};

function GetManFromRequest() {
    var params = GetURLParamsArray();
    if (CheckIfValid(params)) {
        var man_string = params['man'];
        var index = decodeURI(man_string);
        if (CheckIfValid(index))
            GetHumanData(index, ApplyManData);
        else
            Falue(error_url_invalid_parameters);
    }
}

function ClearForms() {
    current_man_index = undefined;
    ApplyManData({});
}

function ApplyManData(man) {
    current_man_index = man['m_index'];
    var buffer = man['m_name'];
    document.getElementById('name').value = BlankOrValue(buffer);
    buffer = man['m_surname'];
    document.getElementById('sname').value = BlankOrValue(buffer);
    buffer = man['m_fname'];
    document.getElementById('fname').value = BlankOrValue(buffer);
    buffer = man['m_age'];
    document.getElementById('age').value = BlankOrValue(buffer);
    buffer = man['m_area'];
    document.getElementById('area').value = BlankOrValue(buffer);
    buffer = man['m_town'];
    document.getElementById('town').value = BlankOrValue(buffer);
    buffer = man['m_role'];
    document.getElementById('role').value = BlankOrValue(buffer);
    buffer = man['m_origin'];
    document.getElementById('origin').value = BlankOrValue(buffer);
}

function CollectManDataToObject() {
    var man = {};
    man['name'] = document.getElementById('name').value;
    man['surname'] = document.getElementById('sname').value;
    man['fname'] = document.getElementById('fname').value;
    man['age'] = document.getElementById('age').value;
    man['area'] = document.getElementById('area').value;
    man['town'] = document.getElementById('town').value;
    man['role'] = document.getElementById('role').value;
    man['origin'] = document.getElementById('origin').value;
    return man;
}

function SubmitData() {
    var man = CollectManDataToObject();
    if (CheckIfValid(current_man_index)) {
        man['index'] = current_man_index;
        EditHuman(man);
    }
    else
        AddHuman(man);
}

function EditHuman(man) {
    $.post({
        url: 'rest/request_handler.php?action=edit_human',
        dataType: "json",
        data: man,
        success: function (data) {
            if (CheckResponce(data)) {
                ClearForms();
                location.href = "see_people.php";
            }
        },
        error: function(data){
            ResponceFailed(data);
        }
    });
}

function AddHuman(man) {
    $.post({
        dataType: "json",
        url: 'rest/request_handler.php?action=add_human',
        data: man,
        success: function (data) {
            if (CheckResponce(data)) {
                ClearForms();
                location.href = "add_people.php";
            }
        },
        error: function(data){
            ResponceFailed(data);
        }
    });
}