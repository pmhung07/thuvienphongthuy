<?
include("inc_security.php");
checkAddEdit("edit");

   $fs_title			= $module_name . " | Sửa đổi";
   $fs_action			= getURL();
   $fs_errorMsg		= "";
   
   $fs_redirect 	= base64_decode(getValue("url","str","GET",base64_encode("listing.php")));
   $record_id 		= getValue("record_id");
   $id_field      = "tec_id";
   $tec_typ_id    = getValue("tec_typ_id"); 
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
   $myform->add("iecon_name", "iecon_name", 0, 0, "", 1, "Bạn chưa nhập tiêu đề audio", 0, "");
   $myform->add("iecon_content", "iecon_content", 0, 0, "", 1, "Bạn chưa nhập nội dung", 0, "");
   $myform->add("iecon_order", "iecon_order", 1, 0, 0, 0, "", 0, "");
   $myform->addTable("ielt_content");
   $action	= getValue("action", "str", "POST", "");
   if($action == "execute"){
   $upload_img	= new upload("iecon_image", $image_path, $fs_extension_img, $fs_filesize);
   $filename_img	= $upload_img->file_name;
      if($filename_img != ""){
      	$myform->add("iecon_image","filename_img",0,1,0,0);
      	foreach($arr_resize as $type => $arr){
   	      resize_image($image_path, $filename_img, $arr["width"], $arr["height"], $arr["quality"], $type);
      	}
      }
   	$fs_errorMsg .= $myform->checkdata();      
   	if($fs_errorMsg == ""){          	
   		$myform->removeHTML(0);
   		$db_ex = new db_execute($myform->generate_update_SQL("iecon_id", $record_id));
   		redirect($fs_redirect);
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
$db_data 	= new db_query("SELECT * FROM ielt_content WHERE iecon_id = " . $record_id);
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
      <?=$form->text("Tiêu đề", "iecon_name", "iecon_name", $iecon_name, "Tiêu đề audio", 1, 272, "", 255, "", "", "")?>
      <tr>
      <td></td>
      <td><?=$form->wysiwyg("<font class='form_asterisk'>*</font> Nội dung", "iecon_content", $iecon_content, "../../resource/wysiwyg_editor/", 800, 250)?></td>
      </tr>
      <?=$form->getFile("Tải Ảnh", "iecon_image", "iecon_image", "Tải ảnh", 0, 30, "", "")?>
      <?=$form->text("Thứ tự", "iecon_order", "iecon_order", $iecon_order, "Thứ tự", 0, 40, "", 255, "", "", "")?>
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