window.onload = function() {
    ApplyDefaultData();
    RefreshRoles();
    RefreshTowns();
    RefreshAreas();
    RefreshOrigins();
};

function CollectSelectDataToObject() {
    var select = {};
    select['name']= document.getElementById('name').value;
    select['surname']= document.getElementById('sname').value;
    select['fname']= document.getElementById('fname').value;
    select['year_from']= document.getElementById('regYearFrom').value;
    select['year_to']= document.getElementById('regYearTo').value;
    select['age_from']= document.getElementById('ageFrom').value;
    select['age_to']= document.getElementById('ageTo').value;
    select['area']= document.getElementById('area').value;
    select['town']= document.getElementById('town').value;
    select['role']= document.getElementById('role').value;
    select['origin']= document.getElementById('origin').value;
    return select;
}

function AddGroup(){
    var selection = CollectSelectDataToObject();
    selection['group_name'] = document.getElementById('group_name').value;
    $.post({
        url: 'rest/request_handler.php?action=add_group',
        dataType: "json",
        data: selection,
        success: function(data) {
            if (CheckResponce(data)) {
                ApplyDefaultData();
                location.href = "add_groups.php";
            }
        },
        error: function(data){
            ResponceFailed(data);
        }
    });
}

function GetGroupBySelection(){
    var selection = CollectSelectDataToObject();
    $.post({
        dataType: "json",
        url: "rest/request_handler.php?action=get_group_by_selection",
        data: selection,
        success: function(data) {
            if (CheckResponce(data)) {
                ApplyGroupData(data, data['size'], "groupExplanationText", StringifyPeople);
            }
        },
        error: function(data){
            ResponceFailed(data);
        }
    });
}

function ApplyDefaultDates(){
    document.getElementById('regYearFrom').value = "2000-01-01";
    document.getElementById('regYearTo').value = "2099-01-01";
    document.getElementById('ageFrom').value = "1900-01-01";
    document.getElementById('ageTo').value = "2099-01-01";
}

function ApplyDefaultData() {
    ApplyDefaultDates();
    document.getElementById('name').value = "%";
    document.getElementById('sname').value = "%";
    document.getElementById('fname').value = "%";
    document.getElementById('area').value = "%";
    document.getElementById('town').value = "%";
    document.getElementById('role').value = "%";
    document.getElementById('origin').value = "%";
}

