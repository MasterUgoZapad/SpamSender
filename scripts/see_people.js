window.onload = function() {
    ApplyManData({});
    RefreshPeople();
};

function RefreshPeople(){
    $.ajax({
        type: "GET",
        dataType: "json",
        url: "rest/request_handler.php?action=get_people",
        //data: data,
        success: function(data) {
            UpdateSelectContent(data, "PeopleListSelect", StringifyPeople);
            ApplyManData({});
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
            success: function (responce) {
                RefreshPeople(responce);
            },
            error: function (responce) {
                Falue(responce);
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
}

function ManageEmails(){
    var man = GetSelectedValue("PeopleListSelect");
    if (CheckIfValid(man)) {
        var link = 'add_email.php?man=';
        var index = man['m_index'];
        link = link+index;
        location.href = link;
    }
}

function SendToPeople(){
    var man = GetSelectedValue("PeopleListSelect");
    if (CheckIfValid(man)) {
        var link = 'send_letters.php?man=';
        var index = man['m_index'];
        link = link+index;
        location.href = link;
    }
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

function RefreshHumanEmails(index) {
    var email_label = document.getElementById('mail');
    if (CheckIfValid(index)) {
        $.get({
            dataType: "json",
            url: "rest/request_handler.php?action=get_emails",
            data: {"index": index},
            success: function (data) {
                email_label.textContent = MailToString(data, 30);
            }
        });
    }
}

