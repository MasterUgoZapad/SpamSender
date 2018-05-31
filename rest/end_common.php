<?php

include_once "end_classes.php";

function get_human_from_request()
{
    $human = new Human();
    $human->m_index = $_POST['index'];
    $human->m_surname = $_POST['surname'];
    $human->m_name = $_POST['name'];
    $human->m_fname = $_POST['fname'];
    $human->m_age = $_POST['age'];
    $human->m_year = $_POST['year'];
    $human->m_email = $_POST['email'];
    $human->m_role = $_POST['role'];
    $human->m_area = $_POST['area'];
    $human->m_town = $_POST['town'];
    $human->m_origin = $_POST['origin'];
    return $human;
}

function get_group_data(&$response, $index)
{
    $people_list = Array();
    if (!$connection = connect_db_or_error($response))
        return false;
    $proc = $connection->prepare("call SelectGroup(?)");
    $proc->bind_param('i', $index);
    $proc->execute();
    if (!check_if_execution_error($response, $proc))
        return false;
    $result = $proc->get_result();
    $index = 0;
    while ($row = $result->fetch_object()) {
        ++$index;
        $human = new Human();
        $human->m_index = $row->Id;
        $human->m_surname = $row->Surname;
        $human->m_name = $row->Name;
        $human->m_fname = $row->FathersName;
        $people_list[$index] = $human;
    }
    $proc->close();
    success($response);
    return $people_list;
}

function get_people(&$response)
{
    $people_list = Array();
    if (!$connection = connect_db_or_error($response))
        return false;
    $proc = $connection->prepare("call SelectHumansShort()");
    $proc->execute();
    if (!check_if_execution_error($response, $proc))
        return false;
    $result = $proc->get_result();
    $index = 0;
    while ($row = $result->fetch_object()) {
        ++$index;
        $human = new Human();
        $human->m_index = $row->Id;
        $human->m_surname = $row->Surname;
        $human->m_name = $row->Name;
        $human->m_fname = $row->FathersName;
        $people_list[$human->m_index] = $human;
    }
    $proc->close();
    success($response);
    return $people_list;
}

function get_aliases(&$response)
{
    $aliases_list = Array();
    if (!$connection = connect_db_or_error($response))
        return false;
    $proc = $connection->prepare("call SelectAliases()");
    $proc->execute();
    if (!check_if_execution_error($response, $proc))
        return false;
    $result = $proc->get_result();
    $index = 0;
    while ($row = $result->fetch_object()) {
        ++$index;
        $aliase = new Aliase();
        $aliase->m_index = $row->Id;
        $aliase->m_aliase = $row->Aliase;
        $aliase->m_field = $row->FieldName;
        $aliases_list[$index] = $aliase;
    }
    $proc->close();
    success($response);
    return $aliases_list;
}

function get_emails(&$response, $index)
{
    $mail_list = Array();
    if (!$connection = connect_db_or_error($response))
        return false;
    $proc = $connection->prepare("call SelectEmails(?)");
    $proc->bind_param('i', $index);
    $proc->execute();
    if (!check_if_execution_error($response, $proc))
        return false;
    $result = $proc->get_result();
    while ($row = $result->fetch_object()) {
        $email = new Email();
        $email->m_value = $row->Value;
        $email->m_index = $row->Id;
        $mail_list[] = $email;
    }
    $proc->close();
    success($response);
    return $mail_list;
}

function get_human_data(&$response, $index)
{
    if (!$connection = connect_db_or_error($response))
        return false;
    $proc = $connection->prepare("call SelectHumanById(?)");
    $proc->bind_param('i', $index);
    $proc->execute();
    if (!check_if_execution_error($response, $proc))
        return false;
    $result = $proc->get_result();
    if (!$result) {
        global $Error_codes;
        fail_and_message($response, $Error_codes["Zero results"], '');
        return false;
    }
    $row = $result->fetch_object();
    $human = new Human();
    $human->m_index = $row->Id;
    $human->m_surname = $row->Surname;
    $human->m_name = $row->Name;
    $human->m_fname = $row->FathersName;
    $human->m_age = $row->Birthday;
    $human->m_year = $row->RegistrationDate;
    $human->m_role = $row->Role;
    $human->m_area = $row->Area;
    $human->m_town = $row->Town;
    $human->m_origin = $row->Origin;
    $proc->close();

    $response['human'] = $human;
    success($response);
    return $human;
}

function check_if_execution_error(&$response, $proc)
{
    global $Error_codes;
    $error = $proc->error;
    if ($error != "") {
        fail_and_message($response, $Error_codes["Failed to execute procedure"], $error);
        return false;
    }
    return true;
}

function connect_db_or_error(&$response)
{
    $server_settings = parse_ini_file("server.ini");
    global $Error_codes;
    $connection = mysqli_connect(
        $server_settings['server'],
        $server_settings['user'],
        $server_settings['password'],
        $server_settings['database'],
        $server_settings['port']);
    if ($connection) {
        mysqli_query($connection, "SET NAMES utf8 COLLATE utf8_unicode_ci");
        return $connection;
    }
    fail_and_message($response, $Error_codes["Failed to connect db"], mysqli_connect_error());
}

function fail_and_message(&$response, $error_code, $error_message)
{
    $response['status'] = false;
    $response['error_code'] = $error_code;
    $response['error_message'] = $error_message;
}

function success(&$response)
{
    $response['status'] = true;
}

?>