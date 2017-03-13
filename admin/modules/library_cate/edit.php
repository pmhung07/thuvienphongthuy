<?
require_once("inc_security.php");
//check quy?n them sua xoa
checkAddEdit("edit");

	//Khai bao Bien
	$fs_redirect 							= base64_decode(getValue("url","str","GET",base64_encode("listing.php")));
	$record_id 								= getValue("record_id");
	$sql										= "1";
	$menu 									= new menu();
	$listAll 								= $menu->getAllChild("library_cate","lib_cat_id","lib_cat_parent_id","0",$sql . " AND lang_id = " . $lang_id . $sqlcategory,"lib_cat_id,lib_cat_name,lib_cat_order,lib_cat_type,lib_cat_parent_id,lib_cat_has_child","lib_cat_order ASC, lib_cat_name ASC","lib_cat_has_child");
	//Call Class generate_form();
	$myform 									= new generate_form();
	//Loại bỏ chuc nang thay the Tag Html
	$myform->removeHTML(0);
	$myform->add("lib_cat_type","lib_cat_type", 0, 0,"", 1, translate_text("Vui lòng chọn loại danh mục!"),0,"");
	$myform->add("lib_cat_name","lib_cat_name", 0, 0, "", 1, translate_text("Vui lòng nhập tên danh mục"),0,"");
	$myform->add("lib_cat_description","lib_cat_description",0,0,"",1,"Bạn chưa nhập mô tả chuyên mục",0,"");
   $myform->add("title", "title", 0, 0, "", 0, "", 0, "");
   $myform->add("keywords", "keywords", 0, 0, "", 0, "", 0, "");
   $myform->add("description", "description", 0, 0, "", 0, "Bạn chưa nhập description của khóa học", 0, "");
	if($array_config["order"]==1)  $myform->add("lib_cat_order","lib_cat_order", 1, 0, 0,0,"",0,"");
	if($array_config["upper"]==1) $myform->add("lib_cat_parent_id","lib_cat_parent_id", 1, 0, 0, 0, "", 0, "");
	$myform->add("admin_id","admin_id", 1, 1, 0, 0, "", 0, "");
	//Active data
	//$myform->add("lib_cat_active","active", 1, 1, 1, 0, "", 0, "");
	//Add table
	$myform->addTable($fs_table);
	//Warning Error!
	$errorMsg = "";
	//Get Action.
	$action	= getValue("action", "str", "POST", "");
	if($action == "execute"){
		$errorMsg .= $myform->checkdata();
      if($errorMsg == ""){
         $upload		= new upload("lib_cat_picture", $imgpath, $fs_extension, $fs_filesize);
         $filename	= $upload->file_name;
         if($filename != ""){
            delete_file($fs_table,$id_field,$record_id,"lib_cat_picture",$imgpath);
      		$myform->add("lib_cat_picture","filename",0,1,0,0);
      		foreach($arr_resize as $type => $arr){
      		   resize_image($imgpath, $filename, $arr["width"], $arr["height"], $arr["quality"], $type);
      		}
   		}
      }
      $errorMsg .= $upload->show_warning_error();
      if($errorMsg == ""){
			$db_ex 	= new db_execute_return();
			$last_id = $db_ex->db_execute($myform->generate_update_SQL($id_field, $record_id));
			$iParent = getValue("lib_cat_parent_id","int","POST");
			if($iParent > 0){
				$db_ex = new db_execute("UPDATE library_cate SET lib_cat_has_child = 1 WHERE lib_cat_id = " . $iParent);
			}
			redirect($fs_redirect);
			exit();
		}
      /*
		if($array_config["image"]==1){
			$upload_pic = new upload("picture", $fs_filepath, $extension_list, $limit_size);
			if ($upload_pic->file_name != ""){
				$picture = $upload_pic->file_name;
				//resize_image($fs_filepath,$upload_pic->file_name,100,100,75);
				$myform->add("cat_picture","picture",0,1,"",0,"",0,"");
			}
			//Check Error!
			$errorMsg .= $upload_pic->show_warning_error();
		}
		$errorMsg .= $myform->checkdata();
      */
	}
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
$db_data 	= new db_query("SELECT * FROM " . $fs_table . " WHERE " . $id_field . " = " . $record_id);
if($row 		= mysqli_fetch_assoc($db_data->result)){
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
<?=template_top(translate_text("Edit_category"))?>
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
		<td align="right" nowrap class="form_name" width="200"><font class="form_asterisk">* </font> <?=translate_text("Loại danh mục")?> :</td>
		<td>
			<select name="lib_cat_type" id="lib_cat_type"  class="form_control" onChange="window.location.href='add.php?lib_cat_type='+this.value">
				<option value="">--[ <?=translate_text("Chọn loại danh mục")?> ]--</option>
				<?
				foreach($array_value as $key => $value){
				?>
				<option value="<?=$key?>" <? if($key == $lib_cat_type) echo "selected='selected'";?>><?=$value?></option>
				<? } ?>
			</select>
		</td>
	</tr>
	<?=($array_config["upper"] != 0) ? $form->select_db_multi("Danh mục cha", "lib_cat_parent_id", "lib_cat_parent_id", $listAll, "lib_cat_id", "lib_cat_name", $lib_cat_parent_id, "Chọn cấp cha", 1, "", 1, 0, "", "") : ''?>
	<?=$form->text("Tên danh mục", "lib_cat_name", "lib_cat_name", $lib_cat_name, "Tên danh mục", 1, 250, "", 255, "", "", "")?>
   <?=$form->getFile("Ảnh đại diện", "lib_cat_picture", "lib_cat_picture", "Chọn hình ảnh", 1, 40, "", "")?>
	<?=$form->textarea("Description","lib_cat_description","lib_cat_description",$lib_cat_description,"Description",0,274,100,"","","")?>
	<?=$form->text("Title", "title", "title", $title, "Title", 0, 450, 24, 255, "", "", "")?>
   <?=$form->text("Keywords", "keywords", "keywords", $keywords, "Keywords", 0, 450, 24, 255, "", "", "")?>
   <?=$form->text("Description", "description", "description", $description, "Description", 0, 450,24, 255, "", "", "")?>
   <?=($array_config['order'] == 1) ? $form->text("Thứ tự", "lib_cat_order", "lib_cat_order", $lib_cat_order, "Thứ tự hiển thị", 0, 50, "") : ''?>
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