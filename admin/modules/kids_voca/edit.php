<?
   include("inc_security.php");
   checkAddEdit("add");

   $fs_title = $module_name . " | Thêm mới";
   $fs_action = getURL();
   $fs_errorMsg = "";
   $add = "add.php";
   $listing = "listing.php";
   $after_save_data = getValue("after_save_data", "str", "POST", "listing.php");
   $fs_redirect = $after_save_data;     
   $sqlCourse	= new db_query("SELECT * FROM kids_vcb_lessons");  
   while($rowC = mysql_fetch_array($sqlCourse->result)){
      $cou_id = $rowC['kvcb_id'];
   }
   $record_id = getValue("record_id");
    /*
	Call class form:
	1). Ten truong
	2). Ten form 
	3). Kieu du lieu , 0 : string , 1 : kieu int, 2 : kieu email, 3 : kieu double, 4 : kieu hash password
	4). Noi luu giu data  0 : post(sẽ tìm trong form ở dưới có cotrol nào có name đc khai báo ở (2)), 1 : variable (sẽ tìm những biến nào có tên đã đc khai báo ở (2) )
	5). Gia tri mac dinh, neu require thi phai lon hon hoac bang default
	6). Du lieu nay co can thiet hay khong (tương ứng với bên form bên dưới)
	7). Loi dua ra man hinh nếu mà ko nhập
	8). Chi co duy nhat trong database (0: cho phép trùng ; 1: ko cho phép)
	9). Loi dua ra man hinh neu co duplicate
	*/
   //tạo mới class generate_form 
   $myform = new generate_form();
   $myform -> removeHTML(0);
   $myform->add("kvcb_ent_title", "kvcb_ent_title", 0, 0, "", 1, "Bạn chưa nhập tên của Unit", 0, "");
   $myform->addTable("kids_vcb_entries");
   $fs_errorMsg = "";
   $action	= getValue("action", "str", "POST", "");
	if($action == "execute"){
   	$fs_errorMsg .= $myform->checkdata();      
      if($fs_errorMsg == ""){
         $upload		= new upload("kvcb_ent_audio", $mediapath, $fs_extension, $fs_filesize);  
         $filename	= $upload->file_name;
		 $myform->add("kvcb_ent_audio","filename",0,1,0,0);
         $fs_errorMsg .= $upload->show_warning_error(); 	     
         if($fs_errorMsg == ""){
         	$myform->removeHTML(0);
         	$db_update = new db_execute($myform->generate_update_SQL("kvcb_ent_id", $record_id));
            unset($db_update);
         	redirect($fs_redirect);
         }
      }
   }
    $myform->addFormname("add_new");
	$myform->evaluate();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<?=$load_header?>
<?
$myform->checkjavascript();
$fs_errorMsg .= $myform->strErrorField;
//lay du lieu cua record can sua doi
$db_data 	= new db_query("SELECT * FROM kids_vcb_entries WHERE kvcb_ent_id = " . $record_id);
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
  
	$form->create_form("add", $fs_action, "post", "multipart/form-data",'onsubmit="validateForm(); return false;"');
   $form->create_table();
	?>
   <?=$form->text_note('<strong style="text-align:center;">----------Thêm mới Unit-----------</strong>')?>
   <?=$form->text_note('Những ô có dấu sao (<font class="form_asterisk">*</font>) là bắt buộc phải nhập.')?>
   <?=$form->errorMsg($fs_errorMsg)?>	 
   <?=$form->text("Ví dụ", "kvcb_ent_title", "kvcb_ent_title", $kvcb_ent_title, "Ví dụ", 1, 250, 24, 255, "", "", "")?>
   <?=$form->getFile("Audio", "kvcb_ent_audio", "kvcb_ent_audio", "Chọn audio", 1, 40, "", "")?>
   <tr>
   	<td></td>
    <td><?=$row['kvcb_ent_audio']?></td>
   </tr>
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