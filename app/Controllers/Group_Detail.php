<?php

class Group_Detail extends Controller
{
   public $page = __CLASS__;

   public function __construct()
   {
      $this->session_cek();

      $this->data();

      if ($this->userData['user_tipe'] > 1) {
         $this->model('Log')->write($this->userData['user'] . " Force Logout. Hacker!");
         $this->logout();
      }

      $this->v_load = $this->page . "/load";
      $this->v_content = $this->page . "/content";
      $this->v_viewer = $this->page . "/viewer";
   }

   public function index()
   {
      $this->view("Layouts/layout_main", [
         "content" => $this->v_content,
         "title" => "Produksi - Group Detail"
      ]);

      $this->viewer();
   }

   public function viewer()
   {
      $this->view($this->v_viewer, ["page" => $this->page]);
   }

   public function content()
   {

      $where = "id_toko = " . $this->userData['id_toko'];
      $data = $this->model('M_DB_1')->get_where('detail_group', $where);

      foreach ($data as $key => $d) {
         $where = "id_detail_group = " . $d['id_detail_group'] . " ORDER BY item_name ASC";
         $data_item = $this->model('M_DB_1')->get_where('detail_item', $where);
         $data[$key]['item'] = $data_item;
      }

      // echo "<pre>";
      // print_r($data[0]['item']);
      // echo "</pre>";

      $this->view($this->v_content, $data);
   }

   public function load()
   {
      $this->view($this->v_load);
   }

   function add()
   {
      $group = $_POST['group'];
      $cols = 'id_toko, detail_group';
      $vals = "'" . $this->userData['id_toko'] . "','" . $group . "'";

      $whereCount = "id_toko = '" . $this->userData['id_toko'] . "' AND detail_group = '" . $group . "'";
      $dataCount = $this->model('M_DB_1')->count_where('detail_group', $whereCount);
      if ($dataCount <> 1) {
         $do = $this->model('M_DB_1')->insertCols('detail_group', $cols, $vals);
         if ($do['errno'] == 0) {
            $this->model('Log')->write($this->userData['user'] . " Add Detail Group Success!");
            echo $do['errno'];
         } else {
            print_r($do['error']);
         }
      } else {
         $this->model('Log')->write($this->userData['user'] . " Add Detail Group Failed, Double Forbidden!");
         echo "Double Entry!";
      }
      $this->index();
   }

   function add_item($id_detail_group)
   {
      $item_post = $_POST['item'];
      $varian = $_POST['varian'];
      $cols = 'id_toko, id_detail_group, item_name';

      if (strlen($varian) > 0) {
         $varian = explode(",", $varian);
         foreach ($varian as $v) {
            $item = $item_post . " " . $v;
            $vals = "'" . $this->userData['id_toko'] . "','" . $id_detail_group . "','" . $item . "'";
            $whereCount = "id_toko = '" . $this->userData['id_toko'] . "' AND id_detail_group = '" . $id_detail_group . "' AND item_name = '" . $item . "'";
            $dataCount = $this->model('M_DB_1')->count_where('detail_item', $whereCount);
            if ($dataCount == 0) {
               $do = $this->model('M_DB_1')->insertCols('detail_item', $cols, $vals);
               if ($do['errno'] == 0) {
                  $this->model('Log')->write($this->userData['user'] . " Add Detail Item Success!");
                  echo $do['errno'];
               } else {
                  print_r($do['error']);
               }
            } else {
               $this->model('Log')->write($this->userData['user'] . " Add Detail Item Failed, Double Forbidden!");
               echo "Double Entry!";
            }
         }
      } else {
         $item = $item_post;
         $vals = "'" . $this->userData['id_toko'] . "','" . $id_detail_group . "','" . $item . "'";
         $whereCount = "id_toko = '" . $this->userData['id_toko'] . "' AND id_detail_group = '" . $id_detail_group . "' AND item_name = '" . $item . "'";
         $dataCount = $this->model('M_DB_1')->count_where('detail_item', $whereCount);
         if ($dataCount == 0) {
            $do = $this->model('M_DB_1')->insertCols('detail_item', $cols, $vals);
            if ($do['errno'] == 0) {
               $this->model('Log')->write($this->userData['user'] . " Add Detail Item Success!");
               echo $do['errno'];
            } else {
               print_r($do['error']);
            }
         } else {
            $this->model('Log')->write($this->userData['user'] . " Add Detail Item Failed, Double Forbidden!");
            echo "Double Entry!";
         }
      }
      $this->index();
   }

   function add_item_multi($id_detail_group)
   {
      $item_post = $_POST['item'];
      $cols = 'id_toko, id_detail_group, item_name';

      if (strlen($item_post) > 0) {
         $item = explode(",", $item_post);
         foreach ($item as $i) {
            $vals = "'" . $this->userData['id_toko'] . "','" . $id_detail_group . "','" . $i . "'";
            $whereCount = "id_toko = '" . $this->userData['id_toko'] . "' AND id_detail_group = '" . $id_detail_group . "' AND item_name = '" . $i . "'";
            $dataCount = $this->model('M_DB_1')->count_where('detail_item', $whereCount);
            if ($dataCount == 0) {
               $do = $this->model('M_DB_1')->insertCols('detail_item', $cols, $vals);
               if ($do['errno'] == 0) {
                  $this->model('Log')->write($this->userData['user'] . " Add Detail Item Success!");
                  echo $do['errno'];
               } else {
                  print_r($do['error']);
               }
            } else {
               $this->model('Log')->write($this->userData['user'] . " Add Detail Item Failed, Double Forbidden!");
               echo "Double Entry!";
            }
         }
      } else {
         $item = $item_post;
         $vals = "'" . $this->userData['id_toko'] . "','" . $id_detail_group . "','" . $item . "'";
         $whereCount = "id_toko = '" . $this->userData['id_toko'] . "' AND id_detail_group = '" . $id_detail_group . "' AND item_name = '" . $item . "'";
         $dataCount = $this->model('M_DB_1')->count_where('detail_item', $whereCount);
         if ($dataCount == 0) {
            $do = $this->model('M_DB_1')->insertCols('detail_item', $cols, $vals);
            if ($do['errno'] == 0) {
               $this->model('Log')->write($this->userData['user'] . " Add Detail Item Success!");
               echo $do['errno'];
            } else {
               print_r($do['error']);
            }
         } else {
            $this->model('Log')->write($this->userData['user'] . " Add Detail Item Failed, Double Forbidden!");
            echo "Double Entry!";
         }
      }
      $this->index();
   }
}
