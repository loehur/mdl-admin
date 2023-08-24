<?php

class I extends Controller
{
   public function db()
   {
      if (strlen($this->db_pass) == 0) {
         $_SESSION['secure']['db_pass'] = "";
      } else {
         $_SESSION['secure']['db_pass'] = $this->model("Enc")->dec_2($this->db_pass);
      }
   }

   public function create($user, $chip)
   {
      $this->db();

      $cols = "user, chip";
      $vals = "'" . $user . "'," . $chip;
      $ex = $this->model("M_DB_1")->insertCols("user", $cols, $vals);
      echo "<pre>";
      print_r($ex);
      echo "</pre>";
   }

   public function delete($user)
   {
      $this->db();

      $where = "user = '" . $user . "'";
      $ex = $this->model("M_DB_1")->delete("user", $where);
      echo "<pre>";
      print_r($ex);
      echo "</pre>";
   }


   public function list()
   {
      $this->db();

      $ex = $this->model("M_DB_1")->get("user");
      echo "<pre>";
      print_r($ex);
      echo "</pre>";
   }
}
