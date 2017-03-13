<?
/*
 * Category Class
 * author: hieulvt128@gmail.com
 */
Class category{

   var $cat_id;
   var $cat_name;
   var $cat_desc;
   var $cat_pictures;
   var $cat_order;
   var $cat_parent_id;
   var $cat_type;
   var $cat_view;
   var $cat_view_test;
   var $cat_active;
   var $cat_link = '';

   function category($id = 0){
      $db_cat  = new db_query('SELECT * FROM categories_multi WHERE cat_id = '.$id.' AND cat_active = 1');
      $row_cat = mysqli_fetch_assoc($db_cat->result);

      $this->cat_id              = $row_cat['cat_id'];
      $this->cat_name            = $row_cat['cat_name'];
      $this->cat_desc            = $row_cat['cat_description'];
      $this->cat_picture         = $row_cat['cat_picture'];
      $this->cat_order           = $row_cat['cat_order'];
      $this->cat_parent_id       = $row_cat['cat_parent_id'];
      $this->cat_type            = $row_cat['cat_type'];
      $this->cat_view            = $row_cat['cat_view'];
      $this->cat_view_test       = $row_cat['cat_view_test'];
      $this->cat_active          = $row_cat['cat_active'];
      $this->cat_link            = gen_course_cate_v3($row_cat['cat_id']);
      unset($row_cat);
      unset($db_cat);
   }

   //Lấy ra thông tin của cate cha ( Ko có cha thì trả về rỗng );
   public function get_parent(){
      if($this->cat_parent_id == 0){
         return null;
      }else{
         $parent     = array();
         $db_parent  = new db_query('SELECT * FROM categories_multi WHERE cat_id = '.$this->cat_parent_id);
         $row_parent = mysqli_fetch_assoc($db_parent->result);
         $parent['cat_id']           =  $row_parent['cat_id'];
         $parent['cat_name']         =  $row_parent['cat_name'];
         $parent['cat_desc']         =  $row_parent['cat_description'];
         $parent['cat_picture']      =  $row_parent['cat_picture'];
         $parent['link']             =  gen_course_cate_v3($row_parent['cat_id']);

         return $parent;
      }
   }

   //Lấy ra thông tin của danh sách cate con ( Ko có con thì trả về rỗng );
   public function get_children(){
      $children = array();
      $db_child = new db_query('SELECT * FROM categories_multi WHERE cat_parent_id = '.$this->cat_id.' AND cat_active = 1 ORDER BY cat_order ASC');
      while($row_child = mysqli_fetch_assoc($db_child->result)){
         array_push($children,array('cat_id'       => $row_child['cat_id'],
                                    'cat_name'     => $row_child['cat_name'],
                                    'cat_desc'     => $row_child['cat_description'],
                                    'cat_picture'  => $row_child['cat_picture'],
                                    'link'         => gen_course_cate_v3($row_child['cat_id'])));
      }
      unset($row_child);
      unset($db_child);

      return $children;
   }
}
?>