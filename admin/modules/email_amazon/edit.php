<?
	include "inc_security.php";
	//Kiem tra quyen them sua xoa
	checkAddEdit("add");
	$record_id 		= getValue("record_id");

	$fs_action		=	"";
	$fs_errorMsg	=	"";

    $db_shop = new db_query('SELECT * FROM shop WHERE 1');
    $listShop = array();
    $listShop[0] = '-- Chọn cửa hàng --';
    while($shop = mysqli_fetch_assoc($db_shop->result)) {
        $listShop[$shop['sho_id']] = $shop['sho_name'];
    }
    unset($db_shop);

    $listRole = array();
    $listRole[0] = '-- Quyền quản trị --';
    $listRole[1] = 'Quản lý (Admin)';
    $listRole[2] = 'Nhân viên';


	$myform	=	new generate_form();
	$myform->removeHTML(0);

	$pass        =  strtolower(getValue("use_pass", "str", "POST", "", 1));
    $security = rand(0000,9999);
    $use_pass = md5($pass.$security);
	$myform->add("use_shop_id","sho_id",1,0,0,1,"Bạn chưa chọn cửa hàng",0,"");
	$myform->add('use_name', 'use_name', 0, 0, '', 1, 'bạn chưa nhập username', 1, 'User này đã tồn tại !Xin vui lòng chọn User khác');
	$myform->add('use_pass', 'use_pass', 0, 1, '', 1, 'Bạn chưa nhập password', 0, "");
    $myform->add('use_security', 'security', 0, 1, '', 1, '', 0, "");
	$myform->add('use_email','use_email', 0, 0, '', 1, 'Bạn chưa nhập Email', 1, 'Email này đã tồn tại ! xin vui lòng chọn Email khác');
	$myform->add('use_fullname','use_fullname', 0, 0, '', 0, '', 0, '');
	$myform->add('use_phone','use_phone', 0, 0, '', 0, '', 0, '');
	$myform->add('use_date','use_date', 1, 1, '', 0, '', 0, '');
	$myform->add("use_active","use_active", 1, 0, 0, 0,"",0,"");
    $myform->add("use_role","use_role",1,0,0,1,"Bạn chưa chọn cửa hàng",0,"");

	$myform->addTable($fs_table);

	$action			= getValue("action","str","POST","");
	if($action 		== 'execute'){
		$myform->removeHTML(0);
		//Check form data
		$fs_errorMsg .= $myform->checkdata($id_field, $record_id);

		if($fs_errorMsg == ""){
			$myform->addTable($fs_table);
			$db_insert 		= new db_execute($myform->generate_update_SQL($id_field, $record_id));
			redirect('listing.php');
		}
    }

	$myform->addFormname("add_new");
	$myform->evaluate();
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
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<?=$load_header?>
<? $myform->checkjavascript();?>
</head>
<body topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0">
<?=template_top(translate_text("Add merchant"))?>
	<img style="position: absolute; top: 50px; right: 50px;" width="100" height="100" border="0" src="<?=$fs_filepath?><?=$use_avatar?>" />
	<p align="center" style="padding-left:10px;">
		<?
		$form = new form();
		$form->create_form("add_new",$fs_action,"post","multipart/form-data","onsubmit='validateForm(); return false;'");
		$form->create_table();
		?>
		<?=$form->text_note('Những ô dấu sao (<font class="form_asterisk">*</font>) là bắt buộc phải nhập.')?>
		<? //Khai bao thong bao loi ?>
		<?=$form->errorMsg($fs_errorMsg)?>

		<?=$form->select("Cửa hàng", "sho_id", "sho_id", $listShop, $use_shop_id, "Chọn cửa hàng", 1, "", "", 0, "", "")?>
		<?=$form->text("Tên đăng nhập ", "use_name", "use_name", $use_name, "Tên đăng nhập", 1, 250)?>
		<?=$form->password("Mật khẩu", "use_pass", "use_pass", "", "Mật khẩu", 1, 250, "", 255, "", "", "")?>
		<?=$form->text("Email", "use_email", "use_email", $use_email, "Email", 1, 250)?>
		<?=$form->text("Tên đầy đủ", "use_fullname", "use_fullname", $use_fullname, "Tên đầy đủ", 0, 250)?>
		<?=$form->text("Điện thoại", "use_phone", "use_phone", $use_phone, "Số điện thoại", 0, 250)?>
        <?=$form->select("Quyền", "use_role", "use_role", $listRole, $use_role, "Chọn quyền quản lý", 1 , "", "", 0, "", "")?>
		<?=$form->checkbox("", "use_active", "use_active", 1, $use_active, "Active")?>

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