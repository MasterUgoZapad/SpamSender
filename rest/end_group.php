<?php
include_once "end_classes.php";
include_once "end_common.php";

function get_groups(){
    $group_list = Array();
    $connection = connect_db();
    $proc = $connection->query("call SelectGroupList()");
    $index = 0;
    while ($row = $proc->fetch_object()) {
        ++$index;
        $group = new Group();
        $group->m_index = $row->Id;
        $group->m_name = $row->Name;
        $group_list[$index] = $group;
    }
    $proc->close();
    $response['size'] = count($group_list);
    $response = array_merge($response, $group_list);

    return json_encode($response);
}

function select_humans(){
    $selection = get_human_from_request();
    $year_from = $_POST['year_from'];
    $year_to = $_POST['year_to'];
    $age_from = $_POST['age_from'];
    $age_to = $_POST['age_to'];
    $human_group = Array();
    $connection = connect_db();
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
    $result = $proc->get_result();
    //$err = $proc->error;
    $index = 0;
    while ($row = $result->fetch_object()){
        ++$index;
        $human = new Human();
        $human->m_index=$row->Id;
        $human->m_name=$row->Name;
        $human_group[$index] = $human;
    }
    $proc->close();
    return $human_group;
}

function add_group(){
    $name = $_POST['group_name'];
    $human_group = select_humans();
    $connection = connect_db();
    $proc = $connection->prepare("call AddGroup(?)");
    $proc->bind_param('s', $name);
    $proc->execute();
    $err = $proc->error;
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
    return json_encode($response);
}

function get_group_by_selection(){
    $human_group = select_humans();
    $response['size'] = count($human_group);
    $response = array_merge($response, $human_group);
    return json_encode($response);
}

function delete_group()
{
    $index = $_GET['m_index'];
    $connection = connect_db();
    $proc = $connection->prepare("call DeleteGroup(?)");
    $proc->bind_param('i',$index);
    $proc->execute();
    $err = $proc->error;
    $proc->close();
    $response['status'] = true;
    return json_encode($response);
}

function get_group_data_and_encode(){
    $index = intval($_GET['index']);
    $people_list = get_group_data($index);
    $response['size'] = count($people_list);
    $response = array_merge($response, $people_list);

    return json_encode($response);
}

?>