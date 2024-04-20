<?php

class Laundry extends Controller
{
   public function __construct()
   {
      $this->session_cek();
   }

   function transfer_cabang($cabang, $laundry_target)
   {
      //laundry target
      $set_laundry = "id_laundry = " . $laundry_target;

      //pindahkan cabang ke laundry
      $this->db(1)->update("cabang", $set_laundry, 'id_cabang = ' . $cabang);
      $this->db(1)->update("user", $set_laundry, 'id_cabang = ' . $cabang);
      $this->db(1)->update("operasi", $set_laundry, 'id_cabang = ' . $cabang);
      $this->db(1)->update("penjualan", $set_laundry, 'id_cabang = ' . $cabang);
   }

   function transfer_member($cabang, $id_harga_sumber, $id_harga_target)
   {
      $set = "id_harga = " . $id_harga_target;
      $where = "id_harga = " . $id_harga_sumber . " AND id_cabang = " . $cabang;
      $this->db(1)->update("penjualan", $set, $where);
      $this->db(1)->update("member", $set, $where);
   }
}
