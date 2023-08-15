<?php

class Penawaran extends Controller
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
         "title" => "Pendanaan - Penawaran"
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

         $where = "user = '" . $this->userData['user'] . "' AND id_penawaran BETWEEN " . $min_oi . " AND " . $max_oi;
         $data['penawaran'] = $this->model("M_DB_1")->get_where("penawaran", $where);
      }
      $data['_c'] = __CLASS__;
      $this->view($this->v_content, $data);
   }

   public function resi_()
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

      $allowExt   = array('png', 'jpg', 'jpeg', 'PNG', 'JPG', 'JPEG');
      $uploads_dir = "files/ktp/" . $this->userData['id_user'] . "/";
      $uploads_dir_kk = "files/kk/" . $this->userData['id_user'] . "/";
      $file_name = date('His') . "_" . basename($_FILES['ktp']['name']);
      $file_name_kk = date('His') . "_" . basename($_FILES['kk']['name']);

      if (!file_exists($uploads_dir)) {
         mkdir($uploads_dir, 0777, TRUE);
      }

      $imageUploadPath =  $uploads_dir . '/' . $file_name;
      $fileType = pathinfo($imageUploadPath, PATHINFO_EXTENSION);

      $imageTemp = $_FILES['ktp']['tmp_name'];
      $fileSize   = $_FILES['ktp']['size'];

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

      $set = "v_profil = 1, ktp_path = '" . $uploads_dir . $file_name . "', kk_path = '" . $uploads_dir_kk . $file_name_kk . "'";
      $where = "id_user = " . $this->userData['id_user'];
      $query = $this->model('M_DB_1')->Update("user", $set, $where);
      echo $query['errno'];

      $this->dataSynchrone();
   }
}
