window.onload = function() {
    RefreshRoles();
    RefreshTowns();
    RefreshAreas();
    RefreshOrigins();
};

function CollectDefaultsDataToObject() {
    var select = {};
    select['name'] = document.getElementById('name').value;
    select['surname'] = document.getElementById('sname').value;
    select['fname'] = document.getElementById('fname').value;
    select['birthdate'] = document.getElementById('birthdate').value;
    select['area']= document.getElementById('area').value;
    select['town']= document.getElementById('town').value;
    select['role']= document.getElementById('role').value;
    select['origin']= document.getElementById('origin').value;
    return select;
}

function Import(){
    if (Progress("loading file data", true)) {
        var defaults = CollectDefaultsDataToObject();
        var file = document.getElementById('file').files[0];
        var encoding = document.getElementById('encoding').value;
        if (CheckIfValid(file) && CheckIfValid(encoding)) {
            var reader = new FileReader();
            reader.onloadend = function (e) {
                ParseData(this.result, defaults);
            };
            reader.readAsText(file, encoding);
        }
        else
            Falue("File loading failed");
    }
}

function ParseData(text, defaults){
    if (Progress("parsing file data")) {
        var options = {"separator": ";"};
        var data = $.csv.toObjects(text, options);
        ImportParcedFile(data, defaults);
    }
}

function ImportParcedFile(csv, defaults){
    if (Progress("sending data to server")) {
        $.post({
            url: 'rest/request_handler.php?action=mass_import',
            dataType: "json",
            data: {'defaults': defaults, 'data': csv},
            success: function (data) {
                HideProgress();
                if (CheckResponce(data)) {
                    location.href = "see_people.php";
                }
            },
            error: function (data) {
                ResponceFailed(data);
            }
        });
    }
}

function Export(){
    $.get({
        url: 'rest/request_handler.php?action=mass_export',
        dataType: "json",
        success: function(data) {
            if (CheckResponce(data)) {
                HideProgress();
            }
        },
        error: function(data){
            ResponceFailed(data);
        }
    });
}