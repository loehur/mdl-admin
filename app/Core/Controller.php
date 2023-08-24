<?php

require 'app/Config/Public_Variables.php';

class Controller extends Public_Variables
{

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

    public function db()
    {
        if (strlen($this->db_pass) == 0) {
            $_SESSION['secure']['db_pass'] = "";
        } else {
            $_SESSION['secure']['db_pass'] = $this->model("Enc")->dec_2($this->db_pass);
        }
    }
}
