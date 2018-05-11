// global data
var current_template_index = undefined;

window.onload = function() {
    GetTemplateFromRequest();
    RefreshAliases();
};

function GetTemplateFromRequest(){
    var params = GetURLParamsArray();
    if (CheckIfValid(params)){
        var template_string = params['template'];
        var template_index = decodeURI(template_string);
        GetTemplateData(template_index, ApplyTemplateData);
    }
}

function ApplyTemplateData(template){
    current_template_index = template['m_index'];
    var buffer = template['m_name'];
    document.getElementById('name').value = BlankOrValue(buffer);
    buffer = template['m_theme'];
    document.getElementById('theme').value = BlankOrValue(buffer);
    buffer = template['m_text'];
    document.getElementById('text').value = BlankOrValue(buffer);
}

function RefreshAliases(){
    $.get({
        dataType: "json",
        url: "rest/request_handler.php?action=get_aliases",
        //data: data,
        success: function(data) {
            ApplyGroupData(data, data['size'], "aliasesText", StringifyAlias);
        }
    });
}

function CollectTemplateDataToObject() {
    var template = {};
    template['name'] = document.getElementById('name').value;
    template['theme']= document.getElementById('theme').value;
    template['text']= document.getElementById('text').value;
    return template;
}

function SubmitData(){
    var template = CollectTemplateDataToObject();
    if (CheckIfValid(current_template_index)) {
        template['index']=current_template_index;
        EditTemplate(template);
    }
    else
        AddTemplate(template);
}

function EditTemplate(template){
    $.post({
        url: 'end_templates.php?action=edit_template',
        dataType: "json",
        data: template,
        success: function(responce) {
            ApplyTemplateData({});
            location.href = "see_letters_template.php"
        },
        error: function(responce) {
            Falue(responce);
        }
    });
}

function AddTemplate(template){
    $.post({
        url: 'rest/request_handler.php?action=add_template',
        dataType: "json",
        data: template,
        success: function(template) {
            ApplyTemplateData({});
            location.href = "add_letters_template.php"
        },
        error: function(responce) {
            Falue(responce);
        }
    });
}