<?php

class Pencairan_Verify extends Controller
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
         "title" => "Admin - Pencairan"
      ]);

      $this->viewer();
   }

   public function viewer()
   {
      $this->view($this->v_viewer, ["page" => $this->page]);
   }

   public function content()
   {
      $where = "offer_id <> 0 AND st_pinjaman = 1";
      $data['pinjaman'] = $this->model("M_DB_1")->get_where("pengajuan", $where);

      $offer_id = array_column($data['pinjaman'], 'offer_id');
      if (count($offer_id) > 0) {
         $min_oi = min($offer_id);
         $max_oi = max($offer_id);

         $where = "id_penawaran BETWEEN " . $min_oi . " AND " . $max_oi;
         $data['penawaran'] = $this->model("M_DB_1")->get_where("penawaran", $where);
      }
      $data['_c'] = __CLASS__;
      $this->view($this->v_content, $data);
   }

   public function struk()
   {
      function compressImage($source, $destination, $quality)
      {
         $imgInfo = getimagesize($source);
         $mime = $imgInfo['mime'];
         switch ($mime) {
            case 'image/jpeg':
               $image = imagecreatefromjpeg($source);
               break;
            case 'image/png':
               $image = imagecreatefrompng($source);
               break;
            case 'image/gif':
               $image = imagecreatefromgif($source);
               break;
            default:
               $image = imagecreatefromjpeg($source);
         }

         imagejpeg($image, $destination, $quality);
         return $destination;
      }

      $id_pengajuan = $_POST['id_pengajuan'];

      $allowExt   = array('png', 'jpg', 'jpeg', 'PNG', 'JPG', 'JPEG');
      $uploads_dir = "files/struk_cair/" . date("Y-m") . "/";
      $file_name = $id_pengajuan . "_" . basename($_FILES['struk_cair']['name']);
      if (!file_exists($uploads_dir)) {
         mkdir($uploads_dir, 0777, TRUE);
      }

      $imageUploadPath =  $uploads_dir . '/' . $file_name;
      $fileType = pathinfo($imageUploadPath, PATHINFO_EXTENSION);
      $imageTemp = $_FILES['struk_cair']['tmp_name'];
      $fileSize   = $_FILES['struk_cair']['size'];

      if (in_array($fileType, $allowExt) === true) {
         if ($fileSize < 10000000) {
            if ($fileSize > 1000000) {
               compressImage($imageTemp, $imageUploadPath, 20);
            } else {
               move_uploaded_file($imageTemp, $imageUploadPath);
            }
         } else {
            echo "FILE BIGGER THAN 10MB FORBIDDEN";
            exit();
         }
      } else {
         echo "FILE EXT/TYPE FORBIDDEN";
         exit();
      }

      $set = "struk_path = '" . $uploads_dir . $file_name . "'";
      $where = "id_pengajuan = " . $id_pengajuan;
      $query = $this->model('M_DB_1')->Update("pengajuan", $set, $where);
      echo $query['errno'];

      $this->dataSynchrone();
   }

   public function opsi()
   {
      $opsi = $_POST['opsi'];
      $today = date("Y-m-d H:i:s");
      $id_pengajuan = $_POST['id_pengajuan'];

      if ($opsi == 2) {
         $set = "st_pinjaman = '" . $opsi . "', activeDate = '" . $today . "'";
      } else {
         $set = "st_pinjaman = '" . $opsi . "', endDate = '" . $today . "'";
      }
      $where = "id_pengajuan = '" . $id_pengajuan . "'";
      $update = $this->model('M_DB_1')->update("pengajuan", $set, $where);
      echo $update['errno'];
      $this->dataSynchrone();
   }
}
