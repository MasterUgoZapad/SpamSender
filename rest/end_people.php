<?php
include_once "end_classes.php";
include_once "end_common.php";

function get_people_encoded_string(&$response){
    $people_list = get_people($response);
    if (!$response['status'])
        return false;
    $response['size'] = count($people_list);
    $response = array_merge($response, $people_list);
    return true;
}

function add_human(&$response){
    $human = get_human_from_request();
    if (!$connection = connect_db_or_error($response))
        return false;
    $proc = $connection->prepare("call AddHuman(?, ?, ?, ?, ?, ?, ?, ?)");
    $proc->bind_param('ssssssss',$human->m_surname,
        $human->m_name,
        $human->m_fname,
        $human->m_area,
        $human->m_town,
        $human->m_origin,
        $human->m_role,
        $human->m_age);
    $proc->execute();
    if (!check_if_execution_error($response, $proc))
        return false;
    $proc->close();
    success($response);
    return true;
}

function edit_human(&$response){
    $human = get_human_from_request();
    if (!$connection = connect_db_or_error($response))
        return false;
    $proc = $connection->prepare("call UpdateHuman(?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $proc->bind_param('ssssssssi',
        $human->m_surname,
        $human->m_name,
        $human->m_fname,
        $human->m_area,
        $human->m_town,
        $human->m_origin,
        $human->m_role,
        $human->m_age,
        $human->m_index);
    $proc->execute();
    if (!check_if_execution_error($response, $proc))
        return false;
    $proc->close();
    success($response);
    return true;
}

function delete_people(&$response)
{
    $index = $_GET['index'];
    if (!$connection = connect_db_or_error($response))
        return false;
    $proc = $connection->prepare("call DeleteHuman(?)");
    $proc->bind_param('i',$index);
    $proc->execute();
    if (!check_if_execution_error($response, $proc))
        return false;
    $proc->close();
    success($response);
    return true;
}

function get_human_data_encoded_string(&$response){
    $index = intval($_GET['index']);
    if (!$human = get_human_data($response, $index))
        return false;
    return true;
}
?>