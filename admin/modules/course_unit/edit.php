<?
require_once("inc_security.php");
//check quy?n them sua xoa
checkAddEdit("edit");

	//Khai bao Bien
   $errorMsg = "";
	$fs_redirect = base64_decode(getValue("url","str","GET",base64_encode("listing.php")));
	$record_id = getValue("record_id");
	$sql = "1";
	$menu = new menu();
   $db_course = new db_query("SELECT courses.cou_cat_id,courses.cou_id
								   	FROM courses,courses_multi
									   WHERE courses.cou_id = courses_multi.com_cou_id
                              AND courses_multi.com_id = ".$record_id);

   while($rowC = mysqli_fetch_array($db_course->result)){
      $cat_parent_id = $rowC['cou_cat_id'];
      $cou_id        = $rowC['cou_id'];
   }
   unset($db_course);
   $listAll = $menu->getAllChild("categories_multi","cat_id","cat_parent_id","0",$sql . " AND lang_id = " . $lang_id . $sqlcategory,"cat_id,cat_name,cat_order,cat_type,cat_parent_id,cat_has_child","cat_order ASC, cat_name ASC","cat_has_child");
   //Call Class generate_form();
   $sqlCourse = new db_query("SELECT cou_id,cou_name,cou_lev_id FROM courses WHERE cou_cat_id = ".$cat_parent_id );

	$myform = new generate_form();
	//Loại bỏ chuc nang thay the Tag Html
	$myform -> removeHTML(0);
    $myform -> add("com_cou_id", "com_cou_id", 1, 0, 0, 1, "Bạn chưa chọn Course", 0, "");
	$myform -> add("com_name","com_name",0,0,"",1,translate_text("Vui lòng nhập tên Unit"),0,"");
    $myform -> add("com_num_unit","com_num_unit",1,0,"",1,translate_text("Vui lòng nhập số thứ tự cho Unit"),0,"");
    $myform -> add("com_content","com_content",0,0,"",1,translate_text("Vui lòng nhập mô tả cho Unit"),0,"");
    $myform -> add("title", "title", 0, 0, "", 1, "Bạn chưa nhập title của khóa học để SEO", 0, "");
    $myform -> add("keywords", "keywords", 0, 0, "", 1, "Bạn chưa nhập keywords của khóa học", 0, "");
    $myform -> add("description", "description", 0, 0, "", 1, "Bạn chưa nhập description của khóa học", 0, "");
	$myform->add("com_active", "com_active", 0, 0, 0, 0, "", 0, "");
   //$myform->add("com_cou_id","com_cou_id",1,0,$iParent,0,"",0,"");
	//Add table
	$myform->addTable($fs_table);
	//Warning Error!
	$fs_errorMsg = "";
	//Get Action.
	$action	= getValue("action", "str", "POST", "");
   if($action == "execute"){
      //Check form data : kiêm tra lỗi
  	   $fs_errorMsg .= $myform->checkdata();
      if($fs_errorMsg == ""){
   		$upload		= new upload("com_picture", $imgpath, $fs_extension, $fs_filesize);
   		$filename	= $upload->file_name;
         if($filename != ""){
            delete_file($fs_table,"com_id",$record_id,"com_picture",$imgpath);
            $myform->add("com_picture","filename",0,1,0,0);
            foreach($arr_resize as $type => $arr){
            resize_image($imgpath, $filename, $arr["width"], $arr["height"], $arr["quality"], $type);
            }
         }
       	$fs_errorMsg .= $upload->show_warning_error();
       	//kiểm tra chuỗi thông báo lỗi. Nếu ko có lỗi => thực hiện insert vào database
         if($fs_errorMsg == ""){
            $myform->removeHTML(0);
            $db_ex 	= new db_execute_return();
            $last_id = $db_ex->db_execute($myform->generate_update_SQL($id_field, $record_id));
            redirect($fs_redirect);
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
   	<?=$form->errorMsg($fs_errorMsg)?>
   	<?=$form->select_db_multi("Chọn chuyên mục cha", "cat_parent_id", "cat_parent_id", $listAll, "cat_id", "cat_name", $cat_parent_id, "Chọn chuyên mục cha", 1, "", 1, 0, "onChange=\"window.location.href='add.php?cat_parent_id='+this.value\"", "")?>
      <? //$form->select_db_multi("Chọn Course", "com_cou_id", "com_cou_id", $listCourse, "cou_id", "cou_name", $com_cou_id, "Chọn Course", 1, "", 1, 0, "", "")?>
         <tr>
            <td align="right" nowrap class="form_name"><font class="form_asterisk">* </font> <?=translate_text("Chọn Course")?> :</td>
            <td>
               <select name="com_cou_id" id="com_cou_id"  class="form_control">
         		<option value="-1">- <?=translate_text("Chọn Course")?> - </option>
         		<?
         		while($row = mysqli_fetch_assoc($sqlCourse->result)){
         		?>
         		<option value="<?=$row['cou_id']?>" <?php if ($row['cou_id'] == $cou_id ) echo "selected='selected'"?>  ><? echo nameLevel($row['cou_lev_id']).' -- '.$row['cou_name']?></option>
         		<? } ?>
         	   </select>
            </td>
         </tr>
       <?=$form->text("Tên Unit", "com_name", "com_name", $com_name, "Tên Unit", 1, 250, "", 255, "", "", "")?>
       <?=$form->text("Số thứ tự Unit", "com_num_unit", "com_num_unit", $com_num_unit, "Số thứ tự của Unit", 1, 50, "", 255, "", "", "")?>
       <?=$form->textarea("Mô tả ngắn về Unit", "com_content", "com_content", $com_content, "Mô tả ngắn về Unit", 1, 400, 60, "", "", "")?>
       <?=$form->text("Title", "title", "title", $title, "Title", 1, 450, 24, 255, "", "", "")?>
       <?=$form->text("Keywords", "keywords", "keywords", $keywords, "Keywords", 1, 450, 24, 255, "", "", "")?>
       <?=$form->text("Description", "description", "description", $description, "Description", 1, 450,24, 255, "", "", "")?>
       <?=$form->getFile("Ảnh Unit", "com_picture", "com_picture", "Ảnh Unit", 0, 30, "", "")?>
       <?=$form->checkbox("Hiển thị", "com_active", "com_active", 1 ,$com_active, "lựa chọn hiển thị ", "", "", "", "", "", "", "")?>
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