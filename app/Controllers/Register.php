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

      $m = date('i');
      if (isset($_SESSION['otp'])) {
         $otp = $_SESSION['otp'];
         if ($otp['v'] == $m && $otp['send'] == false) {
            $_SESSION['otp']['send'] = true;
            //$this->model("WA")->send($otp['hp'], $otp['code']);
         }
      }

      $this->view($this->page . '/register', $data);
   }

   public function add()
   {
      echo "Register ditutup!";
      exit();
      $hp = $_POST['hp'];
      $nama = $_POST['nama'];
      $otp = $_POST['otp'];

      if (isset($_SESSION['otp']) && $otp == $_SESSION['otp']['code']) {
         $cols = 'hp, nama';
         $vals = "'" . $hp . "','" . $nama . "'";

         $do = $this->db()->insertCols('user', $cols, $vals);
         if ($do['errno'] == 0) {
            $this->model('Log')->write($hp . " " . $hp . " Register Success!");
            echo $do['errno'];
         } else {
            print_r($do['error']);
         }
      } else {
         echo "OTP tidak valid";
      }
   }

   function otp()
   {
      $no = $_POST['hp'];
      $m = date('i');
      $_SESSION['otp'] = array(
         "v" => $m,
         "hp" => $no,
         "code" =>  rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9),
         "send" => false
      );

      print_r($_SESSION['otp']);
   }
}
