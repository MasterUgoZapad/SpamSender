window.onload = function() {
    ApplyTemplateData({});
    RefreshTemplates();
};

function RefreshTemplates(){
    $.get({
        dataType: "json",
        url: "rest/request_handler.php?action=get_templates",
        success: function(data) {
            if (CheckResponce(data)) {
                UpdateSelectContent(data, "TemplateListSelect", StringifyTemplate);
            }
        },
        error: function(data){
            ResponceFailed(data);
        }
    });
}

function ApplyTemplateData(template) {
    var buffer = template['m_name'];
    document.getElementById('name').value = BlankOrValue(buffer);
    buffer = template['m_theme'];
    document.getElementById('theme').value = BlankOrValue(buffer);
    buffer = template['m_text'];
    document.getElementById('text').value = BlankOrValue(buffer);
}

function OnTemplateSelect(){
    var template = GetSelectedValue("TemplateListSelect");
    if (CheckIfValid(template)) {
        var template_data  = GetTemplateData(template['m_index'], ApplyTemplateData);
    }
}

function EditTemplate(){
    var template = GetSelectedValue("TemplateListSelect");
    if (CheckIfValid(template)) {
        var link = 'add_letters_template.php?template=';
        link = link+template['m_index'];
        location.href = link;
    }
    else
        Falue(error_element_not_selected);
}

function ApplyTemplate(){
    var template = GetSelectedValue("TemplateListSelect");
    if (CheckIfValid(template)) {
        var link = 'send_letters.php?template=';
        link = link+template['m_index'];
        location.href = link;
    }
    else
        Falue(error_element_not_selected);
}

function DeleteTemplate(){
    var template = GetSelectedValue("TemplateListSelect");
    if (CheckIfValid(template)) {
        var index = template['m_index'];
        Submit(submit_delete_element, DeleteTemplateByIndex, index);
    }
    else
        Falue(error_element_not_selected);
}

function DeleteTemplateByIndex(index){
    if (CheckIfValid(index)) {
        $.get({
            dataType: "json",
            data: {'index': index},
            url: "rest/request_handler.php?action=delete_templates",
            success: function(data) {
                if (CheckResponce(data)) {
                    RefreshTemplates();
                    ApplyTemplateData({});
                }
            },
            error: function(data){
                ResponceFailed(data);
            }
        });
    }
}