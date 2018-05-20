<?php

include_once "end_email.php";
include_once "end_group.php";
include_once "end_other.php";
include_once "end_people.php";
include_once "end_templates.php";

$action = $_REQUEST["action"];
$response = array();

session_start();

function handle_request_level_0(&$response, $action)
{
    switch ($action) {
        case 'login':
            login($response);
            return true;
        case 'logout':
            logout($response);
            return true;
        default:
            return false;
    }
}

function handle_request_level_1(&$response, $action)
{
    if (!check_user_level(1)){
        global $Error_codes;
        fail_and_message($response, $Error_codes["Unautorized request"], '');
        return false;
    }
    switch ($action) {
        case 'get_emails':
            get_emails_encoded_string($response);
            return true;
        case 'add_email':
            add_email($response);
            return true;
        case 'delete_email':
            delete_email($response);
            return true;
        case 'get_groups':
            get_groups($response);
            return true;
        case 'get_group_data':
            get_group_data_and_encode($response);
            return true;
        case 'get_group_by_selection':
            get_group_by_selection($response);
            return true;
        case 'add_group':
            add_group($response);
            return true;
        case 'get_group_name':
            get_group_name($response);
            return true;
        case 'delete_group':
            delete_group($response);
            return true;
        case "get_aliases":
            get_aliases_encoded_string($response);
            return true;
        case "get_roles":
            get_roles($response);
            return true;
        case "get_areas":
            get_areas($response);
            return true;
        case "get_towns":
            get_towns($response);
            return true;
        case "get_origins":
            get_origins($response);
            return true;
        case "send_letters":
            send_letters($response);
            return true;
        case 'get_people':
            get_people_encoded_string($response);
            return true;
        case 'add_human':
            add_human($response);
            return true;
        case 'delete_people':
            delete_people($response);
            return true;
        case 'edit_human':
            edit_human($response);
            return true;
        case 'get_human_data':
            get_human_data_encoded_string($response);
            return true;
        case 'get_templates':
            get_templates($response);
            return true;
        case 'get_template_data':
            get_template($response);
            return true;
        case 'add_template':
            add_template($response);
            return true;
        case 'delete_templates':
            delete_template($response);
            return true;
        case 'edit_template':
            edit_template($response);
            return true;
        default:
            return false;
    }
}

function handle_request_level_2(&$response, $action)
{
    if (!check_user_level(2)) {
        global $Error_codes;
        fail_and_message($response, $Error_codes["Unautorized request"], '');
        return false;
    }
    switch ($action) {
        case 'get_users':
            get_users($response);
            return true;
        case 'add_user':
            add_user($response);
            return true;
        case 'delete_user':
            delete_user($response);
            return true;
        case 'mass_import':
            mass_import($response);
            return true;
        default:
            return false;
    }
}

success($response);
if (!handle_request_level_0($response,$action) && !check_if_failed($response))
    if (!handle_request_level_1($response,$action)&& !check_if_failed($response))
        if (!handle_request_level_2($response,$action) && !check_if_failed($response)) {
            global $Error_codes;
            fail_and_message($response, $Error_codes["Wrong request"], '');
        }

echo json_encode($response);;
?>