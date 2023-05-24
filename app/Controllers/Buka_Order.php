<?php

class Buka_Order extends Controller
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
      if ($jenis_pelanggan == 1) {
         $this->view("Layouts/layout_main", [
            "content" => $this->v_content,
            "title" => "Buka Order - Umum"
         ]);
      } elseif ($jenis_pelanggan == 2) {
         $this->view("Layouts/layout_main", [
            "content" => $this->v_content,
            "title" => "Buka Order - Rekanan"
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
      $where = "id_toko = " . $this->userData['id_toko'];
      $data['order'] = $this->model('M_DB_1')->get_where('order_data', $where);
      $data['id_jenis_pelanggan'] = $parse;
      $this->view($this->v_content, $data);
   }

   function add($id_pelanggan_jenis)
   {
      $hp = $_POST['hp'];
      $nama = $_POST['nama'];
      $cek_hp = substr($hp, 4);

      if ($id_pelanggan_jenis == 1) {
         $cols = 'id_toko, nama, no_hp, id_pelanggan_jenis';
         $vals = "'" . $this->userData['id_toko'] . "','" . $nama . "','" . $hp . "'," . $id_pelanggan_jenis;
      } else {
         $usaha = $_POST['usaha'];
         $alamat = $_POST['alamat'];
         $cols = 'id_toko, nama, no_hp, usaha, alamat, id_pelanggan_jenis';
         $vals = "'" . $this->userData['id_toko'] . "','" . $nama . "','" . $hp . "','" . $usaha . "','" . $alamat . "'," . $id_pelanggan_jenis;
      }

      $whereCount = "id_toko = '" . $this->userData['id_toko'] . "' AND (nama = '" . $nama . "' OR no_hp LIKE '%" . $cek_hp . "')";
      $dataCount = $this->model('M_DB_1')->count_where('pelanggan', $whereCount);
      if ($dataCount < 1) {
         $do = $this->model('M_DB_1')->insertCols('pelanggan', $cols, $vals);
         if ($do['errno'] == 0) {
            $this->model('Log')->write($this->userData['user'] . " Add Pelanggan Success!");
            echo 0;
         } else {
            print_r($do['error']);
         }
      } else {
         $this->model('Log')->write($this->userData['user'] . " Add Pelanggan Failed, Double Forbidden!");
         echo "Pelanggan dengan Nama/Nomor tersebut sudah Ada!";
      }
   }

   function load_detail($produk)
   {
      $data = [];
      foreach ($this->dProduk as $dp) {
         if ($dp['id_produk'] == $produk) {
            $data = unserialize($dp['produk_detail']);
         }
      }
      $data_ = [];
      foreach ($data as $key => $d) {
         $where = "id_detail_group = " . $d . " ORDER BY detail_item ASC";
         $data_item = $this->model('M_DB_1')->get_where('detail_item', $where);

         $groupName = "";
         foreach ($this->dDetailGroup as $dg) {
            if ($dg['id_detail_group'] == $d) {
               $groupName = $dg['detail_group'];
            }
         }
         $data_[$d]['name'] = $groupName;
         $data_[$d]['item'] = $data_item;
      }

      $this->view($this->page . "/detail", $data_);
   }
}
