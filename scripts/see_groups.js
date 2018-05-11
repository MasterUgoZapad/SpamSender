window.onload = function() {
    RefreshGroups();
};

function RefreshGroups(){
    $.get({
        dataType: "json",
        url: "rest/request_handler.php?action=get_groups",
        success: function(data) {
            UpdateSelectContent(data, "GroupListSelect", StringifyGroup);
        }
    });
}

function OnGroupSelect(){
    var group = GetSelectedValue("GroupListSelect");
    if (CheckIfValid(group)) {
        $.get({
            dataType: "json",
            url: "rest/request_handler.php?action=get_group_data",
            data: {'index': group['m_index']},
            success: function(data) {
                ApplyGroupData(data, data['size'], "groupExplanationText", StringifyPeople);
            }
        });
    }
}

function SendToGroup(){
    var group = GetSelectedValue("GroupListSelect");
    if (CheckIfValid(group)) {
        group_members = group['m_string_storage'];
        var link = 'send_letters.php?group=';
        link = link+group['m_index'];
        location.href = link;
    }
}

function EditGroup(){
    var group = GetSelectedValue("GroupListSelect");
    if (CheckIfValid(group)) {
        var link = 'add_groups.php?group=';
        link = link+JSON.stringify(group);
        location.href = link;
    }
}

function DeleteGroup(){
    var group = GetSelectedValue("GroupListSelect");
    if (CheckIfValid(group)) {
        $.get({
            dataType: "json",
            data: group,
            url: "rest/request_handler.php?action=delete_group",
            success: function(data) {
                RefreshGroups();
                ApplyGroupData({}, 0, "groupExplanationText", StringifyPeople);
            }
        });
    }
}