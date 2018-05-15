<?php
include_once "end_classes.php";
include_once "end_common.php";

function get_template_from_request(){
    $template = new Template();
    $template->m_index=$_POST['index'];
    $template->m_name=$_POST['name'];
    $template->m_theme=$_POST['theme'];
    $template->m_text=$_POST['text'];
    return $template;
}

function get_templates(&$response){
    $template_list = Array();
    if (!$connection = connect_db_or_error($response))
        return false;
    $proc = $connection->prepare("call SelectTemplateList()");
    $proc->execute();
    if (!check_if_execution_error($response, $proc))
        return false;
    $result = $proc->get_result();
    $index = 0;
    while ($row = $result->fetch_object()) {
        ++$index;
        $template = new Template();
        $template->m_index=$row->Id;
        $template->m_name=$row->Name;
        $template_list[$index] = $template;
    }
    $proc->close();
    $response['size'] = count($template_list);
    $response = array_merge($response, $template_list);

    success($response);
    return true;
}

function get_template(&$response){
    $index = intval($_GET['index']);
    if (!$connection = connect_db_or_error($response))
        return false;
    $proc = $connection->prepare("call SelectTemplate(?)");
    $proc->bind_param('i',$index);
    $proc->execute();
    if (!check_if_execution_error($response, $proc))
        return false;
    $result = $proc->get_result();
    if (!$result){
        global $Error_codes;
        fail_and_message($response, $Error_codes["Zero results"], '');
        return false;
    }
    $row = $result->fetch_object();
    $template = new Template();
    $template->m_index=$row->Id;
    $template->m_name=$row->Name;
    $template->m_theme=$row->Title;
    $template->m_text=$row->Text;
    $response['template'] = $template;
    success($response);
    return true;
}

function add_template(&$response){
    $template = get_template_from_request();
    if (!$connection = connect_db_or_error($response))
        return false;
    $proc = $connection->prepare("call AddTemplate(?, ?, ?)");
    $proc->bind_param('sss',$template->m_name,
        $template->m_theme,
        $template->m_text);
    $proc->execute();
    if (!check_if_execution_error($response, $proc))
        return false;
    $proc->close();
    $response['status'] = true;
    success($response);
    return true;
}

function edit_template(&$response){
    $template = get_template_from_request();
    if (!$connection = connect_db_or_error($response))
        return false;
    $proc = $connection->prepare("call UpdateTemplate(?, ?, ?, ?)");
    $proc->bind_param('isss',
        $template->m_index,
        $template->m_name,
        $template->m_theme,
        $template->m_text);
    $proc->execute();
    if (!check_if_execution_error($response, $proc))
        return false;
    $proc->close();
    $response['status'] = true;
    success($response);
    return true;
}

function delete_template(&$response)
{
    $index = $_GET['index'];
    if (!$connection = connect_db_or_error($response))
        return false;
    $proc = $connection->prepare("call DeleteTemplate(?)");
    $proc->bind_param('i',$index);
    $proc->execute();
    if (!check_if_execution_error($response, $proc))
        return false;
    $proc->close();
    $response['status'] = true;
    success($response);
    return true;
}

?>