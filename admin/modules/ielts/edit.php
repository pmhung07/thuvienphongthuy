<?
include("inc_security.php");
checkAddEdit("edit");

$fs_title			= $module_name . " | Sửa đổi";
$fs_action			= getURL();
$fs_errorMsg		= "";

$fs_redirect 	= base64_decode(getValue("url","str","GET",base64_encode("listing.php")));
$record_id 		= getValue("record_id");
$cat_id        = getValue("cat_id");
$tags          = getValue("ielt_tags","str","POST","");
$sql = '1';
$menu 	= new menu();
$listAll   = $menu->getAllChild("categories_multi","cat_id","cat_parent_id","0",$sql . " AND lang_id = " . $lang_id . $sqlcategory,"cat_id,cat_name,cat_order,cat_type,cat_parent_id,cat_has_child","cat_order ASC, cat_name ASC","cat_has_child");
//Call class menu - lay ra danh sach Category

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
   //$datetime =  date("Y-m-d g:i:s");
   $myform = new generate_form();
   $myform->add("ielt_name", "ielt_name", 0, 0, "", 1, "Bạn chưa nhập tên của đề thi", 0, "Đề thi này đã có trong cơ sở dữ liệu!");
   $myform->add("ielt_cat_id","cat_id",1,0,0,1,"Bạn chưa chọn danh mục",0,"");
   $myform->add("ielt_active","ielt_active",1,0,0,0,"",0,"");
	$myform->add("ielt_tags","ielt_tags",0,0,"",0,"",0,"");
	//Add table insert data
	$myform->addTable($fs_table);
   //Get action variable for add new data
   $action				= getValue("action", "str", "POST", "");
   //Check $action for insert new data
   if($action == "execute"){
   	//Check form data
   	$fs_errorMsg .= $myform->checkdata();
   	if($fs_errorMsg == ""){
   		$upload = new upload("ielt_image", $imgpath, $fs_extension, $fs_filesize );
   		$filename = $upload->file_name;
   		if($filename != ""){
	         delete_file($fs_table,$id_field,$record_id,"ielt_image",$imgpath);
   			$myform->add("ielt_image","filename", 0, 1, "", 0);
   			foreach($arr_resize as $type=>$arr){
   				resize_image($imgpath, $filename, $arr["width"], $arr["height"], $arr["quality"], $type);
   			}
   		}
   		//Insert to database
   		$myform->removeHTML(0);
   		$db_ex = new db_execute($myform->generate_update_SQL($id_field, $record_id));
         //Lưu tag cho đề thi ielts (Group type:3, type:3)
         if($tags != '') save_tags($record_id,$tags,3,3);
   		//Redirect to:
   		redirect($fs_redirect);
         unset($db_ex);
   	}
   }
   $myform->addFormname("add_new");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<?=$load_header?>
<?
$myform->checkjavascript();
//chuyển các trường thành biến để lấy giá trị thay cho dùng kiểu getValue
$myform->evaluate();
$fs_errorMsg .= $myform->strErrorField;
//lay du lieu cua record can sua doi
$db_data 	= new db_query("SELECT * FROM ielts WHERE " . $id_field . " = " . $record_id);
if($row 		= mysqli_fetch_assoc($db_data->result)){
   foreach($row as $key=>$value){
   	if($key!='lang_id' && $key!='admin_id') $$key = $value;
   }
}else{
		exit();
}

?>
</head>
<body topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0">
<? /*------------------------------------------------------------------------------------------------*/ ?>
<?=template_top($fs_title)?>
<? /*------------------------------------------------------------------------------------------------*/ ?>
   <p align="center" style="padding-left:10px;">
   <?
   $form = new form();
   $form->create_form("add", $fs_action, "post", "multipart/form-data",'onsubmit="validateForm(); return false;"');
   $form->create_table();
   ?>
   <?=$form->text_note('<strong style="text-align:center;">----------Sửa đổi Đề thi-----------</strong>')?>
   <?=$form->text_note('Những ô có dấu sao (<font class="form_asterisk">*</font>) là bắt buộc phải nhập.')?>
   <?=$form->errorMsg($fs_errorMsg)?>
   <?=$form->text("Tên đề thi", "ielt_name", "ielt_name", $ielt_name, "Tên đề thi", 1, 250, "", 255, "", "", "")?>
  	<?=$form->select_db_multi("Danh mục", "cat_id", "cat_id", $listAll, "cat_id", "cat_name", $ielt_cat_id, "Chọn danh mục", 1, "", 1, 0, "", "")?>
   <?=$form->getFile("Hình ảnh", "ielt_image", "ielt_image", "Chọn hình ảnh", 0, 40, "", "")?>
   <?=$form->text("Tags", "ielt_tags", "ielt_tags", $ielt_tags, "Tags", 0, 450,24, 255, "", "", "<span  style=\"color: red;padding-left: 10px;\" >(Các từ khóa viết thường, cách nhau bằng dấu \",\")</span>")?>
   <?=$form->checkbox("Kích hoạt", "ielt_active", "ielt_active", 1 ,$ielt_active, "",0, "", "")?>
   <?=$form->button("submit" . $form->ec . "reset", "submit" . $form->ec . "reset", "submit" . $form->ec . "reset", "Cập nhật" . $form->ec . "Làm lại", "Cập nhật" . $form->ec . "Làm lại", 'style="background:url(' . $fs_imagepath . 'button_1.gif) no-repeat"' . $form->ec . 'style="background:url(' . $fs_imagepath . 'button_2.gif)"', "");?>
   <?=$form->hidden("action", "action", "execute", "");?>
   <?
   $form->close_table();
   $form->close_form();
   unset($form);
   ?>
   </p>
<? /*------------------------------------------------------------------------------------------------*/ ?>
<?=template_bottom() ?>
<? /*------------------------------------------------------------------------------------------------*/ ?>
</body>
</html>