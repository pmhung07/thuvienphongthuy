<?
include("inc_security.php");
checkAddEdit("edit");

   $fs_title			= $module_name . " | Sửa đổi";
   $fs_action			= getURL();
   $fs_errorMsg		= "";
   $iPara            = getValue("iPara","int","GET","");
   $high_id          = getValue("high_id","int","GET",0);
   $record_id 		   = getValue("record_id");
   $iQues            = getValue("iQues","int","GET","");

   $myform = new generate_form();
   $myform->add("high_paragraph", "high_paragraph", 0, 0, "",1, "Bạn chưa nhập đoạn văn", 0, "");
	//Add table insert data
	$myform->addTable("test_highlight");
   //Get action variable for add new data
   $action				= getValue("action", "str", "POST", "");
   //Check $action for insert new data
   if($action == "execute"){
   	//Check form data
   	$fs_errorMsg .= $myform->checkdata();
   	if($fs_errorMsg == ""){
   		$myform->removeHTML(0);
   		$db_ex = new db_execute($myform->generate_update_SQL("high_id",$high_id));
   		redirect("add_exercises.php?&iQues=".$iQues."&iPara=".$iPara."&record_id=".$record_id);
   	}
   }

   $myform->addFormname("add_new");
   $myform->evaluate();
   $myform->checkjavascript();
   $fs_errorMsg .= $myform->strErrorField;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<?=$load_header?>
<?
//lay du lieu cua record can sua doi
$db_data 	= new db_query("SELECT * FROM test_highlight WHERE high_id = " . $high_id);
if($row 		= mysqli_fetch_assoc($db_data->result)){
   foreach($row as $key=>$value){
   	if($key!='lang_id' && $key!='admin_id') $$key = $value;
   }
}else{
		exit();
}

?>
</head>
<body>
<?=template_top($fs_title)?>
   <p align="center" style="padding-left:10px;">
      <?
      $form = new form();
      $form->create_form("add", $fs_action, "post", "multipart/form-data",'onsubmit="validateForm(); return false;"');
      $form->create_table();
      ?>
      <tr>
         <td width="" class="form_name">Tách đoạn :</td>
         <td width="800">
            <?=$form->wysiwyg("<font class='form_asterisk'>*</font> Thông tin đề thi", "high_paragraph", $high_paragraph , "../../resource/wysiwyg_editor/", 800, 250)?>
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