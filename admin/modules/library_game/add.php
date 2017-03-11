<?
require_once("inc_security.php");
checkAddEdit("add");
   
//Khai bao Bien
$fs_title = $module_name . " | Thêm mới";
$add = "add.php";
$listing = "listing.php";
$after_save_data = getValue("after_save_data", "str", "POST", "add.php");
$tags            = getValue("lib_game_tags","str","POST",""); 
$title           = getValue("lib_game_title","str","POST","");
$info            = getValue("lib_game_info","str","POST","");
$lib_cat_id      = getValue("lib_cat_id","int","POST",0);   
$fs_redirect = $after_save_data;
$sql = "lib_cat_type = 1";
$menu 	= new menu();
$listAll = $menu->getAllChild("library_cate","lib_cat_id","lib_cat_parent_id","0",$sql . " AND lang_id = " . $lang_id . $sqlcategory,"lib_cat_id,lib_cat_name,lib_cat_order,lib_cat_type,lib_cat_parent_id,lib_cat_has_child","lib_cat_order ASC, lib_cat_name ASC","lib_cat_has_child");

//Call Class generate_form();
$myform = new generate_form();    
//Loại bỏ chuc nang thay the Tag Html
$myform->removeHTML(0);
$myform->add("lib_game_catid","lib_cat_id",0,0,"",1,"Bạn chưa chọn danh mục trò chơi",0,"");
$myform->add("lib_game_title","lib_game_title",0,0,"",1,"Bạn chưa nhập tên trò chơi",0,"");
$myform->add("lib_game_info","lib_game_info",0,0,"",1,"Bạn chưa nhập thông tin trò chơi",0,"");
$myform->add("meta_title","meta_title",0,0,"",0,"",0,"");
$myform->add("meta_description","meta_description",0,0,"",0,"",0,"");
$myform->add("meta_keywords","meta_keywords",0,0,"",0,"",0,"");
$myform->add("lib_game_tags","lib_game_tags",0,0,"",0,"",0,"");
//Add table
$myform->addTable($fs_table);
//Warning Error!
$fs_errorMsg = "";
//Get Action.
$action	= getValue("action", "str", "POST", "");
if($action == "execute"){
   //Check form data : kiêm tra lỗi
   $fs_errorMsg .= $myform->checkdata();
   if($fs_errorMsg == ""){
   	$upload_img = new upload("lib_game_image", $imgpath, $fs_extension, $fs_filesize);
      $upload_game = new upload("lib_game_url", $mediapath, $fs_extension, $fs_filesize);
              
   	$filename_img = $upload_img->file_name;
      $filename_game = $upload_game->file_name;   
      
      
      if($filename_img != ""){
         $myform->add("lib_game_image","filename_img",0,1,0,0);
         foreach($arr_resize as $type => $arr){
   		resize_image($imgpath, $filename_img, $arr["width"], $arr["height"], $arr["quality"], $type);
         }
      }
      
      if($filename_game != ""){
         $myform->add("lib_game_url","filename_game",0,1,0,0);
      }
      
      if($fs_errorMsg == ""){    
      	$myform->removeHTML(0);
         $db_insert = new db_execute_return();
         $last_id   = $db_insert->db_execute($myform->generate_insert_SQL());
         unset($db_insert);
         //Lưu tag cho game (Group type:4, type:1)
         if($tags == ''){
            $tags = gen_str_cate($lib_cat_id,'library_cate','lib_cat_id','lib_cat_parent_id','lib_cat_name');
         }
         save_tags($last_id,$tags,4,1);
      	redirect($fs_redirect);
      }
   }
}
$myform->addFormname("add_new");
$myform->evaluate();
$myform->checkjavascript();
$fs_errorMsg .= $myform->strErrorField;
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<?=$load_header?>
</head>
<body>
<?=template_top($fs_title)?>
   <p align="center" style="padding-left:10px;">
   <?
   $form = new form();
   $form->create_form("add", $_SERVER["REQUEST_URI"], "post", "multipart/form-data",'onsubmit="validateForm(); return false;"');
   $form->create_table();
   ?>
      <?=$form->text_note('<strong style="textalign:center;">-- Thêm mới thư viện Games --</strong>')?>
      <?=$form->text_note('Những ô dấu (<font class="form_asterisk">*</font>) là bắt buộc phải nhập.')?>
      <?=$form->errorMsg($fs_errorMsg)?>
      <?=$form->select_db_multi("Danh mục Game", "lib_cat_id", "lib_cat_id", $listAll, "lib_cat_id", "lib_cat_name", $lib_cat_id, "Chọn danh mục", 1, "", 1, 0, "", "")?>
      <?=$form->text("Tên trò chơi", "lib_game_title", "lib_game_title", $lib_game_title, "Tên trò chơi", 1, 272, "", 255, "", "", "")?>
      <?=$form->textarea("Thông tin trò chơi","lib_game_info","lib_game_info",$lib_game_info,"Thông tin trò chơi",0,274,100,"","","")?>
      <?=$form->getFile("Ảnh trò chơi", "lib_game_image", "lib_game_image", "Ảnh trò chơi", 0, 30, "", "")?>
      <?=$form->getFile("Tải trò chơi", "lib_game_url", "lib_game_url", "Tải trò chơi", 0, 30, "", "")?>
      <?=$form->text("Title", "meta_title", "meta_title", $meta_title, "Title", 0, 450, 24, 255, "", "", "")?>
      <?=$form->text("Description", "meta_description", "meta_description", $meta_description, "Description", 0, 450, 24, 255, "", "", "")?>
      <?=$form->text("Keywords", "meta_keywords", "meta_keywords", $meta_keywords, "Keywords", 0, 450,24, 255, "", "", "")?>
      <?=$form->text("Tags", "lib_game_tags", "lib_game_tags", $lib_game_tags, "Tags", 0, 450,24, 255, "", "", "<span  style=\"color: red;padding-left: 10px;\" >(Các từ khóa viết thường, cách nhau bằng dấu \",\")</span>")?>
      <?=$form->radio("Sau khi lưu dữ liệu", "add_new" . $form->ec . "return_listing", "after_save_data", $add . $form->ec . $listing, $after_save_data, "Thêm mới" . $form->ec . "Quay về danh sách", 0, $form->ec, "");?>
      <?=$form->button("submit" . $form->ec . "reset", "submit" . $form->ec . "reset", "submit" . $form->ec . "reset", "Cập nhật" . $form->ec . "Làm lại", "Cập nhật" . $form->ec . "Làm lại", 'style="background:url(' . $fs_imagepath . 'button_1.gif) no-repeat"' . $form->ec . 'style="background:url(' . $fs_imagepath . 'button_2.gif)"', "");?>
      <?=$form->hidden("action", "action", "execute", "");?>
   <?
   $form->close_table();
   $form->close_form();
   unset($form);
   ?>
   </p>
<?=template_bottom() ?>
</body>
</html>