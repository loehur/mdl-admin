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
      $penghasilan = $_POST['penghasilan'];
      $provinsi = $_POST['prov'];
      $kota = $_POST['kota'];
      $kec = $_POST['kecamatan'];
      $kel = $_POST['kelurahan'];
      $alamat = $_POST['alamat'];
      $hp = $_POST['hp'];

      $pass_enc = $this->model('Enc')->enc($pass);

      $cols = 'user, nama, penghasilan, provinsi, kota, kecamatan, kelurahan, alamat, password, hp, user_tipe';
      $vals = "'" . $user . "','" . $nama . "'," . $penghasilan . "," . $provinsi . "," . $kota . "," . $kec . ",'" . $kel . "','" . $alamat . "','" . $pass_enc . "','" . $hp . "',2";

      $do = $this->model('M_DB_1')->insertCols('user', $cols, $vals);
      if ($do['errno'] == 0) {
         $this->model('Log')->write($user . " Register Success!");
         echo $do['errno'];
      } else {
         print_r($do['error']);
      }
   }
}
