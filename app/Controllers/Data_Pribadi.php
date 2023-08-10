<?php

class Data_Pribadi extends Controller
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
         "title" => "Profil - Data Pribadi"
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
      $data['_c'] = __CLASS__;
      $this->view($this->v_content, $data);
   }

   public function ktp()
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

      if (!file_exists($uploads_dir_kk)) {
         mkdir($uploads_dir_kk, 0777, TRUE);
      }

      $imageUploadPath_kk =  $uploads_dir_kk . '/' . $file_name_kk;
      $fileType_kk = pathinfo($imageUploadPath_kk, PATHINFO_EXTENSION);

      $imageTemp_kk = $_FILES['kk']['tmp_name'];
      $fileSize_kk   = $_FILES['kk']['size'];

      if (in_array($fileType_kk, $allowExt) === true) {
         if ($fileSize_kk < 10000000) {
            if ($fileSize_kk > 1000000) {
               compressImage($imageTemp_kk, $imageUploadPath_kk, 20);
            } else {
               move_uploaded_file($imageTemp_kk, $imageUploadPath_kk);
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
