<?php

class Cash_Laundry extends Controller
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
         "title" => "Cash - Laundry"
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
         $data['cabang'] = $this->db(1)->get_where("cabang", "id_laundry = '" . $_SESSION['user']['id_laundry'] . "'");
      }
      $this->view($this->v_content, $data);
   }

   function load_kas($id)
   {
      $data['_c'] = __CLASS__;
      $data['id'] = $id;

      $wCabang = "id_cabang = " . $id;
      $where = $wCabang . " AND jenis_mutasi = 1 AND metode_mutasi = 1 AND status_mutasi = 3";
      $cols = "SUM(jumlah) as jumlah";
      $kredit = $this->db(1)->get_cols_where("kas", $cols, $where, 0)['jumlah'];

      $where = $wCabang . " AND jenis_mutasi = 2 AND metode_mutasi = 1 AND status_mutasi <> 4";
      $cols = "SUM(jumlah) as jumlah";
      $debit = $this->db(1)->get_cols_where("kas", $cols, $where, 0)['jumlah'];

      $data['saldo'] = $kredit - $debit;

      $where = $wCabang . " AND jenis_mutasi = 2 ORDER BY id_kas DESC LIMIT 5";
      $data['debit_list'] = $this->db(1)->get_where("kas", $where);

      $this->view(__CLASS__ . "/load", $data);
   }

   function tarik()
   {
      $id = $_POST['id'];
      $keterangan = $_POST['ket'];
      $jumlah = $_POST['jumlah'];

      $wCabang = "id_cabang = " . $id;
      $penarik = 0;
      $today = date('Y-m-d');
      $status_mutasi = 3;

      $cols = 'id_cabang, jenis_mutasi, jenis_transaksi, metode_mutasi, note, status_mutasi, jumlah, id_user, id_client, note_primary';
      $vals = $id . ",2,2,1,'" . $keterangan . "'," . $status_mutasi . "," . $jumlah . "," . $penarik . ",0,'Penarikan'";

      $setOne = "note = '" . $keterangan . "' AND jumlah = " . $jumlah . " AND insertTime LIKE '" . $today . "%'";
      $where = $wCabang . " AND " . $setOne;
      $data_main = $this->db(1)->count_where("kas", $where);

      if ($data_main < 1) {
         $do = $this->db(1)->insertCols('kas', $cols, $vals);
         if ($do['errno'] == 0) {
            echo $do['errno'];
         } else {
            print_r($do);
         }
      } else {
         echo "Duplicate Entry!";
      }
   }

   function push()
   {
      $no = $_POST['no'];
      $count = $this->db(1)->count_where("user", "no_user = '" . $no . "' AND id_privilege = 100");

      if ($count == 1) {
         $code = rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9);
         $_SESSION['set_laundry'] = array(
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
      $data = $this->db(1)->get_where_row("user", "no_user = '" . $no . "' AND id_privilege = 100");
      $set = $_SESSION['set_laundry'];
      if ($set['hp'] == $data['no_user'] && $set['code'] == $code) {
         $ex = $this->db(0)->update("user", "id_laundry = '" . $data['id_laundry'] . "'", "hp = '" . $_SESSION['user']['hp'] . "'");
         $_SESSION['user']['id_laundry'] = $data['id_laundry'];
         echo $ex['errno'];
      } else {
         echo "Kode OTP tidak Valid";
      }
   }
}
