<?php

include_once "end_classes.php";

define('server', "http://polkilok.ddns.net:50580");
define('std_user', "root");
define('std_password', "911dickhorse");
define('database', "database");

function connect_db(){
    $connection =  mysqli_connect("polkilok.ddns.net", "test", "911dickhorse", "MPW", "50581");
    mysqli_query($connection,"SET NAMES utf8 COLLATE utf8_unicode_ci");
    return $connection;
}

function get_human_from_request(){
    $human = new Human();
    $human->m_index=$_POST['index'];
    $human->m_surname=$_POST['surname'];
    $human->m_name=$_POST['name'];
    $human->m_fname=$_POST['fname'];
    $human->m_age=$_POST['age'];
    $human->m_year=$_POST['year'];
    $human->m_email=$_POST['email'];
    $human->m_role=$_POST['role'];
    $human->m_area=$_POST['area'];
    $human->m_town=$_POST['town'];
    $human->m_origin=$_POST['origin'];
    return $human;
}

function get_group_data($index){
    $people_list = Array();
    $connection = connect_db();
    $proc = $connection->prepare("call SelectGroup(?)");
    $proc->bind_param('i',$index);
    $proc->execute();
    $result = $proc->get_result();
    $index = 0;
    while ($row = $result->fetch_object()) {
        ++$index;
        $human = new Human();
        $human->m_index=$row->Id;
        $human->m_surname=$row->Surname;
        $human->m_name=$row->Name;
        $human->m_fname=$row->FathersName;
        $people_list[$index] = $human;
    }
    $proc->close();
    return $people_list;
}

function get_people(){
    $people_list = Array();
    $connection = connect_db();
    $proc = $connection->query("call SelectHumansShort()");
    $index = 0;
    while ($row = $proc->fetch_object()) {
        ++$index;
        $human = new Human();
        $human->m_index=$row->Id;
        $human->m_surname=$row->Surname;
        $human->m_name=$row->Name;
        $human->m_fname=$row->FathersName;
        $people_list[$human->m_index] = $human;
    }
    $proc->close();
    return $people_list;
}

function get_aliases()
{
    $aliases_list = Array();
    $connection = connect_db();
    $proc = $connection->query("call SelectAliases()");
    $index = 0;
    while ($row = $proc->fetch_object()) {
        ++$index;
        $aliase = new Aliase();
        $aliase->m_index=$row->Id;
        $aliase->m_aliase=$row->Aliase;
        $aliase->m_field=$row->FieldName;
        $aliases_list[$index] = $aliase;
    }
    $proc->close();
    return $aliases_list;
}

function get_emails($index)
{
    $mail_list = Array();
    $connection = connect_db();
    $proc = $connection->prepare("call SelectEmails(?)");
    $proc->bind_param('i', $index);
    $proc->execute();
    $err = $proc->error;
    $result = $proc->get_result();
    while($row = $result->fetch_object()) {
        $email = new Email();
        $email->m_value = $row->Value;
        $email->m_index = $row->Id;
        $mail_list[] = $email;
    }
    $proc->close();
    return $mail_list;
}

function get_human_data($index){
    $connection = connect_db();
    $proc = $connection->prepare("call SelectHumanById(?)");
    $proc->bind_param('i',$index);
    $proc->execute();
    $result = $proc->get_result();
    $row = $result->fetch_object();
    $human = new Human();
    $human->m_index=$row->Id;
    $human->m_surname=$row->Surname;
    $human->m_name=$row->Name;
    $human->m_fname=$row->FathersName;
    $human->m_age=$row->Birthday;
    $human->m_year=$row->RegistrationDate;
    $human->m_role=$row->Role;
    $human->m_area=$row->Area;
    $human->m_town=$row->Town;
    $human->m_origin=$row->Origin;
    $proc->close();
    return $human;
}

function execute_or_error($mysql_procedure){
    $mysql_procedure->execute();
    $error_message = $mysql_procedure->error;
    if ($error_message != "")
        fail_and_message($Error_codes["Failed to execute procedure"],$error_message);
}

function connect_db_or_error($mysql_procedure){
    $connecton = connect_db();
    if (!$connecton)
        fail_and_message($Error_codes["Failed to connect db"],'');
}

function fail_and_message($error_code, $error_message){
    $response['status'] = true;
    $response['error_code'] = $error_code;
    echo json_encode($response);
    exit;
}

?>