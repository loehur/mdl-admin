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

    public function db($db = 0)
    {
        $file = "M_DB";
        require_once "app/Models/" . $file . ".php";
        return new $file($db);
    }

    public function session_cek()
    {
        if (isset($_SESSION['login'])) {
            if ($_SESSION['login'] == False) {
                $this->logout();
            }
        } else {
            header("location: " . $this->BASE_URL . "Login");
        }
    }

    public function logout()
    {
        session_destroy();
        header('Location: ' . $this->BASE_URL . "Login");
    }
}
