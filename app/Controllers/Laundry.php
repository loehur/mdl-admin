<?php

class Laundry extends Controller
{
   function transfer_cabang($cabang, $laundry_target)
   {
      //laundry target
      $set_laundry = "id_laundry = " . $laundry_target;

      //penjualan
      $where = "id_cabang = " . $cabang . " AND tuntas = 0";
      $penjualan = $this->db(1)->get_where("penjualan", $where);

      //pindahkan cabang ke laundry
      $this->db(1)->update("cabang", $set_laundry, 'id_cabang = ' . $cabang);
      $this->db(1)->update("user", $set_laundry, 'id_cabang = ' . $cabang);
      $this->db(1)->update("operasi", $set_laundry, 'id_cabang = ' . $cabang);

      foreach ($penjualan as $p) {
         $where_p = "id_penjualan = " . $p['id_penjualan'];

         //transfer penjualan ke laundry
         $this->db(1)->update("penjualan", $set_laundry, $where_p);
      }
   }
}
