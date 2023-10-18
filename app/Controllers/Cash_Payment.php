<?php

class Cash_Payment extends Controller
{
   public function __construct()
   {
      $this->session_cek();
      $this->v_load = __CLASS__ . "/load";
      $this->v_content = __CLASS__ . "/content";
      $this->v_viewer = __CLASS__ . "/viewer";
   }

   public function index()
   {
      $this->view("Layouts/layout_main", [
         "content" => $this->v_content,
         "title" => "Cash - Payment"
      ]);
      $this->viewer();
   }

   public function viewer()
   {
      $this->view($this->v_viewer, ["page" => __CLASS__]);
   }

   public function content()
   {
      $data['_c'] = __CLASS__;
      if ($_SESSION['user']['id_payment'] <> "") {
         $data['cabang'] = $this->db(3)->get_where("user", "no_master = '" . $_SESSION['user']['id_payment'] . "'");
      }
      $this->view($this->v_content, $data);
   }

   function load_kas($id)
   {
      $data['_c'] = __CLASS__;
      $data['id'] = $id;

      $arr_success_kas = array();
      $data['prepaid'] = $this->db(3)->get_where('prepaid', "no_user = '" . $id . "'");
      foreach ($data['prepaid'] as $a) {
         if ($a['rc'] == "00" || $a['rc'] == "39" || $a['rc'] == "201" || $a['rc'] == "" || strlen($a['sn']) > 0) {
            if ($a['used'] == 0) {
               array_push($arr_success_kas, $a['price_sell']);
            }
         }
      }

      $data['postpaid'] = $this->db(3)->get_where('postpaid', "no_user = '" . $id . "'");
      foreach ($data['postpaid'] as $a) {
         if (strlen($a['noref'] > 0) || strlen($a['datetime']) > 0 || $a['tr_status'] == 1 || $a['tr_status'] == 3 || $a['tr_status'] == 4) {
            if ($a['used'] == 0) {
               array_push($arr_success_kas, $a['price_sell']);
            }
         }
      }

      $arr_manual_wd = array();
      $data['manual'] = $this->db(3)->get_where('manual', "no_user = '" . $id . "' ORDER BY updateTime DESC");
      foreach ($data['manual'] as $a) {
         if ($a['tr_status'] <> 3) {
            if ($id == $a['no_user']) {
               if ($a['id_manual_jenis'] == 1 || $a['id_manual_jenis'] == 2 || $a['id_manual_jenis'] == 5) {
                  array_push($arr_success_kas, $a['jumlah'] + $a['biaya']);
               } else {
                  array_push($arr_manual_wd, $a['jumlah'] - $a['biaya']);
               }
            }
         }
      }

      $total_success_kas = array_sum($arr_success_kas);

      $total_penarikan_success = 0;
      $arr_success_tarik = array();
      $data['tarik'] = $this->db(3)->get_where('kas', "no_user = '" . $id . "' AND kas_mutasi = 0 ORDER BY id DESC");
      foreach ($data['tarik'] as $a) {
         if ($a['kas_status'] == 1) {
            array_push($arr_success_tarik, $a['jumlah']);
         }
      }
      $total_penarikan_success = array_sum($arr_success_tarik);

      $data['debit_list'] = $data['tarik'];
      $data['saldo'] = $total_success_kas - $total_penarikan_success - array_sum($arr_manual_wd);

      $this->view(__CLASS__ . "/load", $data);
   }

   function tarik()
   {
      $id = $_POST['id'];
      $jumlah = $_POST["jumlah"];
      $ket = $_POST["ket"];

      $kas_status = 1;
      $columns = 'no_user, keterangan, jumlah, kas_mutasi, kas_status, no_master';
      $values = "'" . $id . "','" . $ket . "','" . $jumlah . "',0,'" . $kas_status . "','" . $_SESSION['user']['id_payment'] . "'";
      $do = $this->db(3)->insertCols("kas", $columns, $values);

      if ($do['errno'] == 0) {
         echo 0;
      } else {
         print_r($do['error']);
      }
   }

   function push()
   {
      $no = $_POST['no'];
      $count = $this->db(3)->count_where("user", "no_user = '" . $no . "' AND user_tipe = 1");

      if ($count == 1) {
         $code = rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9);
         $_SESSION['set_payment'] = array(
            "hp" => $no,
            "code" => $code
         );
         $this->model("WA")->send($no, $code);
         echo $count;
      } else {
         echo "Nomor tidak Valid";
      }
   }

   function set()
   {
      $no = $_POST['no'];
      $code = $_POST['code'];
      $data = $this->db(3)->get_where_row("user", "no_user = '" . $no . "' AND user_tipe = 1");
      $set = $_SESSION['set_payment'];
      if ($set['hp'] == $data['no_user'] && $set['code'] == $code) {
         $ex = $this->db(0)->update("user", "id_payment = '" . $data['no_user'] . "'", "hp = '" . $_SESSION['user']['hp'] . "'");
         $_SESSION['user']['id_payment'] = $data['no_user'];
         echo $ex['errno'];
      } else {
         echo "Kode OTP tidak Valid";
      }
   }
}
