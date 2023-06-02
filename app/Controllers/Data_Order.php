<?php

class Data_Order extends Controller
{
   public $page = __CLASS__;

   public function __construct()
   {
      $this->session_cek();
      $this->data();
      $this->v_content = $this->page . "/content";
      $this->v_viewer = $this->page . "/viewer";
   }

   public function index($jenis_pelanggan)
   {
      if ($jenis_pelanggan == 0) {
         $this->view("Layouts/layout_main", [
            "content" => $this->v_content,
            "title" => "Data Order - Proses"
         ]);
      } elseif ($jenis_pelanggan == 1) {
         $this->view("Layouts/layout_main", [
            "content" => $this->v_content,
            "title" => "Data Order - Tuntas"
         ]);
      }
      $this->viewer($jenis_pelanggan);
   }

   public function viewer($parse = "")
   {
      $this->view($this->v_viewer, ["page" => $this->page, "parse" => $parse]);
   }

   public function content($parse = "")
   {
      $wherePelanggan =  "id_toko = " . $this->userData['id_toko'];
      $data['pelanggan'] = $this->model('M_DB_1')->get_where('pelanggan', $wherePelanggan);
      $whereKarywan = "id_toko = " . $this->userData['id_toko'];
      $data['karyawan'] = $this->model('M_DB_1')->get_where('karyawan', $whereKarywan);

      $where = "id_toko = " . $this->userData['id_toko'] . " AND id_pelanggan <> 0 AND tuntas = 0 ORDER BY ref DESC";
      $data['order'] = $this->model('M_DB_1')->get_where('order_data', $where);

      $data_ = [];
      foreach ($data['order'] as $key => $do) {
         $data_[$do['ref']][$key] = $do;
      }

      $col = [];
      $actif_col = 1;
      $col[1] = 0;
      $col[2] = 0;

      $data_fix[1] = [];
      $data_fix[2] = [];

      foreach ($data_ as $key => $d) {
         if ($col[1] <= $col[2]) {
            $actif_col = 1;
         } else {
            $actif_col = 2;
         }
         $col[$actif_col] += count($data_[$key]);

         $data_fix[$actif_col][$key] = $d;
      }
      $data['order'] = $data_fix;

      $this->view($this->v_content, $data);
   }

   function cashier_verify()
   {
      $ref = $_POST['ref'];
      $whereOrder = "ref = '" . $ref . "'";
      $set = "id_cashier = " . $this->userData['id_user'];
      $do = $this->model('M_DB_1')->update("order_data", $set, $whereOrder);
      if ($do['errno'] == 0) {
         $this->model('Log')->write($this->userData['user'] . " Cashier Verified success!");
         echo $do['errno'];
      } else {
         $this->model('Log')->write($this->userData['user'] . " Cashier Verified " . $do['error']);
         print_r($do['error']);
      }
   }
}
