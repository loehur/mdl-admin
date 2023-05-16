<?php

class Log extends Controller
{
   public $page = __CLASS__;

   public function __construct()
   {
      $this->session_cek();
      $this->data();
   }

   public function sync()
   {
      $this->dataSynchrone();
      $this->data();
   }

   function change_toko($id)
   {
      if ($this->userData['user_tipe'] == 0) {
         $where = "id_user = " . $this->userData['id_user'];
         $set = "id_toko = " . $id;
         print_r($this->model('M_DB_1')->update("user", $set, $where));
      }
   }
}
