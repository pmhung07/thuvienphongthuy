<?
require_once("inc_security.php");
//check quy?n them sua xoa
checkAddEdit("edit");

//Khai bao Bien
   $fs_redirect = base64_decode(getValue("url","str","GET",base64_encode("listing.php")));
	$record_id = getValue("record_id");

   //Khai bao mang kieu bai hoc chinh 
   $kles_media_type = getValue("kles_media_type","int","POST",0);
   
   $myform 	= new generate_form();
   //Loại bỏ chuc nang thay the Tag Html
   $myform->removeHTML(0);
   $myform->add("kles_title","kles_title",0,0,"",1,translate_text("Bạn chưa nhập tiêu đề"),0,"");
   $myform->add("kles_desc","kles_desc",0,0,"",1,translate_text("Bạn chưa nhập mô tả"),0,"");
   $myform->add("kles_media_type","kles_media_type",1,0,0,0,translate_text("Bạn chưa chọn dạng media"),0,"");
   if($kles_media_type == 1){
      $myform->add("kles_media_content","kles_media_content",0,0,"",1,translate_text("Bạn chưa nhập mô tả"),0,"");
   }
	//Add table
	$myform->addTable("kids_lessons");
	//Warning Error!
	$fs_errorMsg = "";
	//Get Action.
	$action	= getValue("action", "str", "POST", "");
    if($action == "execute"){
      $fs_errorMsg .= $myform->checkdata();
      if($fs_errorMsg == ""){
         $upload1		    = new upload("kles_media_content", $imgpath, $fs_extension, $fs_filesize);       
      	$filename1	= $upload1->file_name;    
         $arr_file = array('content' => $filename1);
         $get_ar_filename = json_encode($arr_file);
         if($filename1 != ""){
            $myform->add("kles_media_content","get_ar_filename",0,1,0,0);
            foreach($arr_resize as $type => $arr){
      		resize_image($imgpath, $filename1, $arr["width"], $arr["height"], $arr["quality"], $type);
            }
         }
         $fs_errorMsg .= $upload1->show_warning_error();
         if($fs_errorMsg == ""){
      		$myform->removeHTML(0);//loại bỏ  các ký tự html( 0 thi ko loại bỏ, 1: bỏ) tránh lỗi 
      		$db_insert = new db_execute($myform->generate_update_SQL("kles_id",$record_id));
            unset($db_insert);       			
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
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<?=$load_header?>
<? 
$errorMsg = "";
$myform->checkjavascript();
$errorMsg .= $myform->strErrorField;

//lay du lieu cua record can sua doi
$db_data 	= new db_query("SELECT * FROM kids_lessons  WHERE kles_id = " . $record_id);
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
<?=template_top(translate_text("Edit_detail"))?>
<table border="0" cellpadding="3" cellspacing="0" class="tablelist formdetail" width="90%">
<?php $form = new form();
$form->create_form("add", $_SERVER["REQUEST_URI"], "post", "multipart/form-data",'onsubmit="validateForm(); return false;"');
?>
<?=$form->text_note('Những ô dấu (<font class="form_asterisk">*</font>) là bắt buộc phải nhập.')?>
<?=$form->errorMsg($fs_errorMsg)?>
<? //media type = 1 (Url) , 2 (Video) , 3 (Flash) ?>
<?=$form->radio("<font class='form_asterisk'>*</font> Chọn kiểu media","kles_media_type","kles_media_type",1,$kles_media_type,"URL",0,"","")?>
<?=$form->radio("","kles_media_type","kles_media_type",2,$kles_media_type,"Video",0,"","")?>
<?=$form->radio("","kles_media_type","kles_media_type",3,$kles_media_type,"Flash",0,"","")?>
<?=$form->getFile("Media 1", "kles_media_content", "kles_media_content", "Media cho Bài học chính", 0, 30, "", "")?>
<?=$form->text("URL", "kles_media_content", "kles_media_content", $kles_media_content, "",0, 250, 24, 255, "", "", "")?>
<?=$form->text("Tiêu đề", "kles_title", "kles_title", $kles_title, "",0, 250, 24, 255, "", "", "")?>
<?=$form->textarea("Mô tả", "kles_desc", "kles_desc", $kles_desc, "",0, 300, 50, 255, "", "", "")?>
<?=$form->button("submit" . $form->ec . "reset", "submit" . $form->ec . "reset", "submit" . $form->ec . "reset", "Cập nhật" . $form->ec . "Làm lại", "Cập nhật" . $form->ec . "Làm lại", 'style="background:url(' . $fs_imagepath . 'button_1.gif) no-repeat"' . $form->ec . 'style="background:url(' . $fs_imagepath . 'button_2.gif)"', "");?>
<?=$form->hidden("action", "action", "execute", "");?>
<?
$form->close_form();
unset($form);
?>
</table>

<?=template_bottom() ?>
<? /*------------------------------------------------------------------------------------------------*/ ?>
</body>
</html>