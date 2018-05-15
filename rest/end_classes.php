<?php

class Human{
    public $m_index;

    public $m_name;
    public $m_surname;
    public $m_fname;
    public $m_age;
    public $m_year;
    public $m_email;
    public $m_area;
    public $m_town;
    public $m_role;
    public $m_origin;
}

class Group{
    public $m_index;

    public $m_name;
    public $m_string_storage;
    public $m_size;
}

class Template{
    public $m_index;

    public $m_name;
    public $m_theme;
    public $m_text;
}

class Aliase{
    public $m_index;

    public $m_aliase;
    public $m_field;
}

class Email{
    public $m_index;

    public $m_value;
}

$Error_codes = array(
    "Failed to connect db" => 1,
    "Failed to execute procedure" => 2,
    "Zero results" => 3,
    "Wrong request" => 3,
);
?>