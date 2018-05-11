<?php

include_once "end_email.php";
include_once "end_group.php";
include_once "end_other.php";
include_once "end_people.php";
include_once "end_templates.php";

$action = $_REQUEST["action"];
$response_string = "";
switch ($action) {
    case 'get_emails':
        $response_string = get_emails_encoded_string();
        break;
    case 'add_email':
        $response_string = add_email();
        break;
    case 'delete_email':
        $response_string = delete_email();
        break;
    case 'get_groups':
        $response_string = get_groups();
        break;
    case 'get_group_data':
        $response_string = get_group_data_and_encode();
        break;
    case 'get_group_by_selection':
        $response_string = get_group_by_selection();
        break;
    case 'add_group':
        $response_string = add_group();
        break;
    case 'delete_group':
        $response_string = delete_group();
        break;
    case "get_aliases":
        $response_string = get_aliases_encoded_string();
        break;
    case "get_roles":
        $response_string = get_roles();
        break;
    case "get_areas":
        $response_string = get_areas();
        break;
    case "get_towns":
        $response_string = get_towns();
        break;
    case "get_origins":
        $response_string = get_origins();
        break;
    case "send_letters":
        $response_string = send_letters();
        break;
    case 'get_people':
        $response_string = get_people_encoded_string();
        break;
    case 'add_human':
        $response_string = add_human();
        break;
    case 'delete_people':
        $response_string = delete_people();
        break;
    case 'edit_human':
        $response_string = edit_human();
        break;
    case 'get_human_data':
        $response_string = get_human_data_encoded_string();
        break;
    case 'get_templates':
        $response_string = get_templates();
        break;
    case 'get_template_data':
        $response_string = get_template();
        break;
    case 'add_template':
        $response_string = add_template();
        break;
    case 'delete_templates':
        $response_string = delete_template();
        break;
    case 'edit_template':
        $response_string = edit_template();
        break;
}

echo $response_string;
?>