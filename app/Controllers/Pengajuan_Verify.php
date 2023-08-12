<?php

class Pengajuan_Verify extends Controller
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
         "title" => "Admin - Pengajuan"
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
      $data['pinjaman'] = $this->model("M_DB_1")->get_where("pengajuan", "st_pinjaman = 0");
      $this->view($this->v_content, $data);
   }

   function cek($id)
   {
      $data = $this->model("M_DB_1")->get_where("user", "user = '" . $id . "'");
      $this->view($this->page . "/cek", $data);
   }

   public function submit()
   {
      $user = $_POST['user'];
      $opsi = $_POST['opsi'];
      $note = $_POST['note'];

      $today = date("Y-m-d H:i:s");

      if ($opsi == 1) {
         $set = "st_note = '" . $note . "', st_pinjaman = '" . $opsi . "', listDate = '" . $today . "'";
      } else {
         $set = "st_note = '" . $note . "', st_pinjaman = '" . $opsi . "', endDate = '" . $today . "'";
      }
      $where = "user = '" . $user . "'";
      $update = $this->model('M_DB_1')->update("pengajuan", $set, $where);
      echo $update['errno'];
      $this->dataSynchrone();
   }
}
