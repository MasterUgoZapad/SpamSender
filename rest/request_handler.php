<?php

include_once "end_email.php";
include_once "end_group.php";
include_once "end_other.php";
include_once "end_people.php";
include_once "end_templates.php";

$action = $_REQUEST["action"];
$response = array();
switch ($action) {
    case 'get_emails':
        get_emails_encoded_string($response);
        break;
    case 'add_email':
        add_email($response);
        break;
    case 'delete_email':
        delete_email($response);
        break;
    case 'get_groups':
        get_groups($response);
        break;
    case 'get_group_data':
        get_group_data_and_encode($response);
        break;
    case 'get_group_by_selection':
        get_group_by_selection($response);
        break;
    case 'add_group':
        add_group($response);
        break;
    case 'get_group_name':
        get_group_name($response);
        break;
    case 'delete_group':
        delete_group($response);
        break;
    case "get_aliases":
        get_aliases_encoded_string($response);
        break;
    case "get_roles":
        get_roles($response);
        break;
    case "get_areas":
        get_areas($response);
        break;
    case "get_towns":
        get_towns($response);
        break;
    case "get_origins":
        get_origins($response);
        break;
    case "send_letters":
        send_letters($response);
        break;
    case 'get_people':
        get_people_encoded_string($response);
        break;
    case 'add_human':
        add_human($response);
        break;
    case 'delete_people':
        delete_people($response);
        break;
    case 'edit_human':
        edit_human($response);
        break;
    case 'get_human_data':
        get_human_data_encoded_string($response);
        break;
    case 'get_templates':
        get_templates($response);
        break;
    case 'get_template_data':
        get_template($response);
        break;
    case 'add_template':
        add_template($response);
        break;
    case 'delete_templates':
        delete_template($response);
        break;
    case 'edit_template':
        edit_template($response);
        break;
    default:
        global $Error_codes;
        fail_and_message($response, $Error_codes["Wrong request"],'');
        break;
}

echo json_encode($response);;
?>