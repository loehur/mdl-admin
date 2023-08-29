<?php

class Enc_2 extends Controller
{
   public function __construct()
   {
      $this->v_load = __CLASS__ . "/load";
      $this->v_content = __CLASS__ . "/content";
      $this->v_viewer = __CLASS__ . "/viewer";
   }

   public function index()
   {
      $this->view("Layouts/layout_main", [
         "content" => $this->v_content,
         "title" => "E - Enc"
      ]);

      $this->viewer();
   }

   public function viewer()
   {
      $this->view($this->v_viewer, ["page" => __CLASS__]);
   }

   public function content()
   {
      $data['_c'] = __CLASS__;
      $this->view($this->v_content, $data);
   }

   function enc_()
   {
      echo $this->model('Encrypt')->enc_2($_POST['text']);
   }
}
