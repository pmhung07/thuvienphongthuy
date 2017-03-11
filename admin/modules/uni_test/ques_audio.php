<?
include ("inc_security.php");
$fs_title = $module_name . " | Thêm mới";
checkAddEdit("add");

$iQues            = getValue("iQues","int","GET","");
$record_id 		   = getValue("record_id");
$fs_action			= getURL();
$fs_errorMsg		= "";
$after_save_data  = getValue("after_save_data", "str", "POST", "add_exercises.php");
$fs_redirect      = $after_save_data;


$myform = new generate_form();  
$myform->addTable("uni_quest");
//Get action variable for add new data
$action	  = getValue("action", "str", "POST", ""); 
//Check $action for insert new datac

if($action == "execute"){      
   if($fs_errorMsg == ""){    	
      $myform->add("uque_para", "uque_para", 0, 0, "", 1, "Bạn chưa nhập nội dung cho đoạn văn", 0, "");
      //thực hiện insert 
      $db_ex = new db_execute($myform->generate_update_SQL("uque_id", $iQues));
      unset($db_ex);
   	//redirect("add_exercises.php?iPara=".$iPara."&record_id=".$record_id);
      redirect($_SERVER['REQUEST_URI']);
   }
}
$myform->addFormname("add_new");
$myform->evaluate();
$myform->checkjavascript();
$fs_errorMsg .= $myform->strErrorField;

//lay du lieu cua record can sua doi
$db_data 	= new db_query("SELECT * FROM uni_quest WHERE uque_id =".$iQues);
if($row 		= mysql_fetch_assoc($db_data->result)){
   foreach($row as $key=>$value){
   	if($key!='lang_id' && $key!='admin_id') $$key = $value;
   }
}else{
		exit();
}


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
      <?=$form->textarea("Nhập đoạn văn", "uque_para", "uque_para", $uque_para, "Đoạn văn", 0, 500, 200, "", "", "", "")?>
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
	<div style="padding-left:100px; padding-right:3px;">
	<table cellpadding="5" cellspacing="0" width="440px" style="border-collapse:collapse;" bordercolor="#CCCCCC" border="1">
		<tr>
			<th width="10">ID</th>
         <th width="100">Paragraph</th>
		</tr>
		<?
      $db_picture = new db_query("SELECT * FROM uni_quest WHERE uque_id=".$iQues);
		$i=0;
		while($row = mysql_fetch_assoc($db_picture->result)){
			$i++;
		?>
			<tr <?=$fs_change_bg?>>
				<td align="center"><?=$i?></td>
            <td align="center">
               <textarea style="width: 500px;height: 200px;"><?=$row["uque_para"]?></textarea>
            </td>
         </tr>
		<?
		}unset($db_picture);
		?>
	</table>
	</div>
<? /*------------------------------------------------------------------------------------------------*/ ?>
</body>
</html>
