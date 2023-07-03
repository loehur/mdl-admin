<?php

class Karyawan extends Controller
{
   public $page = __CLASS__;

   public function __construct()
   {
      $this->session_cek();
      $this->data();
      if (!in_array($this->userData['user_tipe'], $this->pAdmin)) {
         $this->model('Log')->write($this->userData['user'] . " Force Logout. Hacker!");
         $this->logout();
      }

      $this->v_content = $this->page . "/content";
      $this->v_viewer = $this->page . "/viewer";
   }

   public function index()
   {

      $this->view("Layouts/layout_main", [
         "content" => $this->v_content,
         "title" => "Karyawan Aktif"
      ]);
      $this->viewer();
   }

   public function viewer($parse = "")
   {
      $this->view($this->v_viewer, ["page" => $this->page, "parse" => $parse]);
   }

   public function content($parse = "")
   {
      $where = "id_toko = " . $this->userData['id_toko'];
      $data = $this->model('M_DB_1')->get_where('karyawan', $where);
      $this->view($this->v_content, $data);
   }

   function add()
   {
      $nama = $_POST['nama'];
      $cols = 'id_toko, nama';
      $vals = "'" . $this->userData['id_toko'] . "','" . $nama . "'";

      $whereCount = "id_toko = '" . $this->userData['id_toko'] . "' AND nama = '" . $nama . "'";
      $dataCount = $this->model('M_DB_1')->count_where('karyawan', $whereCount);
      if ($dataCount < 1) {
         $do = $this->model('M_DB_1')->insertCols('karyawan', $cols, $vals);
         if ($do['errno'] == 0) {
            $this->model('Log')->write($this->userData['user'] . " Add Karyawan Success!");
            echo $do['errno'];
         } else {
            print_r($do['error']);
         }
      } else {
         $this->model('Log')->write($this->userData['user'] . " Add Karyawan Failed, Double Forbidden!");
         echo "Double Entry!";
      }
   }
}
