<?php
include_once "end_classes.php";
include_once "end_common.php";

function get_towns()
{
    $town_list = Array();
    $connection = connect_db();
    $proc = $connection->query("call SelectTowns()");
    while ($row = $proc->fetch_object()) {
        $town_list[$row->Id] = $row->Name;
    }
    $proc->close();
    $response['size'] = count($town_list);
    $response = array_merge($response, $town_list);

    return json_encode($response);
}

function get_areas()
{
    $areas_list = Array();
    $connection = connect_db();
    $proc = $connection->query("call SelectAreas()");
    while ($row = $proc->fetch_object()) {
        $areas_list[$row->Id] = $row->Name;
    }
    $proc->close();
    $response['size'] = count($areas_list);
    $response = array_merge($response, $areas_list);

    return json_encode($response);
}

function get_origins()
{
    $areas_list = Array();
    $connection = connect_db();
    $proc = $connection->query("call SelectOrigins()");
    while ($row = $proc->fetch_object()) {
        $areas_list[$row->Id] = $row->Name;
    }
    $proc->close();
    $response['size'] = count($areas_list);
    $response = array_merge($response, $areas_list);

    return json_encode($response);
}

function get_roles()
{
    $areas_list = Array();
    $connection = connect_db();
    $proc = $connection->query("call SelectRoles()");
    while ($row = $proc->fetch_object()) {
        $areas_list[$row->Id] = $row->Name;
    }
    $proc->close();
    $response['size'] = count($areas_list);
    $response = array_merge($response, $areas_list);

    return json_encode($response);
}

function get_aliases_encoded_string()
{
    $aliases_list = get_aliases();
    $response['size'] = count($aliases_list);
    $response = array_merge($response, $aliases_list);

    return json_encode($response);
}

function send_letters()
{
    $man_index = $_POST['man'];
    $group_index = $_POST['group'];
    $raw_mail = $_POST['mail'];
    $theme = $_POST['theme'];
    $text = $_POST['text'];
    if ($raw_mail !== null) {
        mail($raw_mail, $theme, $text);
    } else {
        $aliases = get_aliases();
        if ($man_index !== null) {
            $human_full = get_human_data($man_index);
            $prepared_text = prepare_text($text, $aliases, $human_full);
            send_mails_to_human($man_index, $theme, $prepared_text);
        } else if ($group_index !== null) {
            $group = get_group_data($group_index);
            foreach ($group as &$human) {
                $index = $human->m_index;
                $human_full = get_human_data($index);
                $prepared_text = prepare_text($text, $aliases, $human_full);
                send_mails_to_human($index, $theme, $prepared_text);
            }
        }
    }

    $response['status'] = true;
    return json_encode($response);
}

function send_mails_to_human($index, $theme, $prepared_text){
    $mails = get_emails($index);
    foreach ($mails as &$mail) {
        $address = $mail->m_value;
        mail($address, $theme, $prepared_text);
    }
}

function prepare_text($text, $aliases, $human)
{
    $search = Array();
    $replace = Array();
    foreach ($aliases as &$aliase) {
        $value = get_value_for_aliase($aliase->m_field, $human);
        $search[] = $aliase->m_aliase;
        $replace[] = $value;
    }
    return str_replace($search, $replace, $text);
}

function get_value_for_aliase($field_name, $human)
{
    switch ($field_name) {
        case "Name":
            return $human->m_name;
        case "Surname":
            return $human->m_surname;
    }
}

?>