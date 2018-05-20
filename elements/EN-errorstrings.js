var error_server_default = "Failed with unrecognized code";
var error_server_db_connection = "Failed to connect to database";
var error_server_proc_exec = "Failed to execute db procedure";
var error_server_zero_data = "Failed to fetch required data";
var error_server_invalid_responce = "Invalid server responce";
var error_server_invalid_request = "Invalid server request";
var error_server_not_enoth_previleges = "Request failed due to low user privileges level";
var error_server_login_fail = "Login failed";

var error_no_email_to_send = "No group or human or valid email specified to send a letter";
var error_element_not_selected = "Select an element first to perform this action";
var error_url_invalid_parameters = "An invalid parameter passed from URL string";

var error_rest_failed = "Rest server request failed";

function GetErrorMessageByServerErrorSode(code){
    switch (code){
        case 1:return error_server_db_connection;
        case 2:return error_server_proc_exec;
        case 3:return error_server_zero_data;
        case 4:return error_server_invalid_request;
        case 5:return error_server_not_enoth_previleges;
        case 6:return error_server_login_fail;
        default:error_server_default;
    }
}