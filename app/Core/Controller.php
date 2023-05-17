<?php

require 'app/Config/Public_Variables.php';

class Controller extends Public_Variables
{

    public $userData, $dToko;
    public $v_viewer, $v_content, $v_load;

    public function __construct()
    {
        if (!(isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] == 'on' ||
            $_SERVER['HTTPS'] == 1) ||
            isset($_SERVER['HTTP_X_FORWARDED_PROTO']) &&
            $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')) {
            $redirect = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
            header('HTTP/1.1 301 Moved Permanently');
            header('Location: ' . $redirect);
            exit();
        }
    }

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
        if (isset($_SESSION['login_orins'])) {
            if ($_SESSION['login_orins'] == False) {
                $this->logout();
            }
        } else {
            header("location: " . $this->BASE_URL . "Login");
        }
    }

    public function data()
    {
        if (isset($_SESSION['login_orins'])) {
            if ($_SESSION['login_orins'] == true) {
                $this->userData = $_SESSION['user_data'];
                $this->dToko = $_SESSION['data_toko'];

                foreach ($this->dToko as $dt) {
                    if ($dt['id_toko'] == $this->userData['id_toko']) {
                        $this->userData['nama_toko'] = $dt['nama_toko'];
                    }
                }
            }
        }
    }

    public function dataSynchrone()
    {
        unset($_SESSION['user_data']);
        $where = "user = '" . $this->userData["user"] . "'";
        $_SESSION['user_data'] = $this->model('M_DB_1')->get_where_row('user', $where);
        $_SESSION['data_toko'] = $this->model('M_DB_1')->get('toko');
    }

    public function logout()
    {
        session_start();
        session_unset();
        session_destroy();
        header('Location: ' . $this->BASE_URL . "Login");
    }
}
