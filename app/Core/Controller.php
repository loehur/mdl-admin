<?php

require 'app/Config/Public_Variables.php';

class Controller extends Public_Variables
{

    public $userData;
    public $v_viewer, $v_content, $v_load;

    public function view($file, $data = [])
    {
        require_once "app/Views/" . $file . ".php";
    }

    public function model($file)
    {
        require_once "app/Models/" . $file . ".php";
        return new $file();
    }
}
