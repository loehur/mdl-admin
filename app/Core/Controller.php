<?php

require 'app/Config/Public_Variables.php';

class Controller extends Public_Variables
{

    public $userData, $dToko, $dDvs, $dProduk, $dDetailGroup, $dDetailItem;
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

                $this->dDvs = $_SESSION['data_divisi'];
                $this->dProduk = $_SESSION['produk'];
                $this->dDetailGroup = $_SESSION['detail_group'];
                $this->dDetailItem = $_SESSION['detail_item'];
            }
        }
    }

    public function dataSynchrone()
    {
        $where = "id_user = '" . $this->userData["id_user"] . "'";

        unset($_SESSION['user_data']);
        $_SESSION['user_data'] = $this->model('M_DB_1')->get_where_row('user', $where);

        $whereToko = "id_toko = " . $this->userData['id_toko'];
        $_SESSION['data_toko'] = $this->model('M_DB_1')->get('toko');
        $_SESSION['data_divisi'] = $this->model('M_DB_1')->get_where('divisi', $whereToko . " ORDER BY sort ASC");
        $_SESSION['produk'] = $this->model('M_DB_1')->get_where('produk', $whereToko);
        $_SESSION['detail_group'] = $this->model('M_DB_1')->get_where('detail_group', $whereToko);
        $_SESSION['detail_item'] = $this->model('M_DB_1')->get_where('detail_item', $whereToko);
    }

    public function logout()
    {
        session_start();
        session_unset();
        session_destroy();
        header('Location: ' . $this->BASE_URL . "Login");
    }
}
