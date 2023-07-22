<?php

class Rekening extends Controller
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
         "title" => "Profil - Rekening"
      ]);

      $this->viewer();
   }

   public function viewer()
   {
      $this->view($this->v_viewer, ["page" => $this->page]);
   }

   public function content()
   {
      $this->dataSynchrone();
      $this->data();

      $data['bank'] = $this->model("M_DB_1")->get("_bank");
      $data['_c'] = __CLASS__;
      $this->view($this->v_content, $data);
   }

   public function update()
   {
      $bank = $_POST['bank'];
      $rek = $_POST['rek'];

      $set = "bank = '" . $bank . "', rekening = '" . $rek . "', v_bank = 1";
      $where = "user = '" . $this->userData['user'] . "'";
      $update = $this->model('M_DB_1')->update("user", $set, $where);
      echo $update['errno'];
      $this->dataSynchrone();
   }
}
