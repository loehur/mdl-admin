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


      $whereToko = "id_toko = " . $this->userData['id_toko'];
      $data_harga = $this->model('M_DB_1')->get_where('produk_harga', $whereToko);

      foreach ($data['order'] as $key => $do) {
         foreach ($data_harga as $dh) {
            if ($dh['code'] == $do['produk_code']) {
               $harga = $dh['harga_' . $parse];
               $data['order'][$key]['harga'] = $harga;
               break;
            }
         }
      }


      $wherePelanggan =  "id_toko = " . $this->userData['id_toko'] . " AND id_pelanggan_jenis = " . $parse;
      $data['pelanggan'] = $this->model('M_DB_1')->get_where('pelanggan', $wherePelanggan);
      $whereKarywan = "id_toko = " . $this->userData['id_toko'];
      $data['karyawan'] = $this->model('M_DB_1')->get_where('karyawan', $whereKarywan);

      $this->view($this->v_content, $data);
   }

   function add()
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



      $produk_code = $id_produk . "#";
      $detail_code = "";

      foreach ($data as $d) {

         $groupName = "";
         $detail_item = "";

         $id_detail_item = $_POST['f-' . $d];
         foreach ($this->dDetailItem as $di) {
            if ($di['id_detail_item'] == $id_detail_item) {
               $detail_item = $di['detail_item'];
            }
         }

         foreach ($this->dDetailGroup as $dg) {
            if ($dg['id_index'] == $d) {
               $groupName = $dg['detail_group'];
            }
         }

         if ($groupName == "" || $detail_item == "") {
            echo "Error! diperlukan Synchrone Data!";
            exit();
         }

         $produk_detail_[$d] = array(
            "group_name" => $groupName,
            "detail_id" => $id_detail_item,
            "detail_name" => $detail_item,
         );

         $detail_code .= "-" . $id_detail_item;
      }

      $produk_code .= $detail_code;
      $produk_detail = serialize($produk_detail_);

      $spkDVS = [];

      foreach ($this->dSPK as $ds) {
         if ($id_produk == $ds['id_produk']) {
            $detailNeed = [];
            $dgr = unserialize($ds['detail_groups']);
            $cm = $ds['cm'];

            foreach ($dgr as $key => $dgr_) {
               foreach ($produk_detail_ as $key => $pd) {
                  if ($dgr_ == $key) {
                     $detailNeed[$pd['detail_id']] = $pd['detail_name'];
                  }
               }
            }

            $spkDVS[$ds['id_divisi']] = array(
               "divisi_code" => "D-" . $ds['id_divisi'],
               "spk" => $detailNeed,
               "status" => 0,
               "user_produksi" => 0,
               "update" => "",
               "cm" => $cm, //complete maker
               "cm_status" => 0,
               "user_cm" => 0,
               "update_cm" => "",
            );
         }
      }

      $spkDVS_ = serialize($spkDVS);
      $spkNote_ = serialize($spkNote);

      $cols = 'id_toko, id_produk, produk_code, produk_detail, spk_dvs, jumlah, id_user, note, note_spk';
      $vals = $this->userData['id_toko'] . "," . $id_produk . ",'" . $produk_code . "','" . $produk_detail . "','" . $spkDVS_ . "'," . $jumlah . "," . $this->userData['id_user'] . ",'" . $note . "','" . $spkNote_ . "'";

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
         $groupName = "";
         foreach ($this->dDetailGroup as $dg) {
            if ($dg['id_index'] == $d) {
               $where = "id_detail_group = " . $dg['id_detail_group'] . " ORDER BY detail_item ASC";
               $data_item = $this->model('M_DB_1')->get_where('detail_item', $where);
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

      $cols = 'id_toko, code, harga_' . $id_pelanggan_jenis;
      $vals = "'" . $this->userData['id_toko'] . "','" . $produk_code . "'," . $harga;

      $whereCount = "id_toko = '" . $this->userData['id_toko'] . "' AND code = '" . $produk_code . "'";
      $dataCount = $this->model('M_DB_1')->count_where('produk_harga', $whereCount);
      if ($dataCount < 1) {
         $do = $this->model('M_DB_1')->insertCols('produk_harga', $cols, $vals);
         if ($do['errno'] == 0) {
            $this->model('Log')->write($this->userData['user'] . " Add produk_harga Success!");
            echo $do['errno'];
         } else {
            print_r($do['error']);
         }
      } else {
         $where = "code = '" . $produk_code . "'";
         $set = "harga_" . $id_pelanggan_jenis . " = " . $harga;
         $update = $this->model('M_DB_1')->update("produk_harga", $set, $where);
         echo ($update['errno'] <> 0) ? $update['error'] : $update['errno'];
      }

      $this->dataSynchrone();
   }

   function proses($id_pelanggan_jenis)
   {

      $id_pelanggan = $_POST['id_pelanggan'];
      $id_karyawan = $_POST['id_karyawan'];
      $ref = date("Ymdhis");

      $where = "id_toko = " . $this->userData['id_toko'] . " AND id_user = " . $this->userData['id_user'] . " AND id_pelanggan = 0";
      $data['order'] = $this->model('M_DB_1')->get_where('order_data', $where);
      $whereToko = "id_toko = " . $this->userData['id_toko'];
      $data_harga = $this->model('M_DB_1')->get_where('produk_harga', $whereToko);

      $c_cart = count($data['order']);

      foreach ($data['order'] as $do) {
         foreach ($data_harga as $dh) {
            if ($dh['code'] == $do['produk_code']) {
               $harga = $dh['harga_' . $id_pelanggan_jenis];
               if ($harga <> 0) {
                  $c_cart -= 1;
               }
            }
         }
      }

      if ($c_cart <> 0) {
         echo "Tetapkan Harga terlebih dahulu!";
         exit();
      }

      $error = 0;

      foreach ($data['order'] as $do) {
         foreach ($data_harga as $dh) {
            if ($dh['code'] == $do['produk_code']) {
               $harga = $dh['harga_' . $id_pelanggan_jenis];
               if ($harga <> 0) {
                  $where = "id_order_data = " . $do['id_order_data'];
                  $set = "harga = " . $harga . ", id_penerima = " . $id_karyawan . ", id_pelanggan = " . $id_pelanggan . ", id_pelanggan_jenis = " . $id_pelanggan_jenis . ", ref = '" . $ref . "'";
                  $update = $this->model('M_DB_1')->update("order_data", $set, $where);
                  $error = $update['errno'];
               }
            }
         }
      }

      if ($error == 0) {
         echo 1;
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

   public function updateCell($parse)
   {
      $value = $_POST['value'];
      $id = $_POST['id'];

      $where = "code = '" . $id . "'";
      $set = "harga_" . $parse . " = " . $value;
      $update = $this->model('M_DB_1')->update("produk_harga", $set, $where);
      echo ($update['errno'] <> 0) ? $update['error'] : $update['errno'];
   }
}
