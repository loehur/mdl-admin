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
      $data['id_jenis_pelanggan'] = $parse;

      $where = "id_toko = " . $this->userData['id_toko'] . " AND id_user = " . $this->userData['id_user'] . " AND id_pelanggan = 0";
      $data['order'] = $this->model('M_DB_1')->get_where('order_data', $where);

      $wherePelanggan =  "id_toko = " . $this->userData['id_toko'] . " AND id_pelanggan_jenis = " . $parse;
      $data['pelanggan'] = $this->model('M_DB_1')->get_where('pelanggan', $wherePelanggan);
      $whereKarywan = "id_toko = " . $this->userData['id_toko'];
      $data['karyawan'] = $this->model('M_DB_1')->get_where('karyawan', $whereKarywan);

      $this->view($this->v_content, $data);
   }

   function add($id_pelanggan_jenis)
   {
      $id_produk = $_POST['id_produk'];
      $jumlah = $_POST['jumlah'];
      $note = $_POST['note'];

      $spkNote = [];
      foreach ($this->dSPK as $sd) {
         if ($sd['id_produk'] == $id_produk) {
            $spkNote[$sd['id_divisi']] = $_POST['d-' . $sd['id_divisi']];
         }
      }

      $data = [];

      foreach ($this->dProduk as $dp) {
         if ($dp['id_produk'] == $id_produk) {
            $data = unserialize($dp['produk_detail']);
         }
      }

      $produk_code = "";
      $detail_sum_code = 0;
      foreach ($data as $d) {

         $id_detail_item = $_POST['f-' . $d];

         foreach ($this->dDetailItem as $di) {
            if ($di['id_detail_item'] == $id_detail_item) {
               $detail_item = $di['detail_item'];
            }
         }


         $groupName = "";
         foreach ($this->dDetailGroup as $dg) {
            if ($dg['id_detail_group'] == $d) {
               $groupName = $dg['detail_group'];
            }
         }

         $produk_detail_[$d] = array(
            "group_name" => $groupName,
            "detail_id" => $id_detail_item,
            "detail_name" => $detail_item,
         );

         $detail_sum_code += ($d + $id_detail_item);
      }

      $produk_code = $id_produk . "-" . $detail_sum_code;
      $produk_detail = serialize($produk_detail_);

      $whereToko = "id_toko = " . $this->userData['id_toko'];
      $data_harga = $this->model('M_DB_1')->get_where('produk_harga', $whereToko);

      $harga = 0;
      foreach ($data_harga as $dh) {
         if ($dh['produk_code'] == $produk_code) {
            $harga = $dh['harga_' . $id_pelanggan_jenis];
            break;
         }
      }

      $spkDVS = [];

      foreach ($this->dSPK as $ds) {
         $detailNeed = [];
         $dgr = unserialize($ds['detail_groups']);

         foreach ($dgr as $key => $dgr_) {
            foreach ($produk_detail_ as $key => $pd) {
               if ($dgr_ == $key) {
                  $detailNeed[$pd['detail_id']] = $pd['detail_name'];
               }
            }
         }

         if ($ds['id_produk'] == $id_produk) {
            $spkDVS[$ds['id_divisi']] = array(
               "divisi_code" => "D-" . $ds['id_divisi'],
               "spk" => $detailNeed,
               "status" => 0,
               "user_produksi" => 0,
               "update" => ""
            );
         }
      }

      $spkDVS_ = serialize($spkDVS);
      $spkNote_ = serialize($spkNote);

      $cols = 'id_toko, id_produk, produk_code, produk_detail, spk_dvs, jumlah, harga, id_user, note, note_spk';
      $vals = $this->userData['id_toko'] . "," . $id_produk . ",'" . $produk_code . "','" . $produk_detail . "','" . $spkDVS_ . "'," . $jumlah . "," . $harga . "," . $this->userData['id_user'] . ",'" . $note . "','" . $spkNote_ . "'";

      $do = $this->model('M_DB_1')->insertCols('order_data', $cols, $vals);
      if ($do['errno'] == 0) {
         $this->model('Log')->write($this->userData['user'] . " Add Order Success!");
         echo $do['errno'];
      } else {
         print_r($do['error']);
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

      $spkNote = [];
      foreach ($this->dSPK as $sd) {
         if ($sd['id_produk'] == $produk) {
            $spkNote[$sd['id_divisi']] = "";
         }
      }

      $data_ = [];
      foreach ($data as $d) {
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

      $data_['detail'] = $data_;
      $data_['spkNote'] = $spkNote;

      $this->view($this->page . "/detail", $data_);
   }

   function add_price($id_pelanggan_jenis)
   {
      $produk_code = $_POST['produk_code'];
      $harga = $_POST['harga'];

      $cols = 'id_toko, produk_code, harga_' . $id_pelanggan_jenis;
      $vals = "'" . $this->userData['id_toko'] . "','" . $produk_code . "'," . $harga;

      $whereCount = "id_toko = '" . $this->userData['id_toko'] . "' AND produk_code = '" . $produk_code . "'";
      $dataCount = $this->model('M_DB_1')->count_where('produk_harga', $whereCount);
      if ($dataCount < 1) {
         $do = $this->model('M_DB_1')->insertCols('produk_harga', $cols, $vals);
         if ($do['errno'] == 0) {
            $this->model('Log')->write($this->userData['user'] . " Add produk_harga Success!");

            $whereOrder = "id_toko = " . $this->userData['id_toko'] . " AND id_user = " . $this->userData['id_user'] . " AND id_pelanggan = 0 AND produk_code = '" . $produk_code . "'";
            $set = "harga = " . $harga;
            $do = $this->model('M_DB_1')->update("order_data", $set, $whereOrder);
            if ($do['errno'] == 0) {
               $this->model('Log')->write($this->userData['user'] . " Add Update harga order data success!");
               echo $do['errno'];
            } else {
               $this->model('Log')->write($this->userData['user'] . " update harga order_data" . $do['error']);
               print_r($do['error']);
            }
         } else {
            print_r($do['error']);
         }
      } else {
         $set = "harga_" . $id_pelanggan_jenis . " = " . $harga;
         $do = $this->model('M_DB_1')->update("produk_harga", $set, $whereCount);

         if ($do['errno'] == 0) {
            $this->model('Log')->write($this->userData['user'] . " Add produk_harga Success!");

            $whereOrder = "id_toko = " . $this->userData['id_toko'] . " AND id_user = " . $this->userData['id_user'] . " AND id_pelanggan = 0 AND produk_code = '" . $produk_code . "'";
            $set = "harga = " . $harga;
            $do = $this->model('M_DB_1')->update("order_data", $set, $whereOrder);
            if ($do['errno'] == 0) {
               $this->model('Log')->write($this->userData['user'] . " Add Update harga order data success!");
               echo $do['errno'];
            } else {
               $this->model('Log')->write($this->userData['user'] . " update harga order_data" . $do['error']);
               print_r($do['error']);
            }
         } else {
            $this->model('Log')->write($this->userData['user'] . " Add produk_harga Failed, Double Forbidden!");
            print_r($do['error']);
         }
      }
   }

   function proses($id_pelanggan_jenis)
   {
      $whereCount = "id_toko = " . $this->userData['id_toko'] . " AND id_user = " . $this->userData['id_user'] . " AND id_pelanggan = 0 AND harga = 0";
      $dataCount = $this->model('M_DB_1')->count_where('order_data', $whereCount);
      if ($dataCount > 0) {
         echo "Lengkapi data harga terlebih dahulu!";
         exit();
      }

      $id_pelanggan = $_POST['id_pelanggan'];
      $id_karyawan = $_POST['id_karyawan'];
      $ref = date("Ymdhis");

      $where = "id_toko = " . $this->userData['id_toko'] . " AND id_user = " . $this->userData['id_user'] . " AND id_pelanggan = 0";
      $set = "id_penerima = " . $id_karyawan . ", id_pelanggan = " . $id_pelanggan . ", id_pelanggan_jenis = " . $id_pelanggan_jenis . ", ref = '" . $ref . "'";
      $do = $this->model('M_DB_1')->update("order_data", $set, $where);
      if ($do['errno'] == 0) {
         $this->model('Log')->write($this->userData['user'] . " Proses order_data Success!");
         echo $do['errno'];
      } else {
         $this->model('Log')->write($this->userData['user'] . " " . $do['error']);
         print_r($do['error']);
         exit();
      }
   }

   function deleteOrder()
   {
      $id_order = $_POST['id_order'];
      $where = "id_order_data =" . $id_order;
      $do = $this->model('M_DB_1')->delete_where('order_data', $where);
      if ($do['errno'] == 0) {
         $this->model('Log')->write($this->userData['user'] . " Delete Order Success!");
         echo $do['errno'];
      } else {
         print_r($do);
      }
   }
}
