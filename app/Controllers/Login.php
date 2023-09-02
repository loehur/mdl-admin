<?php
class Login extends Controller
{
   public function index()
   {
      $m = date('i');
      if (isset($_SESSION['otp_log'])) {
         $otp = $_SESSION['otp_log'];
         if ($otp['v'] == $m && $otp['send'] == false) {
            $_SESSION['otp_log']['send'] = true;
            $this->model("WA")->send($otp['hp'], $otp['code']);
         }
      }

      if (isset($_SESSION['login'])) {
         if ($_SESSION['login'] == TRUE) {
            header('Location: ' . $this->BASE_URL . "Home");
         } else {
            $data['_c'] = __CLASS__;
            $this->view('Login/login', $data);
         }
      } else {
         $data['_c'] = __CLASS__;
         $this->view('Login/login', $data);
      }
   }

   public function cek_login()
   {
      $hp = $_POST["hp"];
      $otp = $_POST["otp"];
      $c = $_POST['c_'];
      $msg = "Gagal:";

      if ($c == $_SESSION['captcha'] && $_SESSION['otp_log']['code'] == $otp) {
         $c = $this->db()->get_where_row("user", "hp = '" . $hp . "'");
         if ($c <> false) {
            $_SESSION['secure']['encryption'] = "j499uL0v3ly&N3lyL0vEly_F0r3ver";
            $this->model('Log')->write($hp . " Login Success");
            $_SESSION['login'] = TRUE;
            $_SESSION['user'] = array(
               "hp" => $hp,
               "nama" => $c['nama'],
               "id_laundry" => $c['id_laundry'],
               "id_sale" => $c['id_sale'],
               "id_payment" => $c['id_payment']
            );
         } else {
            $msg .= " HP";
         }
      }

      if ($c <> $_SESSION['captcha']) {
         $msg .= " CAPTCHA";
      }
      if ($_SESSION['otp_log']['code'] <> $otp) {
         $msg .= " OTP";
      }

      header("Location: Login?msg=" . $msg);
   }

   public function logout()
   {
      session_destroy();
      header('Location: ' . $this->BASE_URL . "Login");
   }

   function otp()
   {
      $no = $_POST['hp'];
      $count = $this->db()->count_where("user", "hp = '" . $no . "'");

      if ($count == 1) {
         $m = date('i');
         $_SESSION['otp_log'] = array(
            "v" => $m,
            "hp" => $no,
            "code" =>  rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9),
            "send" => false
         );
      }
   }

   public function captcha()
   {
      $captcha_code = rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9);
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
