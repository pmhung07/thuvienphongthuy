<?
include ("inc_security.php");
$fs_title = $module_name . " | Thêm mới";
checkAddEdit("add");

$record_id        = getValue("record_id","int","GET","");
$fs_action			= getURL();
$fs_errorMsg		= "";
$after_save_data  = getValue("after_save_data", "str", "POST", "add_exercises.php");
$fs_redirect      = $after_save_data;
$media_type = 4;
$myform = new generate_form();  
$myform->add("media_exe_id", "record_id", 1, 1, 0, 0, "", 1, "");
$myform->add("media_des", "media_des", 0, 0, "",1, "Bạn chưa nhập mô tả", 0, "");
$myform->add("media_paragraph", "media_paragraph", 0, 0, "", 0, "Bạn chưa nhập đoạn văn", 1, "");
$myform->add("media_type", "media_type", 1, 1, 4, 0, "", 1, "");

$myform->addTable("media_exercies");
//Get action variable for add new data
$action	  = getValue("action", "str", "POST", ""); 
//
//Check $action for insert new data
if($action == "execute"){      
   if($fs_errorMsg == ""){    	
   	$myform->removeHTML(0);//loại bỏ  các ký tự html( 0 thi ko loại bỏ, 1: bỏ) tránh lỗi 
      //thực hiện insert 
   	$db_insert = new db_execute($myform->generate_insert_SQL());
   	//unset biến để giải phóng bộ nhớ.
      unset($db_insert);
   	//Redirect after insert complate
   	//$fs_redirect = "add.php?order=" . (getValue("cur_order","int","POST") + 1);
   	redirect("confirmation.php?&record_id=".$record_id);
   }
}//End if($action == "insert")
$myform->addFormname("add_new");
$myform->evaluate();
$myform->checkjavascript();
$fs_errorMsg .= $myform->strErrorField;

//==========================================================
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<?=$load_header?>
</head>
<body>
<?=template_top($fs_title)?>
   <p align="center" style="padding-left:10px;">
      <?
      $form = new form();
      $form->create_form("add", $fs_action, "post", "multipart/form-data",'onsubmit="validateForm(); return false;"');
      $form->create_table();
      ?>
       <?=$form->text("Nhập mô tả","media_des","media_des","","Mô tả",0,204,"",255,"","","")?>
      <tr>
         <td width="" class="form_name"></td>
         <td width="800">
            <?=$form->wysiwyg("<font class='form_asterisk'>*</font> Nhập đoạn văn", "media_paragraph", $media_paragraph , "../../resource/wysiwyg_editor/", 800, 250)?>
         </td>
      </tr>
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
