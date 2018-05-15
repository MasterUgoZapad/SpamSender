window.onload = function() {
    RefreshGroups();
};

function RefreshGroups(){
    $.get({
        dataType: "json",
        url: "rest/request_handler.php?action=get_groups",
        success: function(data) {
            if (CheckResponce(data)) {
                UpdateSelectContent(data, "GroupListSelect", StringifyGroup);
            }
        },
        error: function(data){
            ResponceFailed(data);
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
                if (CheckResponce(data)) {
                    ApplyGroupData(data, data['size'], "groupExplanationText", StringifyPeople);
                }
            },
            error: function(data){
                ResponceFailed(data);
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
    else
        Falue(error_element_not_selected);
}

function DeleteGroup(){
    var group = GetSelectedValue("GroupListSelect");
    if (CheckIfValid(group)) {
        Submit(submit_delete_element, DeleteGroupByIndex, group);
    }
    else
        Falue(error_element_not_selected);
}

function DeleteGroupByIndex(group){
    $.get({
        dataType: "json",
        data: group,
        url: "rest/request_handler.php?action=delete_group",
        success: function(data) {
            if (CheckResponce(data)) {
                RefreshGroups();
                ApplyGroupData({}, 0, "groupExplanationText", StringifyPeople);
            }
        },
        error: function(data){
            ResponceFailed(data);
        }
    });
}