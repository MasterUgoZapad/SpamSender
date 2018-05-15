<?php
include_once "end_classes.php";
include_once "end_common.php";

function get_emails_encoded_string(&$response){
    $index = $_GET['index'];
    $mail_list = get_emails($response, $index);
    $response['size'] = count($mail_list);
    $response = array_merge($response, $mail_list);

    return json_encode($response);
}

function add_email(&$response)
{
    $index = $_POST['index'];
    $email = $_POST['mail'];
    if (!$connection = connect_db_or_error($response))
        return false;
    $proc = $connection->prepare("call AddEmail(?, ?)");
    $proc->bind_param('si', $email, $index);
    $proc->execute();
    if (!check_if_execution_error($response, $proc))
        return false;
    $proc->close();
    success($response);
    return true;
}

function delete_email(&$response)
{
    $index = $_GET['mail'];
    if (!$connection = connect_db_or_error($response))
        return false;
    $proc = $connection->prepare("call DeleteEmail(?)");
    $proc->bind_param('i', $index);
    $proc->execute();
    if (!check_if_execution_error($response, $proc))
        return false;
    $proc->close();
    success($response);
    return true;
}

?>