<?php

class Room extends Controller
{
   public $page = __CLASS__;

   public function __construct()
   {
      $this->v_content = $this->page . "/content";
      $this->v_viewer = $this->page . "/viewer";
   }

   public function i($user)
   {
      $_SESSION['user'] = $user;
      $this->viewer();
   }

   public function viewer()
   {
      $this->view($this->v_viewer, ["page" => $this->page]);
   }

   public function saldo()
   {
      $where = "user = '" . $_SESSION['user'] . "'";
      $awal =  $this->model("M_DB_1")->get_cols_where("user", "chip", $where, 0)['chip'];

      $cols = "SUM(chip) AS chip";
      $where = "f = '" . $_SESSION['user'] . "' GROUP BY f";
      $m =  $this->model("M_DB_1")->get_cols_where("mutasi", $cols, $where, 0);
      if (isset($m['chip'])) {
         $mutasi = $m['chip'];
      } else {
         $mutasi = 0;
      }

      $cols = "SUM(chip) AS chip";
      $where = "t = '" . $_SESSION['user'] . "' GROUP BY t";
      $m =  $this->model("M_DB_1")->get_cols_where("mutasi", $cols, $where, 0);
      if (isset($m['chip'])) {
         $mutasi -= $m['chip'];
      }

      return ($awal - $mutasi);
   }

   public function saldo_f($user)
   {
      $where = "user = '" . $user . "'";
      $awal =  $this->model("M_DB_1")->get_cols_where("user", "chip", $where, 0)['chip'];

      $cols = "SUM(chip) AS chip";
      $where = "f = '" . $user . "' GROUP BY f";
      $m =  $this->model("M_DB_1")->get_cols_where("mutasi", $cols, $where, 0);
      if (isset($m['chip'])) {
         $mutasi = $m['chip'];
      } else {
         $mutasi = 0;
      }

      $cols = "SUM(chip) AS chip";
      $where = "t = '" .  $user . "' GROUP BY t";
      $m =  $this->model("M_DB_1")->get_cols_where("mutasi", $cols, $where, 0);
      if (isset($m['chip'])) {
         $mutasi -= $m['chip'];
      }

      return ($awal - $mutasi);
   }

   public function content()
   {
      $data['chip'] = $this->saldo();
      $data['friend'] = $this->model("M_DB_1")->get_where("user", "user <> '" . $_SESSION['user'] . "'");
      foreach ($data['friend'] as $k => $df) {
         $data['friend'][$k]['chip'] = $this->saldo_f($df['user']);
      }
      $this->view($this->v_content, $data);
   }

   public function transfer()
   {
      $c = $_POST['c'];
      $t = $_POST['t'];
      $f = $_SESSION['user'];
      $cols = "f, t, chip";
      $vals = "'" . $f . "','" . $t . "'," . $c;
      $ex = $this->model("M_DB_1")->insertCols("mutasi", $cols, $vals);
      echo $ex['errno'];
   }
}
