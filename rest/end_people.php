<?php
include_once "end_classes.php";
include_once "end_common.php";

function get_people_encoded_string(){
    $people_list = get_people();
    $response['size'] = count($people_list);
    $response = array_merge($response, $people_list);

    return json_encode($response);
}

function add_human(){
    $human = get_human_from_request();
    $connection = connect_db();
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
    //$err = $proc->error;
    $proc->close();
    $response['status'] = true;
    return json_encode($response);
}

function edit_human(){
    $human = get_human_from_request();
    $connection = connect_db();
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
    $err = $proc->error;
    $proc->close();
    $response['status'] = true;
    return json_encode($response);
}

function delete_people()
{
    $index = $_GET['index'];
    $connection = connect_db();
    $proc = $connection->prepare("call DeleteHuman(?)");
    $proc->bind_param('i',$index);
    $proc->execute();
    $err = $proc->error;
    $proc->close();
    $response['status'] = true;
    return json_encode($response);
}

function get_human_data_encoded_string(){
    $index = intval($_GET['index']);
    $human = get_human_data($index);

    return json_encode($human);
}
?>