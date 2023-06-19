<?php

class SPK extends Controller
{
   public $page = __CLASS__;

   public function __construct()
   {
      $this->session_cek();
      $this->data();
      $this->v_content = $this->page . "/content";
      $this->v_viewer = $this->page . "/viewer";
   }

   public function index($dvs)
   {
      foreach ($this->dDvs as $dv) {
         if ($dv['id_divisi'] == $dvs) {
            $t = $dv['divisi'];
         }
      }

      $this->view("Layouts/layout_main", [
         "content" => $this->v_content,
         "title" => "SPK - " . $t
      ]);

      $this->viewer($dvs);
   }

   public function viewer($parse = "")
   {
      $this->view($this->v_viewer, ["page" => $this->page, "parse" => $parse]);
   }

   public function content($parse = "")
   {
      $data['id_divisi'] = $parse;

      $wherePelanggan =  "id_toko = " . $this->userData['id_toko'];
      $data['pelanggan'] = $this->model('M_DB_1')->get_where('pelanggan', $wherePelanggan);
      $whereKarywan = "id_toko = " . $this->userData['id_toko'];
      $data['karyawan'] = $this->model('M_DB_1')->get_where('karyawan', $whereKarywan);

      $dvs = '"D-' . $parse . '"';
      $where = "id_toko = " . $this->userData['id_toko'] . " AND id_pelanggan <> 0 AND tuntas = 0 AND cancel = 0 AND spk_dvs LIKE '%" . $dvs . "%' ORDER BY id_order_data DESC";
      $data['order'] = $this->model('M_DB_1')->get_where('order_data', $where);

      $recap = [];
      $recap_2 = [];

      foreach ($data['order'] as $do) {
         $spk = unserialize($do['spk_dvs']);
         $spk_code = "";
         $spk_text = "";

         if ($spk[$parse]['status'] == 0) {
            foreach ($spk as $s_key => $sp) {
               if ($s_key == $parse) {
                  foreach ($sp['spk'] as $key_ => $sp_) {
                     $spk_code .= "-" . $key_;
                     $spk_text .= $sp_ . " ";
                  }
               }
            }

            if (isset($recap[$spk_code])) {
               $recap[$spk_code]['order'] .= "," . $do['id_order_data'];
               $recap[$spk_code]['jumlah'] += $do['jumlah'];
            } else {
               $recap[$spk_code]['order'] = $do['id_order_data'];
               $recap[$spk_code]['spk'] = $spk_text;
               $recap[$spk_code]['jumlah'] = $do['jumlah'];
            }
         } else {
            if ($spk[$parse]['cm'] == 1) {
               if ($spk[$parse]['cm_status'] == 0) {
                  foreach ($spk as $s_key => $sp) {
                     if ($s_key == $parse) {
                        foreach ($sp['spk'] as $key_ => $sp_) {
                           $spk_code .= "-" . $key_;
                           $spk_text .= $sp_ . " ";
                        }
                     }
                  }

                  if (isset($recap_2[$spk_code])) {
                     $recap_2[$spk_code]['order'] .= "," . $do['id_order_data'];
                     $recap_2[$spk_code]['jumlah'] += $do['jumlah'];
                  } else {
                     $recap_2[$spk_code]['order'] = $do['id_order_data'];
                     $recap_2[$spk_code]['spk'] = $spk_text;
                     $recap_2[$spk_code]['jumlah'] = $do['jumlah'];
                  }
               }
            }
         }
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
      $data['recap'] = $recap;
      $data['recap_2'] = $recap_2;

      $this->view($this->v_content, $data);
   }

   function load_update($order)
   {
      $data = explode(",", $order);

      $data_ = [];

      foreach ($data as $d) {
         $where = "id_order_data = " . $d;
         $data_[$d] = $this->model('M_DB_1')->get_where_row('order_data', $where);
      }

      $whereToko = "id_toko = " . $this->userData['id_toko'];
      $data['pelanggan'] = $this->model('M_DB_1')->get_where('pelanggan', $whereToko);

      $data['order'] = $data_;
      $this->view($this->page . "/update", $data);
   }

   function cekSPK($order, $parse)
   {
      $data_get = explode(",", $order);

      $data['order'] = [];
      foreach ($data_get as $d) {
         $where = "id_order_data = " . $d;
         $data_ = $this->model('M_DB_1')->get_where_row('order_data', $where);
         array_push($data['order'], $data_);
      }

      $data_ = [];
      foreach ($data['order'] as $key => $do) {
         $data_[$do['ref']][$key] = $do;
      }

      $data['order'] = $data_;
      $wherePelanggan =  "id_toko = " . $this->userData['id_toko'];
      $data['pelanggan'] = $this->model('M_DB_1')->get_where('pelanggan', $wherePelanggan);
      $whereKarywan = "id_toko = " . $this->userData['id_toko'];
      $data['karyawan'] = $this->model('M_DB_1')->get_where('karyawan', $whereKarywan);

      $data['parse'] = $parse;
      $this->view($this->page . "/cek", $data);
   }

   function updateSPK($id_divisi, $tahap = 1)
   {
      $karyawan = $_POST['id_karyawan'];
      $cek = $_POST['cek'];
      $date = date("Y-m-d h:i:s");

      if (count($cek) > 0) {
         foreach ($cek as $c) {
            $where = "id_order_data = " . $c;
            $data = unserialize($this->model('M_DB_1')->get_where_row('order_data', $where)['spk_dvs']);

            if ($tahap == 1) {
               $data[$id_divisi]["status"] = 1;
               $data[$id_divisi]["user_produksi"] = $karyawan;
               $data[$id_divisi]["update"] = $date;
            } else {
               $data[$id_divisi]["cm_status"] = 1;
               $data[$id_divisi]["user_cm"] = $karyawan;
               $data[$id_divisi]["update_cm"] = $date;
            }

            $set = "spk_dvs = '" . serialize($data) . "'";
            $do = $this->model('M_DB_1')->update("order_data", $set, $where);
            if ($do['errno'] == 0) {
               $this->model('Log')->write($this->userData['user'] . " updateSPK Success!");
               echo $do['errno'];
            } else {
               $this->model('Log')->write($this->userData['user'] . " updateSPK" . $do['error']);
               print_r($do['error']);
               exit();
            }
         }
      }
   }
}
