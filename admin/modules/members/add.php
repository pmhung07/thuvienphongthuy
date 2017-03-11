<?
include("inc_security.php");
checkAddEdit("add");

//Khai báo biến khi thêm mới
$after_save_data	= getValue("after_save_data", "str", "POST", "add.php");
$add					= "add.php";
$listing				= "listing.php";
$fs_title			= "Add New Member";
$fs_action			= getURL();
$fs_redirect		= $after_save_data;
$fs_errorMsg		= "";
$use_security		= random();
$use_group			= 1;
$use_date			= time();
$use_active			= getValue("use_active", "int", "POST", 1);
$password			= getValue("use_password", "str", "POST", "");
if($password != ""){
	$use_password	= md5($password . $use_security);
}

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
//Call Class generate_form();
$myform = new generate_form();
$myform->add("use_login","use_login",0,0,"",1,"Bạn chưa nhập tên đăng nhập!",1,"Tên đăng nhập đã tồn tại!");
$myform->add("use_name","use_name",0,0,"",1,"Bạn chưa nhập họ và tên!",0,"");
$myform->add("use_password","use_password",0,1,"",1,"Bạn chưa nhập mật khẩu!",0,"");
$myform->addjavasrciptcode('if(document.getElementById("use_password").value != document.getElementById("comfim_password").value){ alert("'. translate('Mật khẩu và mật khẩu xác nhận không giống nhau !') .'"); document.getElementById("comfim_password").focus(); return false;}');
$myform->add("use_email","use_email",0,0,"",1,"Bạn chưa nhập địa chỉ email!",1,"Địa chỉ Email đã tồn tại !");
//$myform->add("use_birthdays","use_birthdays",1,1,0,0,"",0,"");
$myform->add("use_address","use_address",0,0,"",1,"Địa chỉ của bạn!",0,"");
$myform->add("use_phone","use_phone",0,0,"",1,"Số điện thoại của bạn?",0,"");
$myform->add("use_security","use_security",0,1,"",0,"",0,"");
$myform->add("use_active","use_active",1,1,1,0,"",0,"");
$myform->add("use_date","use_date",1,1,1,0,"",0,"");
$myform->addTable($fs_table);

//Get action variable for add new data
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
		$db_insert = new db_execute($myform->generate_insert_SQL());
		unset($db_insert);
		//Redirect after insert complate
		redirect($fs_redirect);
	}//End if($fs_errorMsg == "")
}//End if($action == "insert")
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<?=$load_header?>
<? 
//add form for javacheck
$myform->addFormname("add");

$myform->checkjavascript(); 
//chuyển các trường thành biến để lấy giá trị thay cho dùng kiểu getValue
$myform->evaluate();
$fs_errorMsg .= $myform->strErrorField;
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
   <?=$form->text_note('<strong style="textalign:center;">-- Thêm mới thành viên --</strong>')?>
	<?=$form->text_note('Những ô có dấu sao (<font class="form_asterisk">*</font>) là bắt buộc phải nhập.')?>
	<?=$form->errorMsg($fs_errorMsg)?>
   <?=$form->text("Họ và tên", "use_name", "use_name", $use_name, "Họ và tên", 1, 250, "", 255, "", "", "")?>
	<?=$form->text("Tên đăng nhập", "use_login", "use_login", $use_login, "Tên đăng nhập", 1, 250, "", 255, "", "", "")?>
	<?=$form->password("Mật khẩu", "use_password", "use_password", "", "Mật khẩu", 1, 250, "", 255, "", "", "")?>
	<?=$form->password("Xác nhận mật khẩu", "comfim_password", "comfim_password", "", "Xác nhận mật khẩu", 1, 250, "", 255, "", "", "")?>
	<?=$form->text("Email", "use_email", "use_email", $use_email, "Email", 1, 250, "", 255, "", "", "")?>
	<?//=$form->text("Ngày sinh nhật", "use_str_birthdays", "use_str_birthdays", $use_str_birthdays, "Ngày (dd/mm/yyyy)", 0, "", "", "", "",' onKeyPress="displayDatePicker(\'use_str_birthdays\', this);" onClick="displayDatePicker(\'use_str_birthdays\', this);" ', " <i>(Ví dụ: dd/mm/yyyy)</i>");?>
	<?//=$form->getFile("Ảnh đại diện", "avatar", "avatar", "Ảnh đại diện", 0, 40, "", "")?>
	<?=$form->textarea("Địa chỉ", "use_address", "use_address", $use_address, "Địa chỉ", 1, 252, 80, "", "", "")?>
	<?=$form->text("Điện thoại", "use_phone", "use_phone", $use_phone, "Điện thoại", 1, 250, "", 255, "", "", "")?>
	<?=$form->checkbox("Kích hoạt", "use_active", "use_active", 1, $use_active, "Kích hoạt", 0, "", "")?>
	<?=$form->radio("Sau khi lưu dữ liệu", "add_new" . $form->ec . "return_listing", "after_save_data", $add . $form->ec . $listing, $after_save_data, "Thêm mới" . $form->ec . "Quay về danh sách", 0, $form->ec, "");?>
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