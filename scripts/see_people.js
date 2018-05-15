window.onload = function() {
    ApplyDefaultManData();
    RefreshPeople();
};

function RefreshPeople(){
    $.ajax({
        type: "GET",
        dataType: "json",
        url: "rest/request_handler.php?action=get_people",
        //data: data,
        success: function(data) {
            if (CheckResponce(data)) {
                UpdateSelectContent(data, "PeopleListSelect", StringifyPeople);
                ApplyDefaultManData();
            }
        },
        error: function(data){
            ResponceFailed(data);
        }
    });
}

function DeletePeople() {
    var man = GetSelectedValue("PeopleListSelect");
    if (CheckIfValid(man)) {
        var index = (man['m_index']);
        Submit(submit_delete_element, DeletePeopleByIndex, index);
    }
    else
        Falue(error_element_not_selected);
}

function DeletePeopleByIndex(index){
    if (CheckIfValid(index)) {
        $.get({
            url: 'rest/request_handler.php?action=delete_people',
            dataType: "json",
            data: {'index': index},
            success: function (data) {
                if (CheckResponce(data)) {
                    RefreshPeople(data);
                    ApplyDefaultManData();
                }
            },
            error: function(data){
                ResponceFailed(data);
            }
        });
    }
}

function EditPeople(){
    var man = GetSelectedValue("PeopleListSelect");
    if (CheckIfValid(man)) {
        var link = 'add_people.php?man=';
        var index = man['m_index'];
        link = link+index;
        location.href = link;
    }
    else
        Falue(error_element_not_selected);
}

function ManageEmails(){
    var man = GetSelectedValue("PeopleListSelect");
    if (CheckIfValid(man)) {
        var link = 'add_email.php?man=';
        var index = man['m_index'];
        link = link+index;
        location.href = link;
    }
    else
        Falue(error_element_not_selected);
}

function SendToPeople(){
    var man = GetSelectedValue("PeopleListSelect");
    if (CheckIfValid(man)) {
        var link = 'send_letters.php?man=';
        var index = man['m_index'];
        link = link+index;
        location.href = link;
    }
    else
        Falue(error_element_not_selected);
}

function OnManSelect(){
    var man = GetSelectedValue("PeopleListSelect");
    if (CheckIfValid(man)) {
        GetHumanData(man['m_index'], ApplyManData);
    }
}

function ApplyManData(man) {
    var buffer = man['m_name'];
    document.getElementById('name').textContent = BlankOrValue(buffer);
    buffer = man['m_surname'];
    document.getElementById('sname').textContent = BlankOrValue(buffer);
    buffer = man['m_fname'];
    document.getElementById('fname').textContent = BlankOrValue(buffer);
    buffer = man['m_age'];
    document.getElementById('age').textContent = BlankOrValue(buffer);
    buffer = man['m_year'];
    document.getElementById('regYear').textContent = BlankOrValue(buffer);
    buffer = man['m_area'];
    document.getElementById('area').textContent = BlankOrValue(buffer);
    buffer = man['m_town'];
    document.getElementById('town').textContent = BlankOrValue(buffer);
    buffer = man['m_role'];
    document.getElementById('role').textContent = BlankOrValue(buffer);
    buffer = man['m_origin'];
    document.getElementById('origin').textContent = BlankOrValue(buffer);
    RefreshHumanEmails(man['m_index']);
}

function ApplyDefaultManData() {
    document.getElementById('name').textContent = '';
    document.getElementById('sname').textContent = '';
    document.getElementById('fname').textContent = '';
    document.getElementById('age').textContent = '';
    document.getElementById('regYear').textContent = '';
    document.getElementById('area').textContent = '';
    document.getElementById('town').textContent = '';
    document.getElementById('role').textContent = '';
    document.getElementById('origin').textContent = '';
    document.getElementById('mail').textContent = '';
}

function RefreshHumanEmails(index) {
    var email_label = document.getElementById('mail');
    if (CheckIfValid(index)) {
        $.get({
            dataType: "json",
            url: "rest/request_handler.php?action=get_emails",
            data: {"index": index},
            success: function (data) {
                if (CheckResponce(data)) {
                    email_label.textContent = MailToString(data, 30);
                }
            },
            error: function(data){
                ResponceFailed(data);
            }
        });
    }
}

