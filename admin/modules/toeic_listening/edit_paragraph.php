<?
include("inc_security.php");
checkAddEdit("edit");

   $fs_title			= $module_name . " | Sửa đổi";
   $fs_action			= getURL();
   $fs_errorMsg		= "";

   $fs_redirect 	= base64_decode(getValue("url","str","GET",base64_encode("listing.php")));
   $record_id 		= getValue("record_id");
   $id_field      = "iecon_id";
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

   $time_audio_minute	= getValue("time_audio_minute", "int", "POST", 0);
   $time_audio_second	= getValue("time_audio_second", "int", "POST", 0);
   $time_audio_minute_cv = $time_audio_minute * 60;
   $total_audio_time = $time_audio_minute_cv + $time_audio_second;

   $myform = new generate_form();
   $myform->add("iecon_name", "iecon_name", 0, 0, "", 1, "Bạn chưa nhập tiêu đề audio", 0, "");
   $myform->add("iecon_order", "iecon_order", 1, 0, 0, 0, "", 0, "");
   $myform->add("iecon_time_audio", "total_audio_time", 1, 1, 0, 0, "", 0, "");
   $myform->addTable("ielt_content");
   $action	= getValue("action", "str", "POST", "");
   if($action == "execute"){
   	$fs_errorMsg .= $myform->checkdata();
   	if($fs_errorMsg == ""){

        //upload audio
   	   $upload		= new upload("iecon_audio", $data_path, $fs_extension, $fs_filesize);
   		$filename	= $upload->file_name;
         if($filename != ""){
            delete_file("ielt_content",$id_field,$record_id,"iecon_audio",$data_path);
      		$myform->add("iecon_audio","filename",0,1,0,0);
   		}

      	$fs_errorMsg .= $upload->show_warning_error();
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
if($row 		= mysqli_fetch_assoc($db_data->result)){
   foreach($row as $key=>$value){
   	if($key!='lang_id' && $key!='admin_id') $$key = $value;
   }
}else{
		exit();
}

if($iecon_time_audio > 0){
   $tec_audio_second = $iecon_time_audio % 60;
   $tec_audio_minute = ($iecon_time_audio - $tec_audio_second)/60;
}else{
   $tec_audio_second = 0;
   $tec_audio_minute = 0;
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
      <?=$form->getFile("Tải Audio", "iecon_audio", "iecon_audio", "Tải audio", 0, 30, "", "")?>
      <tr>
         <td>Thời gian audio (nếu có):</td>
         <td>
            <input id="time_audio_minute" name="time_audio_minute" value="<?=$tec_audio_minute?>" type="text" class="time_audio_minute"/> minutes
            <input id="time_audio_second" name="time_audio_second" value="<?=$tec_audio_second?>" type="text" class="time_audio_second"/> seconds
            <span style="color: #717F89;">(Ví dụ : mm/ss)</span>
         </td>
      </tr>
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