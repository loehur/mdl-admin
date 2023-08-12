<?php
class Register extends Controller
{
   public $page = __CLASS__;

   public function index()
   {
      if (isset($_SESSION['login'])) {
         if ($_SESSION['login'] == TRUE) {
            header('Location: ' . $this->BASE_URL . "Home");
         }
      }

      $data['_c'] = $this->page;
      $data['prov'] = $this->model('M_DB_1')->get('_provinsi');
      $data['bank'] = $this->model("M_DB_1")->get("_bank");
      $this->view($this->page . '/register', $data);
   }

   public function load_kota($provinsi)
   {
      $data['_c'] = $this->page;

      $where = "id_provinsi = " . $provinsi;
      $data['kot'] = $this->model('M_DB_1')->get_where('_kota', $where);
      $this->view($this->page . '/kota', $data);
   }

   public function load_kecamatan($parse)
   {
      $data['_c'] = $this->page;

      $where = "id_kota = " . $parse;
      $data['data'] = $this->model('M_DB_1')->get_where('_kecamatan', $where);
      $this->view($this->page . '/kecamatan', $data);
   }


   public function load_kelurahan($parse)
   {
      $data['_c'] = $this->page;

      $where = "id_kecamatan = '" . $parse . "'";
      $data['data'] = $this->model('M_DB_1')->get_where('_kelurahan', $where);

      if (count($data['data']) > 0) {
         $this->view($this->page . '/kelurahan', $data);
      }
   }

   public function add()
   {
      $pass = $_POST['pass'];
      $pass_ = $_POST['pass_'];

      if ($pass <> $pass_) {
         echo "Password tidak cocok!";
         exit();
      }

      if (!isset($_POST['kelurahan'])) {
         echo "Lengkapi Data terlebih dahulu!";
         exit();
      }

      $user = $_POST['user'];
      $nama = $_POST['nama'];
      $darurat = $_POST['darurat'];
      $provinsi = $_POST['prov'];
      $kota = $_POST['kota'];
      $kec = $_POST['kecamatan'];
      $kel = $_POST['kelurahan'];
      $alamat = $_POST['alamat'];
      $hp = $_POST['hp'];
      $nik = $_POST['nik'];
      $bank = $_POST['bank'];
      $rek = $_POST['rek'];
      $pass_enc = $this->model('Enc')->enc($pass);

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

      $file_inputName = "ktp";
      $uploads_dir = "files/" . $file_inputName . "/" . $nik . "/";
      $file_name = date('His') . "_" . basename($_FILES[$file_inputName]['name']);
      if (!file_exists($uploads_dir)) {
         mkdir($uploads_dir, 0777, TRUE);
      }
      $imageUploadPath =  $uploads_dir . '/' . $file_name;
      $allowExt   = array('png', 'jpg', 'jpeg', 'PNG', 'JPG', 'JPEG');
      $fileType = pathinfo($imageUploadPath, PATHINFO_EXTENSION);
      $imageTemp = $_FILES[$file_inputName]['tmp_name'];
      $fileSize   = $_FILES[$file_inputName]['size'];
      $path_upload[$file_inputName] = $uploads_dir . $file_name;
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

      $file_inputName = "kk";
      $uploads_dir = "files/" . $file_inputName . "/" . $nik . "/";
      $file_name = date('His') . "_" . basename($_FILES[$file_inputName]['name']);
      if (!file_exists($uploads_dir)) {
         mkdir($uploads_dir, 0777, TRUE);
      }
      $imageUploadPath =  $uploads_dir . '/' . $file_name;
      $allowExt   = array('png', 'jpg', 'jpeg', 'PNG', 'JPG', 'JPEG');
      $fileType = pathinfo($imageUploadPath, PATHINFO_EXTENSION);
      $imageTemp = $_FILES[$file_inputName]['tmp_name'];
      $fileSize   = $_FILES[$file_inputName]['size'];
      $path_upload[$file_inputName] = $uploads_dir . $file_name;
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


      $cols = 'user, nama, darurat, provinsi, kota, kecamatan, kelurahan, alamat, password, hp, user_tipe, nik, v_profil, v_bank, ktp_path, kk_path, bank, rekening';
      $vals = "'" . $user . "','" . $nama . "'," . $darurat . "," . $provinsi . "," . $kota . "," . $kec . ",'" . $kel . "','" . $alamat . "','" . $pass_enc . "','" . $hp . "',2,'" . $nik . "',1,1,'" . $path_upload['ktp'] . "','" . $path_upload['kk'] . "','" . $bank . "','" . $rek . "'";

      $do = $this->model('M_DB_1')->insertCols('user', $cols, $vals);
      if ($do['errno'] == 0) {
         $this->model('Log')->write($user . " Register Success!");
         echo $do['errno'];
      } else {
         print_r($do['error']);
      }
   }
}
