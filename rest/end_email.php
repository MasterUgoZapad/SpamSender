<?php
include_once "end_classes.php";
include_once "end_common.php";

function get_emails_encoded_string(){
    $index = $_GET['index'];
    $mail_list = get_emails($index);
    $response['size'] = count($mail_list);
    $response = array_merge($response, $mail_list);

    return json_encode($response);
}

function add_email()
{
    $index = $_POST['index'];
    $email = $_POST['mail'];
    $connection = connect_db();
    $proc = $connection->prepare("call AddEmail(?, ?)");
    $proc->bind_param('si', $email, $index);
    $proc->execute();
    $proc->close();
    $response['status'] = true;
    return json_encode($response);
}

function delete_email()
{
    $index = $_GET['mail'];
    $connection = connect_db();
    $proc = $connection->prepare("call DeleteEmail(?)");
    $proc->bind_param('i', $index);
    $proc->execute();
    $err = $proc->error;
    $proc->close();
    $response['status'] = true;
    return json_encode($response);
}

?>