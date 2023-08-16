<?php

class Pengajuan extends Controller
{
   public $page = __CLASS__;

   public function __construct()
   {
      $this->session_cek();
      $this->data();
      $this->v_load = $this->page . "/load";
      $this->v_content = $this->page . "/content";
      $this->v_viewer = $this->page . "/viewer";
   }

   public function index()
   {
      $this->view("Layouts/layout_main", [
         "content" => $this->v_content,
         "title" => "Pinjaman - Pengajuan"
      ]);

      $this->viewer();
   }

   public function viewer()
   {
      $this->view($this->v_viewer, ["page" => $this->page]);
   }

   public function content()
   {
      $data['_c'] = __CLASS__;
      $where = "user = '" . $this->userData['user'] . "' AND (st_pinjaman BETWEEN 0 AND 1)";
      $data['run'] = $this->model("M_DB_1")->get_where_row("pengajuan", $where);

      if (is_array($data['run'])) {
         $where = "id_pengajuan = '" . $data['run']['id_pengajuan'] . "' ORDER BY bunga ASC";
         $data['penawaran'] = $this->model("M_DB_1")->get_where("penawaran", $where);
      } else {
         $data['penawaran'] = [];
      }

      $this->view($this->v_content, $data);
   }

   public function add()
   {
      $jumlah = $_POST['jumlah'];
      $tenor = $_POST['tenor'];
      $tujuan = $_POST['tujuan'];

      $cols = 'user, jumlah, tenor, tujuan';
      $vals = "'" . $this->userData['user'] . "'," . $jumlah . "," . $tenor . ",'" . $tujuan . "'";

      $do = $this->model('M_DB_1')->insertCols('pengajuan', $cols, $vals);
      if ($do['errno'] == 0) {
         $this->model('Log')->write($this->userData['user'] . " Pengajuan Success!");
         echo $do['errno'];
      } else {
         print_r($do['error']);
      }
   }

   public function terima()
   {
      $id = $_POST['id'];
      $id_ = $_POST['id_'];

      $set = "offer_id = " . $id_;
      $where = "id_pengajuan = " . $id;
      $update = $this->model('M_DB_1')->update("pengajuan", $set, $where);
      echo $update['errno'];
      $this->dataSynchrone();
   }

   public function terimaDana()
   {
      $id = $_POST['id'];
      $today = date("Y-m-d H:i:s");

      $set = "st_pinjaman = 2, activeDate = '" . $today . "'";

      $where = "id_pengajuan = '" . $id . "'";
      $update = $this->model('M_DB_1')->update("pengajuan", $set, $where);
      echo $update['errno'];
      $this->dataSynchrone();
   }
}
