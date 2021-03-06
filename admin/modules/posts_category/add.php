<?
require_once("inc_security.php");
//check quyền them sua xoa
checkAddEdit("add");

	//Khai bao Bien
	$fs_redirect							= "add.php";
	$after_save_data						= getValue("after_save_data", "str", "POST", "add.php");
	$pcat_type								= getValue("pcat_type","str","GET","");
	$pcat_order								= getValue("pcat_order","str","GET","");
	$iParent									= getValue("iParent","str","GET","");
	$pcat_order								+=	1;
	if($pcat_type == "") $pcat_type 	= getValue("pcat_type","str","POST",-1);
	$sql										= "1";
	if($pcat_type != "")  $sql			= " pcat_type = '" . $pcat_type . "'";
	$menu 									= new menu();
	$listAll 								= $menu->getAllChild("post_category","pcat_id","pcat_parent_id","0",$sql . " AND lang_id = " . $lang_id . $sqlcategory,"pcat_id,pcat_name,pcat_order,pcat_type,pcat_parent_id,pcat_has_child","pcat_order ASC, pcat_name ASC","pcat_has_child");
	//Call Class generate_form();
	$myform 									= new generate_form();
	//Loại bỏ chuc nang thay the Tag Html
	$myform->removeHTML(0);
	$myform->add("pcat_type","pcat_type",0,0,$pcat_type,1,translate_text("Vui lòng chọn loại danh mục!"),0,"");
	$myform->add("pcat_name","pcat_name",0,0,"",1,translate_text("Vui lòng nhập tên danh mục"),0,"");
	if($array_config["order"]==1)  $myform->add("pcat_order","pcat_order",1,0,$pcat_order,0,"",0,"");
	if($array_config["upper"]==1) $myform->add("pcat_parent_id","pcat_parent_id",1,0,$iParent,0,"",0,"");
	$myform->add("admin_id","admin_id",1,1,0,0,"",0,"");
	//Active data
	$myform->add("pcat_active","pactive",1,1,1,0,"",0,"");
	//Add table
	$myform->addTable($fs_table);
	//Warning Error!
	$errorMsg = "";
	//Get Action.
	$action	= getValue("action", "str", "POST", "");
	if($action == "execute"){
		$errorMsg .= $myform->checkdata();
		if($errorMsg == ""){
			$db_ex 	= new db_execute_return();
			$last_id = $db_ex->db_execute($myform->generate_insert_SQL());
			$iParent = getValue("pcat_parent_id","int","POST");
			if($iParent > 0){
				$db_ex = new db_execute("UPDATE post_category SET pcat_has_child = 1 WHERE pcat_id = " . $iParent);
			}
			//echo $myform->generate_insert_SQL();
			// Redirect to add new
			$fs_redirect = "add.php?save=1&iParent=" . $iParent . "&pcat_type=" . getValue("pcat_type","str","POST") . "&pcat_order=" . getValue("pcat_order","int","POST");
			//Redirect to:
			redirect($fs_redirect);
			exit();
		}
	}
	//add form for javacheck
	$myform->addFormname("add_new");
	$myform->evaluate();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<?=$load_header?>
<? $myform->checkjavascript();?>
</head>
<body topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0">
<? /*------------------------------------------------------------------------------------------------*/ ?>
<?=template_top(translate_text("Add_new_category"))?>
<? /*------------------------------------------------------------------------------------------------*/ ?>
	<p align="center" style="padding-left:10px;">
	<?
	$form = new form();
	$form->create_form("add", $_SERVER["REQUEST_URI"], "post", "multipart/form-data",'onsubmit="validateForm(); return false;"');
	$form->create_table();
	?>
	<?=$form->text_note('Những ô dấu (<font class="form_asterisk">*</font>) là bắt buộc phải nhập.')?>
	<?=$form->errorMsg($errorMsg)?>
	<tr> 
		<td align="right" nowrap class="form_name"><font class="form_asterisk">* </font> <?=translate_text("Loại danh mục")?> :</td>
		<td>
			<select name="pcat_type" id="pcat_type"  class="form_control" onChange="window.location.href='add.php?pcat_type='+this.value">
				<option value="-1">- <?=translate_text("Chọn loại danh mục")?> - </option>
				<?
				foreach($array_value as $key => $value){
				?>
				<option value="<?=$key?>" <? if($key == $pcat_type) echo "selected='selected'";?>><?=$value?></option>
				<? } ?>
			</select>
		</td>
	</tr>	
	<?=($array_config["upper"] != 0) ? $form->select_db_multi("Danh mục cha", "pcat_parent_id", "pcat_parent_id", $listAll, "pcat_id", "pcat_name", $pcat_parent_id, "Chọn cấp cha", 1, "", 1, 0, "", "") : ''?>
	<?=$form->text("Tên danh mục", "pcat_name", "pcat_name", $pcat_name, "Tên danh mục", 1, 250, "", 255, "", "", "")?>
	<?=($array_config['order'] == 1) ? $form->text("Thứ tự", "pcat_order", "pcat_order", $pcat_order, "Thứ tự hiển thị", 0, 50, "") : ''?>
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
</body>
</html>