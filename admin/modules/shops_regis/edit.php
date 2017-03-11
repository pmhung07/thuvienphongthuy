<?
include("inc_security.php");
checkAddEdit("edit");

$fs_redirect 	= base64_decode(getValue("url","str","GET",base64_encode("listing.php")));
$record_id 	= getValue("record_id");

//Khai báo biến khi thêm mới
$fs_title			= "Edit Member";
$fs_action			= getURL();
$fs_errorMsg		= "";

$use_security		= random();
$use_group			= 1;
$use_date			= time();
$use_active			= getValue("use_active", "int", "POST", 1);
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

$myform->add("use_name","use_name",0,0,"",1,"Họ và tên của bạn!",0,"");
$myform->add("use_address","use_address",0,0,"",1,"Địa chỉ của bạn!",0,"");
$myform->add("use_phone","use_phone",0,0,"",1,"Số điện thoại của bạn?",0,"");
$myform->add("use_security","use_security",0,1,"",0,"",0,"");
$myform->add("use_active","use_active",1,1,1,0,"",0,"");
$myform->add("use_date","use_date",1,1,1,0,"",0,"");
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
		$upload			= new upload($fs_fieldupload, $fs_filepath, $fs_extension, $fs_filesize, $fs_insert_logo);
		$filename		= $upload->file_name;
		
		$fs_errorMsg	.= $upload->warning_error;
	}
	
	if($fs_errorMsg == ""){
		if($filename != ""){
			$$fs_fieldupload = $filename;
			$myform->add($fs_fieldupload, $fs_fieldupload, 0, 1, "", 0, "", 0, "");
			// resize
			$upload->resize_image($fs_filepath, $filename, $width_small_image, $height_small_image, "small_");
			$upload->resize_image($fs_filepath, $filename, $width_normal_image, $height_normal_image, "normal_");

		}//End if($filename != "")
		
		//Insert to database
		$myform->removeHTML(0);
		$db_update = new db_execute($myform->generate_update_SQL($id_field, $record_id));
		unset($db_update);
		
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
if($row 		= mysql_fetch_assoc($db_data->result)){
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
<?=template_top(translate_text("Edit member"))?>
<p align="center" style="padding-left:10px;">
<?
$form = new form();
$form->create_form("edit", $fs_action, "post", "multipart/form-data",'onsubmit="validateForm(); return false;"');
$form->create_table();
?>
<?=$form->text_note('<strong>-- Thay đổi thông tin thành viên --</strong>')?>
<?=$form->errorMsg($fs_errorMsg)?>
<?=$form->text("Họ và tên", "use_name", "use_name", $use_name, "Họ và tên", 1, 250, "", 255, "", "", "")?>
<?=$form->textarea("Địa chỉ", "use_address", "use_address", $use_address, "Địa chỉ", 1, 252, 80, "", "", "")?>
<?=$form->text("Điện thoại", "use_phone", "use_phone", $use_phone, "Điện thoại", 1, 250, "", 255, "", "", "")?>
<?=$form->checkbox("Kích hoạt", "use_active", "use_active", 1, $use_active, "Kích hoạt", 0, "", "")?>
<?=$form->button("submit" . $form->ec . "reset", "submit" . $form->ec . "reset", "submit" . $form->ec . "reset", "Cập nhật" . $form->ec . "Làm lại", "Cập nhật" . $form->ec . "Làm lại", 'style="background:url(' . $fs_imagepath . 'button_1.gif) no-repeat"' . $form->ec . 'style="background:url(' . $fs_imagepath . 'button_2.gif)"', "");?>
<?=$form->hidden("action", "action", "execute", "");?>
<?
$form->close_table();
$form->close_form();
unset($form);
?>
</p>
<?=template_bottom() ?>
<? /*------------------------------------------------------------------------------------------------*/ ?>
</body>
</html>