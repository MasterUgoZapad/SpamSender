<?php
include_once "end_classes.php";
include_once "end_common.php";

function get_towns(&$response)
{
    $town_list = Array();
    if (!$connection = connect_db_or_error($response))
        return false;
    $proc = $connection->prepare("call SelectTowns()");
    $proc->execute();
    if (!check_if_execution_error($response, $proc))
        return false;
    $result = $proc->get_result();
    while ($row = $result->fetch_object()) {
        $town_list[$row->Id] = $row->Name;
    }
    $proc->close();
    $response['size'] = count($town_list);
    $response = array_merge($response, $town_list);

    success($response);
    return true;
}

function get_areas(&$response)
{
    $areas_list = Array();
    if (!$connection = connect_db_or_error($response))
        return false;
    $proc = $connection->prepare("call SelectAreas()");
    $proc->execute();
    if (!check_if_execution_error($response, $proc))
        return false;
    $result = $proc->get_result();
    while ($row = $result->fetch_object()) {
        $areas_list[$row->Id] = $row->Name;
    }
    $proc->close();
    $response['size'] = count($areas_list);
    $response = array_merge($response, $areas_list);

    success($response);
    return true;
}

function get_origins(&$response)
{
    $areas_list = Array();
    if (!$connection = connect_db_or_error($response))
        return false;
    $proc = $connection->prepare("call SelectOrigins()");
    $proc->execute();
    if (!check_if_execution_error($response, $proc))
        return false;
    $result = $proc->get_result();
    while ($row = $result->fetch_object()) {
        $areas_list[$row->Id] = $row->Name;
    }
    $proc->close();
    $response['size'] = count($areas_list);
    $response = array_merge($response, $areas_list);

    success($response);
    return true;
}

function get_roles(&$response)
{
    $areas_list = Array();
    if (!$connection = connect_db_or_error($response))
        return false;
    $proc = $connection->prepare("call SelectRoles()");
    $proc->execute();
    if (!check_if_execution_error($response, $proc))
        return false;
    $result = $proc->get_result();
    while ($row = $result->fetch_object()) {
        $areas_list[$row->Id] = $row->Name;
    }
    $proc->close();
    $response['size'] = count($areas_list);
    $response = array_merge($response, $areas_list);

    success($response);
    return true;
}

function get_aliases_encoded_string(&$response)
{
    $aliases_list = get_aliases($response);
    if (!$response['status'])
        return false;
    $response['size'] = count($aliases_list);
    $response = array_merge($response, $aliases_list);

    success($response);
    return true;
}

function send_letters(&$response)
{
    $man_index = $_POST['man'];
    $group_index = $_POST['group'];
    $raw_mail = $_POST['mail'];
    $theme = $_POST['theme'];
    $text = $_POST['text'];
    if ($raw_mail !== null) {
        mail($raw_mail, $theme, $text);
    } else {
        $aliases = get_aliases($response);
        if (!$response['status'])
            return false;
        if ($man_index !== null) {
            if (!$human_full = get_human_data($response, $man_index))
                return false;
            $prepared_text = prepare_text($text, $aliases, $human_full);
            if (send_mails_to_human($response, $man_index, $theme, $prepared_text))
                return false;
        } else if ($group_index !== null) {
            if (!$group = get_group_data($response, $group_index))
                return false;
            foreach ($group as &$human) {
                $index = $human->m_index;
                if (!$human_full = get_human_data($response, $index))
                    return false;
                $prepared_text = prepare_text($text, $aliases, $human_full);
                if (!send_mails_to_human($response, $index, $theme, $prepared_text))
                    return false;
            }
        }
    }
    success($response);
    return true;
}

function send_mails_to_human(&$response, $index, $theme, $prepared_text){
    $mails = get_emails($response, $index);
    if (!$response['status'])
        return false;
    foreach ($mails as &$mail) {
        $address = $mail->m_value;
        mail($address, $theme, $prepared_text);
    }
    return true;
}

function prepare_text($text, $aliases, $human)
{
    $search = Array();
    $replace = Array();
    foreach ($aliases as &$aliase) {
        $value = get_value_for_aliase($aliase->m_field, $human);
        $search[] = $aliase->m_aliase;
        $replace[] = $value;
    }
    return str_replace($search, $replace, $text);
}

function get_value_for_aliase($field_name, $human)
{
    switch ($field_name) {
        case "Name":
            return $human->m_name;
        case "Surname":
            return $human->m_surname;
    }
}

function check_user_level($level_neded)
{
    $login = $_SESSION['login'];
    $level = $_SESSION['level'];
    if ($login && $level>=$level_neded)
        return true;
    return false;
}

function login(&$response){
    $login = $_POST['login'];
    $pass = $_POST['pass'];
    if (!$connection = connect_db_or_error($response))
        return false;
    $proc = $connection->prepare("call SelectUserPassword(?)");
    $proc->bind_param('s', $login);
    $proc->execute();
    if (!check_if_execution_error($response, $proc))
        return false;
    $result = $proc->get_result();
    $row = $result->fetch_object();
    $salt = $row->Salt;
    $hash = $row->hash;
    $encrypted_pass = crypt($pass, $salt);
    if ($encrypted_pass == $hash) {
        $_SESSION['login'] = $login;
        $_SESSION['level'] = $row->lvl;
        success($response);
    }else {
        global $Error_codes;
        fail_and_message($response, $Error_codes["Login failed"]);
        return false;
    }
    $proc->close();
    return true;
}

function logout(&$response){
    $_SESSION['login'] = null;
    $_SESSION['level'] = null;
    success($response);
    return true;
}

function get_users(&$response){
    $users_list = Array();
    if (!$connection = connect_db_or_error($response))
        return false;
    $proc = $connection->prepare("call SelectUsers()");
    $proc->execute();
    if (!check_if_execution_error($response, $proc))
        return false;
    $result = $proc->get_result();
    while ($row = $result->fetch_object()) {
        $user = new User();
        $user->m_index = $row->Id;
        $user->m_login = $row->login;
        $user->m_level = $row->Priveleges;
        $users_list[$row->Id] = $user;
    }
    $proc->close();
    $response['size'] = count($users_list);
    $response = array_merge($response, $users_list);

    success($response);
    return true;
}

function add_user(&$response){
    $login = $_POST['login'];
    $pass = $_POST['pass'];
    $level = $_POST['level'];
    $salt = uniqid(mt_rand(), true);
    $small_salt = substr($salt, 0, 4);
    $pass_encoded = crypt($pass, $small_salt);
    if (!$connection = connect_db_or_error($response))
        return false;
    $proc = $connection->prepare("call AddUser(?,?,?,?)");
    $proc->bind_param('sssi', $login, $pass_encoded, $small_salt, $level);
    $proc->execute();
    if (!check_if_execution_error($response, $proc))
        return false;
    $proc->close();
    success($response);
    return true;
}

function delete_user(&$response){
    $user = $_GET['user'];
    if (!$connection = connect_db_or_error($response))
        return false;
    $proc = $connection->prepare("call DeleteUser(?)");
    $proc->bind_param('i', $user);
    $proc->execute();
    if (!check_if_execution_error($response, $proc))
        return false;
    $proc->close();
    success($response);
    return true;
}

function mass_import(&$response){
    $defaults = $_POST['defaults'];
    $data = $_POST['data'];
    if (!$connection = connect_db_or_error($response))
        return false;
    foreach ($data as &$human_raw) {
        setted_or_default($mail, $human_raw['mail'], '', '', check_email);
        setted_or_default($name, $human_raw['name'], $defaults['name'],'', check_dummy);
        setted_or_default($sname, $human_raw['sname'], $defaults['sname'],'', check_dummy);
        setted_or_default($fname, $human_raw['fname'], $defaults['fname'], '',check_dummy);
        setted_or_default($area, $human_raw['area'], $defaults['area'],'', check_dummy);
        setted_or_default($town, $human_raw['town'], $defaults['town'],'', check_dummy);
        setted_or_default($origin, $human_raw['origin'], $defaults['origin'],'', check_dummy);
        setted_or_default($role, $human_raw['role'], $defaults['role'],'', check_dummy);
        setted_or_default($birthdate, $human_raw['birthdate'], $defaults['birthdate'], null, check_date);
            
        $proc = $connection->prepare("call AddHumanWithEMail(?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $proc->bind_param('sssssssss',
            $sname,
            $name,
            $fname,
            $area,
            $town,
            $origin,
            $role,
            $birthdate,
            $mail);
        $proc->execute();
        if (!check_if_execution_error($response, $proc))
            return false;
    }
    $proc->close();
    success($response);
    return true;
}

function setted_or_default(&$return, $value, $default_value, $null_value, $checker){
    if (isset ($value) && $value !='') {
        $return = $value;
        if ($checker($return))
            return true;
    }
    if (isset ($default_value) && $default_value != '') {
        $return = $default_value;
    } else {
        $return = $null_value;
        return false;
    }
    return $checker($return);
}

function check_dummy($value){
    return true;
}

function check_email(&$email){
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $email = '';
    }
    return true;
}

function check_date(&$date) {
    $tempDate = explode('-', $date);
    if (checkdate($tempDate[1], $tempDate[2], $tempDate[0]))
        $date = null;
    return true;
}

function check_if_failed(&$response){
    return !$response['status'];
}

?>