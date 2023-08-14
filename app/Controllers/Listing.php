<?php

class Listing extends Controller
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

   public function index($p1 = 0)
   {
      if ($p1 == 1) {
         $this->view("Layouts/layout_main", [
            "content" => $this->v_content,
            "title" => "Marketplace - Terpenuhi"
         ]);
      } else {
         $p1 = 0;
         $this->view("Layouts/layout_main", [
            "content" => $this->v_content,
            "title" => "Marketplace - Penawaran"
         ]);
      }

      $this->viewer($p1);
   }

   public function viewer($p1)
   {
      $this->view($this->v_viewer, ["page" => $this->page, "p1" => $p1]);
   }

   public function content($p1)
   {
      $data['_c'] = __CLASS__;
      if ($p1 == 0) {
         $data['pengajuan'] = $this->model("M_DB_1")->get_where("pengajuan", "st_pinjaman = 1");
      }

      $this->view($this->v_content, $data);
   }

   public function tawar()
   {
      $id = $_POST['id_pengajuan'];
      $bunga = $_POST['bunga'];

      $cols = 'user, id_pengajuan, bunga';
      $vals = "'" . $this->userData['user'] . "'," . $id . "," . $bunga;

      $cek = 0;
      $cek = $this->model("M_DB_1")->count_where("penawaran", "id_pengajuan = " . $id . " AND user = '" . $this->userData['user'] . "'");
      if ($cek == 0) {
         $do = $this->model('M_DB_1')->insertCols('penawaran', $cols, $vals);
         if ($do['errno'] == 0) {
            $this->model('Log')->write($this->userData['user'] . " Penawaran Success!");
            echo $do['errno'];
         } else {
            print_r($do['error']);
         }
      } else {
         echo "Anda sudah memberikan Penawaran";
      }
   }
}
