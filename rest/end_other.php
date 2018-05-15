<?php
include_once "end_classes.php";
include_once "end_common.php";

function get_towns(&$response)
{
    $town_list = Array();
    if (!$connection = connect_db_or_error($response))
        return false;
    $proc = $connection->prepare("call SelectTowns()");
    $proc->execute();
    if (!check_if_execution_error($response, $proc))
        return false;
    $result = $proc->get_result();
    while ($row = $result->fetch_object()) {
        $town_list[$row->Id] = $row->Name;
    }
    $proc->close();
    $response['size'] = count($town_list);
    $response = array_merge($response, $town_list);

    success($response);
    return true;
}

function get_areas(&$response)
{
    $areas_list = Array();
    if (!$connection = connect_db_or_error($response))
        return false;
    $proc = $connection->prepare("call SelectAreas()");
    $proc->execute();
    if (!check_if_execution_error($response, $proc))
        return false;
    $result = $proc->get_result();
    while ($row = $result->fetch_object()) {
        $areas_list[$row->Id] = $row->Name;
    }
    $proc->close();
    $response['size'] = count($areas_list);
    $response = array_merge($response, $areas_list);

    success($response);
    return true;
}

function get_origins(&$response)
{
    $areas_list = Array();
    if (!$connection = connect_db_or_error($response))
        return false;
    $proc = $connection->prepare("call SelectOrigins()");
    $proc->execute();
    if (!check_if_execution_error($response, $proc))
        return false;
    $result = $proc->get_result();
    while ($row = $result->fetch_object()) {
        $areas_list[$row->Id] = $row->Name;
    }
    $proc->close();
    $response['size'] = count($areas_list);
    $response = array_merge($response, $areas_list);

    success($response);
    return true;
}

function get_roles(&$response)
{
    $areas_list = Array();
    if (!$connection = connect_db_or_error($response))
        return false;
    $proc = $connection->prepare("call SelectRoles()");
    $proc->execute();
    if (!check_if_execution_error($response, $proc))
        return false;
    $result = $proc->get_result();
    while ($row = $result->fetch_object()) {
        $areas_list[$row->Id] = $row->Name;
    }
    $proc->close();
    $response['size'] = count($areas_list);
    $response = array_merge($response, $areas_list);

    success($response);
    return true;
}

function get_aliases_encoded_string(&$response)
{
    $aliases_list = get_aliases($response);
    if (!$response['status'])
        return false;
    $response['size'] = count($aliases_list);
    $response = array_merge($response, $aliases_list);

    success($response);
    return true;
}

function send_letters(&$response)
{
    $man_index = $_POST['man'];
    $group_index = $_POST['group'];
    $raw_mail = $_POST['mail'];
    $theme = $_POST['theme'];
    $text = $_POST['text'];
    if ($raw_mail !== null) {
        mail($raw_mail, $theme, $text);
    } else {
        $aliases = get_aliases($response);
        if (!$response['status'])
            return false;
        if ($man_index !== null) {
            if (!$human_full = get_human_data($response, $man_index))
                return false;
            $prepared_text = prepare_text($text, $aliases, $human_full);
            if (send_mails_to_human($response, $man_index, $theme, $prepared_text))
                return false;
        } else if ($group_index !== null) {
            if (!$group = get_group_data($response, $group_index))
                return false;
            foreach ($group as &$human) {
                $index = $human->m_index;
                if (!$human_full = get_human_data($response, $index))
                    return false;
                $prepared_text = prepare_text($text, $aliases, $human_full);
                if (!send_mails_to_human($response, $index, $theme, $prepared_text))
                    return false;
            }
        }
    }
    success($response);
    return true;
}

function send_mails_to_human(&$response, $index, $theme, $prepared_text){
    $mails = get_emails($response, $index);
    if (!$response['status'])
        return false;
    foreach ($mails as &$mail) {
        $address = $mail->m_value;
        mail($address, $theme, $prepared_text);
    }
    return true;
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