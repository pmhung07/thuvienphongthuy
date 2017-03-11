<?
require_once("inc_security.php");
//check quy?n them sua xoa
checkAddEdit("edit");
$fs_title = $module_name . " | Sửa";
   //Khai bao Bien
   $errorMsg = "";
   $fs_redirect = base64_decode(getValue("returnurl","str","GET",base64_encode("listdetail.php")));
   $record_id = getValue("record_id");
   $myform = new generate_form();
    
	//Loại bỏ chuc nang thay the Tag Html
   $myform->removeHTML(0);
   $myform->add("lec_text","lec_text",0,0,"",0,translate_text("Vui lòng nhập nghĩa tiếng việt của ngữ pháp"),0,"");
   $myform->add("lec_media_type","lec_media_type",1,0,"",1,translate_text("Vui lòng chọn dạng media cho phần Grammar"),0,"");
   $myform->add("lec_order", "lec_order", 1, 0, 0, 0, "", 0, "");
   $myform->add("lec_note", "lec_note", 0, 0, "", 0, "", 0, "");
   $myform->add("lec_question", "lec_question", 0, 0, "", 0, "", 0, "");
   //$myform->add("com_cou_id","com_cou_id",1,0,$iParent,0,"",0,"");
   //Add table
   $myform->addTable("learn_content");
   //Warning Error!
   $fs_errorMsg = "";
	//Get Action.
	$action	= getValue("action", "str", "POST", "");
   if($action == "execute"){
   //Check form data : kiêm tra lỗi
   $fs_errorMsg .= $myform->checkdata();
      if($fs_errorMsg == ""){
          $upload		    = new upload("lec_media", $mediapath, $fs_extension, $fs_filesize);
            $filename	    = $upload->file_name;
            if($filename != ""){
               $myform->add("lec_media","filename",0,1,0,0);
            }
         $fs_errorMsg .= $upload->show_warning_error();
         //kiểm tra chuỗi thông báo lỗi. Nếu ko có lỗi => thực hiện insert vào database	
         if($fs_errorMsg == ""){
            $myform->removeHTML(0);
            $db_ex = new db_execute_return();
            $last_id = $db_ex->db_execute($myform->generate_update_SQL("lec_id", $record_id));
            redirect($fs_redirect);
            //echo 'Đã cập nhật xong';
            exit();
         }
      }//End if($fs_errorMsg == "")
   }//End if($action == "insert")
   //add form for javacheck
   $myform->addFormname("add_new");
   $myform->evaluate();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<?=$load_header?>
<? 
$myform->checkjavascript();
$errorMsg .= $myform->strErrorField;

//lay du lieu cua record can sua doi
$db_data 	= new db_query("SELECT * FROM learn_content WHERE lec_id = " . $record_id);
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
<?=template_top(translate_text("Edit_category"))?>
<?/*------------------------------------------------------------------------------------------------*/ ?>
   <p align="center" style="padding-left:10px;">
	<?
	$form = new form();
	$form->create_form("add", $_SERVER["REQUEST_URI"], "post", "multipart/form-data",'onsubmit="validateForm(); return false;"');
	$form->create_table();
	?>
	<?=$form->text_note('Những ô dấu (<font class="form_asterisk">*</font>) là bắt buộc phải nhập.')?>
	<?=$form->errorMsg($fs_errorMsg)?>
    <?=$form->radio("Chọn kiểu media","lec_media_type","lec_media_type",2,$lec_media_type,"Video - Audio",0,"","")?>
	<?=$form->radio("","lec_media_type","lec_media_type",3,$lec_media_type,"Flash",0,"","")?>
    <?=$form->getFile("Media cho Speaking", "lec_media", "lec_media", "Media cho Speaking", 0, 30, "", "")?>
    <?=$form->text("Thứ tự", "lec_order", "lec_order", $lec_order, "Thứ tự", 0, 40, "", 255, "", "", "")?>
    <?=$form->text("Hướng dẫn", "lec_note", "lec_note", $lec_note, "Hướng dẫn", 0, 200, 22, 255, "", "", "")?>
    <tr>
        <td colspan="2">
        <?=$form->wysiwyg("Câu hỏi", "lec_question",  $lec_question, "../../resource/wysiwyg_editor/", 800, 300)?>
        </td>
    </tr>
    <tr>
        <td colspan="2">
        <?=$form->wysiwyg("Đoạn văn", "lec_text", $lec_text, "../../resource/wysiwyg_editor/", 800, 300)?>
        </td>
    </tr>
	<?=$form->button("submit" . $form->ec . "reset", "submit" . $form->ec . "reset", "submit" . $form->ec . "reset", "Cập nhật" . $form->ec . "Làm lại", "Cập nhật" . $form->ec . "Làm lại", 'style="background:url(' . $fs_imagepath . 'button_1.gif) no-repeat"' . $form->ec . 'style="background:url(' . $fs_imagepath . 'button_2.gif)"', "");?>
	<?=$form->hidden("action", "action", "execute", "");?>
	<?
   $form->close_table();
   $form->close_form();
   unset($form);
   unset($db_data);
	?>
	</p>
<?=template_bottom() ?>
<? /*------------------------------------------------------------------------------------------------*/ ?>
</body>
</html>