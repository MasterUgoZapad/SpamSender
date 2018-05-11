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

function ApplySelectData(select) {
    current_man_index = select['m_index'];
    var buffer = select['m_name'];
    document.getElementById('name').value = BlankOrValue(buffer);
    buffer = select['m_group_name'];
    document.getElementById('group_name').value = BlankOrValue(buffer);
    buffer = select['m_surname'];
    document.getElementById('sname').value = BlankOrValue(buffer);
    buffer = select['m_fname'];
    document.getElementById('fname').value = BlankOrValue(buffer);
    buffer = select['m_area'];
    document.getElementById('area').value = BlankOrValue(buffer);
    buffer = select['m_town'];
    document.getElementById('town').value = BlankOrValue(buffer);
    buffer = select['m_role'];
    document.getElementById('role').value = BlankOrValue(buffer);
    buffer = select['m_origin'];
    document.getElementById('origin').value = BlankOrValue(buffer);
}

function AddGroup(){
    var selection = CollectSelectDataToObject();
    selection['group_name'] = document.getElementById('group_name').value;
    $.post({
        url: 'rest/request_handler.php?action=add_group',
        dataType: "json",
        data: selection,
        success: function(group) {
            ApplyDefaultData();
            location.href = "add_groups.php"
        },
        error: function(responce) {
            Falue(responce);
        }
    });
}

function GetGroupBySelection(){
    var selection = CollectSelectDataToObject();
    $.post({
        dataType: "json",
        url: "rest/request_handler.php?action=get_group_by_selection",
        data: selection,
        success: function(group) {
            ApplyGroupData(group, group['size'], "groupExplanationText", StringifyPeople);
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

