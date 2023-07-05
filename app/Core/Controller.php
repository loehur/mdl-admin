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

    public function data()
    {
        if (isset($_SESSION['login'])) {
            if ($_SESSION['login'] == true) {
                $this->userData = $_SESSION['user_data'];
            }
        }
    }

    public function dataSynchrone()
    {
        $where = "id_user = '" . $this->userData["id_user"] . "'";
        unset($_SESSION['user_data']);
        $_SESSION['user_data'] = $this->model('M_DB_1')->get_where_row('user', $where);
    }

    public function logout()
    {
        session_start();
        session_unset();
        session_destroy();
        header('Location: ' . $this->BASE_URL . "Login");
    }
}
