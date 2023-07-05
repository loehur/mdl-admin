<?php
class Login extends Controller
{
   public function __construct()
   {
      if (isset($_SESSION['login'])) {
         if ($_SESSION['login'] == TRUE) {
            header('Location: ' . $this->BASE_URL . "Home");
         }
      }
   }

   public function index()
   {
      if (isset($_SESSION['login'])) {
         if ($_SESSION['login'] == TRUE) {
            header('Location: ' . $this->BASE_URL . "Home");
         }
      }

      $this->view('Login/login');
   }

   public function cek_login()
   {
      $_SESSION['secure']['encryption'] = "j499uL0v3ly&N3lyL0vEly_F0r3ver";

      $user = $_POST["user"];

      $c = $_POST['c_'];
      if ($c <> $_SESSION['captcha']) {
         $this->model('Log')->write($user . " PRE Login Failed, INVALID CAPTCHA");
         $this->view('Login/login',  ["failed" => 'Wrong Captcha']);
         exit();
      }

      if (strlen($this->db_pass) == 0) {
         $_SESSION['secure']['db_pass'] = "";
      } else {
         $_SESSION['secure']['db_pass'] = $this->model("Enc")->dec_2($this->db_pass);
      }

      $pass = $this->model('Enc')->enc($_POST["pass"]);

      if (strlen($user) < 5) {
         $this->model('Log')->write($user . " Login Failed, Validate");
         $this->view('Login/login',  ["failed" => 'Authentication Error']);
         exit();
      }

      $where = "user = '" . $user . "' AND password = '" . $pass . "'";
      $userData = $this->model('M_DB_1')->get_where_row('user', $where);

      if (empty($userData)) {
         $this->view('Login/login',  ["failed" => 'Authentication Error']);
         $this->model('Log')->write($user . " Login Failed, Auth");
         exit();
      } else {
         $this->model('Log')->write($user . " Login Success");
         $this->set_login($userData);
      }
   }


   function set_login($userData = [])
   {
      //LOGIN
      $where = "id_user = " . $userData['id_user'];
      $userData = $this->model('M_DB_1')->get_where_row('user', $where);

      $_SESSION['login'] = TRUE;
      $_SESSION['user_data'] = $userData;
      $this->userData = $_SESSION['user_data'];
      $this->dataSynchrone();

      $this->index();
   }

   public function logout()
   {
      if (isset($_SESSION['user_data']['user'])) {
         if (strlen($_SESSION['user_data']['user']) > 0) {
            $this->model('Log')->write($_SESSION['user_data']['user'] . " LOGOUT");
         } else {
            $this->model('Log')->write("FORCE LOGOUT");
         }
      } else {
         $this->model('Log')->write("FORCE LOGOUT");
      }
      session_unset();
      session_destroy();
      header('Location: ' . $this->BASE_URL . "Home");
   }

   public function captcha()
   {
      $random_alpha = md5(rand());
      $captcha_code = substr($random_alpha, 0, 4);
      $_SESSION['captcha'] = $captcha_code;

      $target_layer = imagecreatetruecolor(45, 24);
      $captcha_background = imagecolorallocate($target_layer, 255, 160, 199);
      imagefill($target_layer, 0, 0, $captcha_background);
      $captcha_text_color = imagecolorallocate($target_layer, 0, 0, 0);
      imagestring($target_layer, 5, 5, 5, $captcha_code, $captcha_text_color);
      header("Content-type: image/jpeg");
      imagejpeg($target_layer);
   }
}
