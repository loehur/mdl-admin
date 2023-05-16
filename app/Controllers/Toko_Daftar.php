<?php

class Toko_Daftar extends Controller
{
   public $page = __CLASS__;

   public function __construct()
   {
      $this->session_cek();

      $this->data();

      if ($this->userData['user_tipe'] <> 0) {
         $this->logout();
      }

      $this->v_load = $this->page . "/load";
      $this->v_content = $this->page . "/content";
      $this->v_viewer = $this->page . "/viewer";
   }

   public function index()
   {
      $this->view("Layouts/layout_main", [
         "content" => $this->v_content,
         "title" => "Daftar Toko"
      ]);

      $this->viewer();
   }

   public function viewer()
   {
      $this->view($this->v_viewer, ["page" => $this->page]);
   }

   public function content()
   {

      $data = $this->model('M_DB_1')->get('toko');
      $this->view($this->v_content, $data);
   }

   public function load()
   {
      $this->view($this->v_load);
   }
}
