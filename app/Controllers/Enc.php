<?php

class Enc extends Controller
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
         "title" => "E - 1 Way"
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
      echo $this->model('Encrypt')->enc($_POST['text']);
   }
}
