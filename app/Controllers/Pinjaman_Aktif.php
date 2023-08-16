<?php

class Pinjaman_Aktif extends Controller
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
         "title" => "Pinjaman - Aktif"
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
      $where = "user = '" . $this->userData['user'] . "' AND st_pinjaman = 2";
      $data['aktif'] = $this->model("M_DB_1")->get_where("pengajuan", $where);
      $this->view($this->v_content, $data);
   }
}
