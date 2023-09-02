<?php

class Cash_Sale extends Controller
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
         "title" => "Cash - Sale"
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
      if ($_SESSION['user']['id_laundry'] <> "") {
         $data['cabang'] = $this->db(2)->get_where("user", "id_master = '" . $_SESSION['user']['id_sale'] . "'");
      }
      $this->view($this->v_content, $data);
   }

   function load_kas($id)
   {
      $data['_c'] = __CLASS__;
      $data['id'] = $id;

      $totalTarikSup = $this->db(2)->sum_col_where("kas", "jumlah", "id_user = '" . $id . "' AND kas_mutasi = 0 AND kas_status <> 2 AND kas_jenis = 0");
      $kasJualTotal = $this->db(2)->sum_col_where("barang_jual", "harga_jual", "id_user = '" . $id . "' AND op_status = 1");
      $kasFeeTotal = $this->db(2)->sum_col_where("barang_jual", "fee", "id_user = '" . $id . "' AND op_status = 1");
      $kasSupTotal = $kasJualTotal - $kasFeeTotal;
      $data['saldo'] = $kasSupTotal - $totalTarikSup;
      $data['debit_list'] = $this->db(2)->get_where("kas", "id_user = '" . $id . "' AND kas_jenis = 0 ORDER BY id DESC LIMIT 5");
      $this->view(__CLASS__ . "/load", $data);
   }

   function tarik()
   {
      $id = $_POST['id'];
      $jumlah = $_POST["jumlah"];
      $ket = $_POST["ket"];

      $columns = 'id_user, keterangan, jumlah, kas_mutasi, kas_status, kas_jenis, id_master';
      $values = "'" . $id . "','" . $ket . "','" . $jumlah . "',0,1,0,'" . $_SESSION['user']['id_sale'] . "'";
      $do = $this->db(2)->insertCols("kas", $columns, $values);

      if ($do['errno'] == 0) {
         echo 0;
      } else {
         print_r($do['error']);
      }
   }

   function push()
   {
      $no = $_POST['no'];
      $count = $this->db(2)->count_where("user", "id_user = '" . $no . "' AND user_tipe = 1");

      if ($count == 1) {
         $code = rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9);
         $_SESSION['set_sale'] = array(
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
      $data = $this->db(2)->get_where_row("user", "id_user = '" . $no . "' AND user_tipe = 1");
      $set = $_SESSION['set_sale'];
      if ($set['hp'] == $data['id_user'] && $set['code'] == $code) {
         $ex = $this->db(0)->update("user", "id_sale = '" . $data['id_user'] . "'", "hp = '" . $_SESSION['user']['hp'] . "'");
         $_SESSION['user']['id_sale'] = $data['id_user'];
         echo $ex['errno'];
      } else {
         echo "Kode OTP tidak Valid";
      }
   }
}
