<?php

class Home extends Controller
{
   public $page = __CLASS__;

   public function __construct()
   {
      $this->v_load = $this->page . "/load";
      $this->v_content = $this->page . "/content";
      $this->v_viewer = $this->page . "/viewer";
   }

   function login()
   {
      if ($_POST['pin'] == "456987") {
         $_SESSION['secure']['encryption'] = "j499uL0v3ly&N3lyL0vEly_F0r3ver";
         echo "Login Success!";
      } else {
         echo "Login Failed!";
      }
   }

   function logout()
   {
      session_destroy();
   }

   public function index()
   {
      $this->view("Layouts/layout_main", [
         "content" => $this->v_content,
         "title" => $this->page
      ]);

      $this->viewer();
   }

   public function viewer()
   {
      $this->view($this->v_viewer, ["page" => $this->page]);
   }

   public function content()
   {
      $this->view($this->v_content);
   }
}
