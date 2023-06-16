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

   public function index($parse)
   {
      if ($parse == 0) {
         $this->view("Layouts/layout_main", [
            "content" => $this->v_content,
            "title" => "Data Order - Proses"
         ]);
      } elseif ($parse == 1) {
         $this->view("Layouts/layout_main", [
            "content" => $this->v_content,
            "title" => "Data Order - Tuntas"
         ]);
      }
      $this->viewer($parse);
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

      $where = "id_toko = " . $this->userData['id_toko'] . " AND id_pelanggan <> 0 AND tuntas = " . $parse . " ORDER BY ref DESC";
      $data['order'] = $this->model('M_DB_1')->get_where('order_data', $where);

      $refs = array_column($data['order'], 'ref');
      if (count($refs) > 0) {
         $min_ref = min($refs);
         $max_ref = max($refs);
         $where = "id_toko = " . $this->userData['id_toko'] . " AND jenis_transaksi = 1 AND (ref_transaksi BETWEEN " . $min_ref . " AND " . $max_ref . ")";
         $data['kas'] = $this->model('M_DB_1')->get_where('kas', $where);
      }

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

   function bayar()
   {
      $ref = $_POST['ref'];
      $jumlah = $_POST['jumlah'];
      $bill = $_POST['bill'];
      $method = $_POST['method'];

      if ($jumlah > $bill) {
         $jumlah = $bill;
      }

      $whereCount = "ref_transaksi = '" . $ref . "' AND jumlah = " . $jumlah;
      $dataCount = $this->model('M_DB_1')->count_where('kas', $whereCount);

      $cols = "id_toko, jenis_transaksi, jenis_mutasi, ref_transaksi, metode_mutasi, status_mutasi, jumlah, id_user";
      $vals = $this->userData['id_toko'] . ",1,1,'" . $ref . "'," . $method . ",1," . $jumlah . "," . $this->userData['id_user'];

      if ($dataCount < 1) {
         $do = $this->model('M_DB_1')->insertCols('kas', $cols, $vals);
         if ($do['errno'] == 0) {
            echo $do['errno'];
            $this->model('Log')->write($this->userData['user'] . " Bayar Success!");
         } else {
            echo $do['error'];
         }
      }
   }

   function ambil()
   {
      $id = $_POST['ambil_id'];
      $karyawan = $_POST['id_karyawan'];

      $where = "id_order_data = " . $id;
      $dateNow = date("Y-m-d H:i:s");
      $set = "id_ambil = " . $karyawan . ", tgl_ambil = '" . $dateNow . "'";
      $update = $this->model('M_DB_1')->update("order_data", $set, $where);
      echo ($update['errno'] <> 0) ? $update['error'] : $update['errno'];
   }

   function ambil_semua()
   {
      $ref = $_POST['ambil_ref'];
      $karyawan = $_POST['id_karyawan'];

      $where = "ref = '" . $ref . "' AND id_ambil = 0";
      $dateNow = date("Y-m-d H:i:s");
      $set = "id_ambil = " . $karyawan . ", tgl_ambil = '" . $dateNow . "'";
      $update = $this->model('M_DB_1')->update("order_data", $set, $where);
      echo ($update['errno'] <> 0) ? $update['error'] : $update['errno'];
   }

   public function print($parse = "")
   {
      $wherePelanggan =  "id_toko = " . $this->userData['id_toko'];
      $data['pelanggan'] = $this->model('M_DB_1')->get_where('pelanggan', $wherePelanggan);
      $whereKarywan = "id_toko = " . $this->userData['id_toko'];
      $data['karyawan'] = $this->model('M_DB_1')->get_where('karyawan', $whereKarywan);
      $where = "id_toko = " . $this->userData['id_toko'] . " AND ref = '" . $parse . "'";
      $data['order'] = $this->model('M_DB_1')->get_where('order_data', $where);

      $refs = array_column($data['order'], 'ref');
      if (count($refs) > 0) {
         $min_ref = min($refs);
         $max_ref = max($refs);
         $where = "id_toko = " . $this->userData['id_toko'] . " AND jenis_transaksi = 1 AND (ref_transaksi BETWEEN " . $min_ref . " AND " . $max_ref . ")";
         $data['kas'] = $this->model('M_DB_1')->get_where('kas', $where);
      }

      $this->view($this->page . "/print", $data);
   }
}
