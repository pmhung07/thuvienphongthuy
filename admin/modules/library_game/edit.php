<?
include("inc_security.php");
checkAddEdit("edit");

$after_save_data	= getValue("after_save_data", "str", "POST", "add.php");
$add					= "add.php";
$listing				= "listing.php";

$fs_redirect 	   = base64_decode(getValue("url","str","GET",base64_encode("listing.php")));
$record_id 	      = getValue("record_id");
$tags             = getValue("lib_game_tags","str","POST","");

//Khai báo biến khi thêm mới
$fs_title			= "Edit Library Game";
$fs_action			= getURL();
$fs_errorMsg		= "";

$use_security		= random();
$use_group			= 1;
$use_date			= time();
$use_active			= getValue("use_active", "int", "POST", 1);

$sql = "lib_cat_type = 1";
$menu 	= new menu();
$listAll = $menu->getAllChild("library_cate","lib_cat_id","lib_cat_parent_id","0",$sql . " AND lang_id = " . $lang_id . $sqlcategory,"lib_cat_id,lib_cat_name,lib_cat_order,lib_cat_type,lib_cat_parent_id,lib_cat_has_child","lib_cat_order ASC, lib_cat_name ASC","lib_cat_has_child");

/*
Call class form:
1). Ten truong
2). Ten form
3). Kieu du lieu , 0 : string , 1 : kieu int, 2 : kieu email, 3 : kieu double, 4 : kieu hash password
4). Noi luu giu data  0 : post, 1 : variable
5). Gia tri mac dinh, neu require thi phai lon hon hoac bang default
6). Du lieu nay co can thiet hay khong
7). Loi dua ra man hinh
8). Chi co duy nhat trong database
9). Loi dua ra man hinh neu co duplicate
*/
$myform = new generate_form();

$myform->removeHTML(0);
$myform->add("lib_game_catid","lib_cat_id",0,0,"",1,"Bạn chưa chọn danh mục trò chơi",0,"");
$myform->add("lib_game_title","lib_game_title",0,0,"",1,"Tiêu đề trò chơi",0,"");
$myform->add("lib_game_info","lib_game_info",0,0,"",1,"Thông tin trò chơi",0,"");
$myform->add("meta_title","meta_title",0,0,"",0,"",0,"");
$myform->add("meta_description","meta_description",0,0,"",0,"",0,"");
$myform->add("meta_keywords","meta_keywords",0,0,"",0,"",0,"");
$myform->add("lib_game_tags","lib_game_tags",0,0,"",0,"",0,"");
$myform->addTable($fs_table);

///Get action variable for add new data
$action				= getValue("action", "str", "POST", "");
//Check $action for insert new data
if($action == "execute"){
	$use_active			= getValue("use_active", "int", "POST", 0);

	//Check form data
	$fs_errorMsg .= $myform->checkdata();

	//Get $filename and upload
	$filename	= "";
	if($fs_errorMsg == ""){
      $upload_img = new upload("lib_game_image", $imgpath, $fs_extension, $fs_filesize);
      $upload_game = new upload("lib_game_url", $mediapath, $fs_extension, $fs_filesize);

      $filename_img = $upload_img->file_name;
      $filename_game = $upload_game->file_name;

		$fs_errorMsg	.= $upload_img->warning_error;
      $fs_errorMsg	.= $upload_game->warning_error;
	}

	if($fs_errorMsg == ""){
		if($filename_img != ""){
	      delete_file("library_game","lib_game_id",$record_id,"lib_game_image",$imgpath);
			$myform->add("lib_game_image","filename_img",0,1,0,0);
         foreach($arr_resize as $type => $arr){
   		resize_image($imgpath, $filename_img, $arr["width"], $arr["height"], $arr["quality"], $type);
         }
		}//End if($filename != "")

      if($filename_game != ""){
         delete_file("library_game","lib_game_id",$record_id,"lib_game_url",$mediapath);
			$myform->add("lib_game_url","filename_game",0,1,0,0);
		}//End if($filename != "")

		//Insert to database
		$myform->removeHTML(0);
		$db_update = new db_execute($myform->generate_update_SQL($id_field, $record_id));
		unset($db_update);
		//Lưu tag cho game (Group type:4, type:1)
      if($tags != '') save_tags($record_id,$tags,4,1);
		//Redirect after insert complate
		redirect($fs_redirect);

	}//End if($fs_errorMsg == "")

}//End if($action == "execute")
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<?=$load_header?>
<?
//chuyển các trường thành biến để lấy giá trị thay cho dùng kiểu getValue
$myform->addFormname("edit");
$myform->checkjavascript();
$myform->evaluate();
$fs_errorMsg .= $myform->strErrorField;

//lay du lieu cua record can sua doi
$db_data 	= new db_query("SELECT * FROM " . $fs_table . " WHERE " . $id_field . " = " . $record_id);
if($row 		= mysqli_fetch_assoc($db_data->result)){
	foreach($row as $key=>$value){
		if($key!='lang_id' && $key!='admin_id') $$key = $value;
	}
}else{
		exit();
}

?>
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

      <?=$form->select_db_multi("Danh mục Game", "lib_cat_id", "lib_cat_id", $listAll, "lib_cat_id", "lib_cat_name", $row['lib_game_catid'], "Chọn danh mục", 1, "", 1, 0, "", "")?>
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