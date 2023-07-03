<?php

class Log extends Controller
{
   public $page = __CLASS__;

   public function __construct()
   {
      $this->session_cek();
      $this->data();

      if (!in_array($this->userData['user_tipe'], $this->pMaster)) {
         $this->model('Log')->write($this->userData['user'] . " Force Logout. Hacker!");
         $this->logout();
      }
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
         $update = $this->model('M_DB_1')->update("user", $set, $where);
         $this->dataSynchrone();
      }
   }
}
