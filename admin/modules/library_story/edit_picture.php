<?
include("inc_security.php");
checkAddEdit("edit");

   $fs_title			= $module_name . " | Sửa đổi";
   $fs_action			= getURL();
   $fs_errorMsg		= "";
   
   $fs_redirect 	= base64_decode(getValue("url","str","GET",base64_encode("listing.php")));
   $record_id 		= getValue("record_id");
   $story_id      = getValue("story_id","int","GET",0);
   $id_field      = "img_id"; 

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
   $myform->add("img_translate", "img_translate", 0, 0, "", 1, "Bạn chưa nhập bản dịch", 0, "");
   $myform->add("img_order", "img_order", 1, 0, 0, 0, "", 0, "");
   //Add table insert data
   $myform->addTable("images_story");
   //Get action variable for add new data
   $action				= getValue("action", "str", "POST", "");
   //Check $action for insert new data
   if($action == "execute"){
   	//Check form data
   	$fs_errorMsg .= $myform->checkdata();      
   	if($fs_errorMsg == ""){
   	  
   		$upload = new upload("img_url", $imgpath_more_pic, $fs_extension, $fs_filesize );
   		$filename = $upload->file_name;
   		if($filename != ""){
            delete_file("images_story","img_id",$record_id,"img_url",$imgpath_more_pic);
   			$myform->add("img_url","filename", 0, 1, "", 0);
   			foreach($arr_resize as $type=>$arr){
   				resize_image($imgpath_more_pic, $filename, $arr["width"], $arr["height"], $arr["quality"], $type);
   			}
   		}
   		//Insert to database
   		$myform->removeHTML(0);
   		$db_ex = new db_execute($myform->generate_update_SQL($id_field, $record_id));
         echo("<script>alert('Sửa thành công');	window.location.reload();</script>");
   		
   	}//End if($fs_errorMsg == "")
   	
   }//End if($action == "insert")
   
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
$db_data 	= new db_query("SELECT * FROM images_story WHERE img_id = " . $record_id);
if($row 		= mysql_fetch_assoc($db_data->result)){
   foreach($row as $key=>$value){
   	if($key!='lang_id' && $key!='admin_id') $$key = $value;
   }
}else{
		exit();
}

?>
</head>
<body>
<? /*------------------------------------------------------------------------------------------------*/ ?>
<?=template_top($fs_title)?>
<? /*------------------------------------------------------------------------------------------------*/ ?>
   <p align="center" style="padding-left:10px;">
   	<?
   	$form = new form();
   	$form->create_form("add", $_SERVER['REQUEST_URI'], "post", "multipart/form-data",'onsubmit="validateForm(); return false;"');
   	$form->create_table();
   	?>
   	<?=$form->text_note('Những ô có dấu sao (<font class="form_asterisk">*</font>) là bắt buộc phải nhập.')?>
		<?=$form->errorMsg($fs_errorMsg)?>
   	<?=$form->getFile("Ảnh", "img_url", "img_url", "Ảnh minh họa", 1, 30, "", "")?>
   	<?=$form->textarea("Bản dịch", "img_translate", "img_translate", $img_translate, "Bản dịch", 0, 300, 40, 255, "", "", "")?>
      <?=$form->text("Thứ tự", "img_order", "img_order", $img_order, "Thứ tự", 0, 40, "", 255, "", "", "")?>
   	<?=$form->button("submit" . $form->ec . "reset", "submit" . $form->ec . "reset", "submit" . $form->ec . "reset", "Cập nhật" . $form->ec . "Đóng cửa sổ", "Cập nhật" . $form->ec . "Đóng cửa sổ", 'style="background:url(' . $fs_imagepath . 'button_1.gif) no-repeat"' . $form->ec . 'style="background:url(' . $fs_imagepath . 'button_2.gif)" onclick="window.parent.tb_remove()"', "");?>
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