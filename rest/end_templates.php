<?php
include_once "end_classes.php";
include_once "end_common.php";

function get_templates(){
    $template_list = Array();
    $connection = connect_db();
    $proc = $connection->query("call SelectTemplateList()");
    $index = 0;
    while ($row = $proc->fetch_object()) {
        ++$index;
        $template = new Template();
        $template->m_index=$row->Id;
        $template->m_name=$row->Name;
        $template_list[$index] = $template;
    }
    $proc->close();
    $response['size'] = count($template_list);
    $response = array_merge($response, $template_list);

    return json_encode($response);
}

function get_template(){
    $index = intval($_GET['index']);
    $connection = connect_db();
    $proc = $connection->prepare("call SelectTemplate(?)");
    $proc->bind_param('i',$index);
    $proc->execute();
    $result = $proc->get_result();
    $row = $result->fetch_object();
    $template = new Template();
    $template->m_index=$row->Id;
    $template->m_name=$row->Name;
    $template->m_theme=$row->Title;
    $template->m_text=$row->Text;
    return json_encode($template);
}

function add_template(){
    $template = get_template_from_request();
    $connection = connect_db();
    $proc = $connection->prepare("call AddTemplate(?, ?, ?)");
    $proc->bind_param('sss',$template->m_name,
        $template->m_theme,
        $template->m_text);
    $proc->execute();
    $err = $proc->error;
    $proc->close();
    $response['status'] = true;
    return json_encode($response);
}

function edit_template(){
    $template = get_template_from_request();
    $connection = connect_db();
    $proc = $connection->prepare("call UpdateTemplate(?, ?, ?, ?)");
    $proc->bind_param('isss',
        $template->m_index,
        $template->m_name,
        $template->m_theme,
        $template->m_text);
    $proc->execute();
    $err = $proc->error;
    $proc->close();
    $response['status'] = true;
    return json_encode($response);
}

function get_template_from_request(){
    $template = new Template();
    $template->m_index=$_POST['index'];
    $template->m_name=$_POST['name'];
    $template->m_theme=$_POST['theme'];
    $template->m_text=$_POST['text'];
    return $template;
}

function delete_template()
{
    $index = $_GET['index'];
    $connection = connect_db();
    $proc = $connection->prepare("call DeleteTemplate(?)");
    $proc->bind_param('i',$index);
    $proc->execute();
    $err = $proc->error;
    $proc->close();
    $response['status'] = true;
    return json_encode($response);
}

?>