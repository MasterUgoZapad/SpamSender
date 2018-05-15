<?php
include_once "end_classes.php";
include_once "end_common.php";

function get_groups(&$response){
    $group_list = Array();
    if (!$connection = connect_db_or_error($response))
        return false;
    $proc = $connection->prepare("call SelectGroupList()");
    $proc->execute();
    if (!check_if_execution_error($response, $proc))
        return false;
    $result = $proc->get_result();
    $index = 0;
    while ($row = $result->fetch_object()) {
        ++$index;
        $group = new Group();
        $group->m_index = $row->Id;
        $group->m_name = $row->Name;
        $group_list[$index] = $group;
    }
    $proc->close();
    $response['size'] = count($group_list);
    $response = array_merge($response, $group_list);

    success($response);
    return true;
}

function select_humans(&$response){
    $selection = get_human_from_request();
    $year_from = $_POST['year_from'];
    $year_to = $_POST['year_to'];
    $age_from = $_POST['age_from'];
    $age_to = $_POST['age_to'];
    $human_group = Array();
    if (!$connection = connect_db_or_error($response))
        return false;
    $proc = $connection->prepare("call SearchHuman(?,?,?,?,?,?,?,?,?,?,?)");
    $proc->bind_param('sssssssssss',
        $selection->m_surname,
        $selection->m_name,
        $selection->m_fname,
        $selection->m_town,
        $selection->m_area,
        $selection->m_role,
        $selection->m_origin,
        $year_from,
        $year_to,
        $age_from,
        $age_to);
    $proc->execute();
    if (!check_if_execution_error($response, $proc))
        return false;
    $result = $proc->get_result();
    $index = 0;
    while ($row = $result->fetch_object()){
        ++$index;
        $human = new Human();
        $human->m_index=$row->Id;
        $human->m_name=$row->Name;
        $human->m_surname=$row->Surname;
        $human->m_fname=$row->FathersName;
        $human_group[$index] = $human;
    }
    $proc->close();
    success($response);
    return $human_group;
}

function add_group(&$response){
    $name = $_POST['group_name'];
    $human_group = select_humans($response);
    if (!$response['status'])
        return false;
    if (!$connection = connect_db_or_error($response))
        return false;
    $proc = $connection->prepare("call AddGroup(?)");
    $proc->bind_param('s', $name);
    $proc->execute();
    if (!check_if_execution_error($response, $proc))
        return false;
    $result = $proc->get_result();
    $new_group_index = $result->fetch_assoc();
    $new_group_index = $new_group_index['LAST_INSERT_ID()'];
    $proc->close();

    $index = 1;
    while($index <= count($human_group)){
        $proc = $connection->prepare("call AddHumanToGroup(?,?)");
        $human_index = $human_group[$index]->m_index;
        $proc->bind_param('ii', $human_index, $new_group_index);
        $proc->execute();
        $err = $proc->error;
        ++$index;
    }
    $proc->close();
    $response['status'] = true;
    success($response);
    return true;
}

function get_group_by_selection(&$response){
    $human_group = select_humans($response);
    $response['size'] = count($human_group);
    $response = array_merge($response, $human_group);
    success($response);
    return true;
}

function delete_group(&$response)
{
    $index = $_GET['m_index'];
    if (!$connection = connect_db_or_error($response))
        return false;
    $proc = $connection->prepare("call DeleteGroup(?)");
    $proc->bind_param('i',$index);
    $proc->execute();
    if (!check_if_execution_error($response, $proc))
        return false;
    $proc->close();
    success($response);
    return true;
}

function get_group_data_and_encode(&$response){
    $index = intval($_GET['index']);
    $people_list = get_group_data($response, $index);
    $response['size'] = count($people_list);
    $response = array_merge($response, $people_list);

    success($response);
    return true;
}

function get_group_name(&$response){
    $group = new Group();
    $index = $_GET['index'];
    if (!$connection = connect_db_or_error($response))
        return false;
    $proc = $connection->prepare("call SelectGroupName(?)");
    $proc->bind_param('i',$index);
    $proc->execute();
    if (!check_if_execution_error($response, $proc))
        return false;
    $result = $proc->get_result();
    $row = $result->fetch_object();
    $group->m_index = $index;
    $group->m_name = $row->Name;
    $proc->close();
    success($response);
    $response = array_merge($response,$group);
    return true;
}

?>