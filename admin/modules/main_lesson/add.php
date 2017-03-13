<?
require_once("inc_security.php");
//check quyền them sua xoa
checkAddEdit("add");

   //Khai bao Bien
   $fs_title = $module_name . " | Thêm mới";
   $add = "add.php";
   $listing = "listing.php";
	$after_save_data = getValue("after_save_data", "str", "POST", "add.php");
   $fs_redirect = $after_save_data;
   $cat_parent_id = getValue("cat_parent_id","str","GET","");
   $com_cou_id = getValue("com_cou_id","str","GET","");
   $com_c_id = $com_cou_id;
   $main_com_id = getValue("main_com_id","str","GET","");
   $fs_errorMsg = "";
   //List Danh muc
   $menu = new menu();
   $sql = '1';
   $listAll = $menu->getAllChild("categories_multi","cat_id","cat_parent_id","0",$sql . " AND lang_id = " . $lang_id . $sqlcategory,"cat_id,cat_name,cat_order,cat_type,cat_parent_id,cat_has_child","cat_order ASC, cat_name ASC","cat_has_child");
   $array_unit = array();
   if($com_cou_id > 0){
      $unit_select = new db_query("SELECT com_id,com_name FROM courses_multi
                                    WHERE com_cou_id =" .$com_cou_id. " AND com_active = 1");
      while($row_unit = mysqli_fetch_assoc($unit_select->result)){
         $array_unit[$row_unit["com_id"]] = $row_unit["com_name"];
      }unset($unit_select);
   }
   //========================================================================================//
   $arr_check = array();
   $db_select_unit = new db_query("SELECT * FROM courses_multi
                                    INNER JOIN lesson_details ON courses_multi.com_id = lesson_details.les_com_id
                                    WHERE les_det_type = 1");
   $i = 0;
   while($row_a = mysqli_fetch_assoc($db_select_unit->result)){
      $arr_check[$i] = $row_a["com_id"];
      $i++;
   }
   //========================================================================================//
	if($cat_parent_id != "")  $sqlCourse	= new db_query("SELECT cou_id,cou_name FROM courses WHERE cou_cat_id = ".$cat_parent_id );

	$myform 		= new generate_form();
	$myform->removeHTML(0);
   $myform->add("les_com_id", "les_com_id", 1, 0, 0, 1, "Bạn chưa chọn Lesson", 0, "");
	$myform->add("les_det_name","les_det_name",0,0,"",1,"Bạn chưa nhập tên bài học chính",0,"");
   $myform->add("les_det_type","les_det_type",1,0,1,1,"",0,"");
	$myform->addTable($fs_table);

	//Get Action.
	$action	= getValue("action", "str", "POST", "");
   if($action == "execute"){
      //Check form data : kiêm tra lỗi
   $fs_errorMsg .= $myform->checkdata();
      if($fs_errorMsg == ""){
      	$myform->removeHTML(0);
      	$db_insert = new db_execute($myform->generate_insert_SQL());
         unset($db_insert);
      	redirect($fs_redirect);
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
?>
</head>
<body>
<? /*------------------------------------------------------------------------------------------------*/ ?>
<?=template_top($fs_title)?>
<? /*------------------------------------------------------------------------------------------------*/ ?>
   <p align="center" style="padding-left:10px;">
	<?
	$form = new form();
	$form->create_form("add", $_SERVER["REQUEST_URI"], "post", "multipart/form-data",'onsubmit="validateForm(); return false;"');
	$form->create_table();
	?>
   <?//=$form->text_note('<strong style="text-align:center;">----------Thêm mới bài học chính-----------</strong>')?>
	<?=$form->text_note('Những ô dấu (<font class="form_asterisk">*</font>) là bắt buộc phải nhập.')?>
	<?=$form->errorMsg($fs_errorMsg)?>
	<?=$form->select_db_multi("Chọn danh mục", "cat_parent_id", "cat_parent_id", $listAll, "cat_id", "cat_name", $cat_parent_id, "Chọn danh mục", 1, "", 1, 0, "onChange=\"window.location.href='add.php?cat_parent_id='+this.value\"", "")?>
   <tr>
      <td align="right" nowrap="" class="form_name"><font class="form_asterisk">* </font> <?=translate_text("Chọn khóa học")?> :</td>
      <td>
         <select name="com_cou_id" id="com_cou_id"  class="form_control" style="width: 200px;" onChange="window.location.href='add.php?com_cou_id='+this.value+'&cat_parent_id=<?php echo $cat_parent_id; ?>'">
         	<option value="-1">- <?=translate_text("Chọn Course")?> - </option>
         	<?
         	while($row = mysqli_fetch_assoc($sqlCourse->result)){
         	?>
         	<option value="<?=$row['cou_id']?>" <?php if($row['cou_id'] == $com_c_id ) echo "selected='selected'" ;?>><? echo $row['cou_name']?></option>
            <?} ?>
         </select>
      </td>
   </tr>
   <tr>
      <input type="hidden" id="les_det_type" name="les_det_type" value="1"/>
   </tr>
   <?//=$form->select_db_multi("Chọn Lesson", "les_com_id", "les_com_id", $listLesson, "com_id", "com_name", $les_com_id, "Chọn Lesson", 1, "", 1, 0, "", "")?>
   <?//=$form->select("Chọn Unit","les_com_id","les_com_id",$array_unit,$les_com_id,"Chọn Unit",1,"",""); ?>
   <tr>
      <td class="form_name"><font color="red">*</font>&nbsp;Chọn Unit : </td>
      <td>
         <select class="form_control" style="width: 186px;" name="les_com_id" id="les_com_id">
            <option value=""> - Chọn Unit - </option>
            <?foreach($array_unit as $id=>$name){
            if(in_array($id,$arr_check)) continue;
            ?>
      			<option value="<?=$id?>"><?=$name?></option>
      		<?}?>
         </select>
      </td>
   </tr>
   <?=$form->text("Tên bài học","les_det_name","les_det_name",$les_det_name,"Nhập tên bài học",1,250,"",255,"","","");?>
   <?=$form->radio("Sau khi lưu dữ liệu", "add_new" . $form->ec . "return_listing", "after_save_data", $add . $form->ec . $listing, $after_save_data, "Thêm mới" . $form->ec . "Quay về danh sách", 0, $form->ec, "");?>
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