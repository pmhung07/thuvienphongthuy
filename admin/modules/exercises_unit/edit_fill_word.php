<?
include("inc_security.php");
checkAddEdit("edit");

   $fs_title			= $module_name . " | Sửa đổi";
   $fs_action			= getURL();
   $fs_errorMsg		= "";
   $que_id 		      = getValue("que_id");
   $record_id 		   = getValue("record_id");

   $myform = new generate_form();  
   $myform->add("que_content", "que_content", 0, 0, "",1, "Bạn chưa nhập đoạn văn", 0, "");
	
	//Add table insert data
	$myform->addTable("questions");
   //Get action variable for add new data
   $action = getValue("action", "str", "POST", "");
   //Check $action for insert new data
   if($action == "execute"){
   	//Check form data
   	$fs_errorMsg .= $myform->checkdata();      
   	if($fs_errorMsg == ""){ 	
   		$myform->removeHTML(0);
   		$db_ex = new db_execute($myform->generate_update_SQL("que_id",$que_id));
   		redirect("confirmation.php?record_id=".$record_id);	
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
$db_data 	= new db_query("SELECT * FROM questions WHERE que_id = " . $que_id);
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
<?=template_top($fs_title)?>
   <p align="center" style="padding-left:10px;">
      <?
      $form = new form();
      $form->create_form("add", $fs_action, "post", "multipart/form-data",'onsubmit="validateForm(); return false;"');
      $form->create_table();
      ?>
      <tr>
         <td width="" class="form_name"></td>
         <td width="800">
            <?=$form->wysiwyg("<font class='form_asterisk'>*</font> Nhập đoạn văn ", "que_content", $que_content , "../../resource/wysiwyg_editor/", 800, 250)?>
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