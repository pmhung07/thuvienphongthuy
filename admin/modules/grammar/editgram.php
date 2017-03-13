<?
require_once("inc_security.php");
//check quy?n them sua xoa
checkAddEdit("edit");
$fs_title = $module_name . " | Sửa";

   //Khai bao Bien
   $errorMsg = "";
   $fs_redirect = base64_decode(getValue("url","str","GET",base64_encode("listing.php")));
   $record_id = getValue("record_id");
   $cat_parent_id = getValue("cat_parent_id","str","GET","");
   $com_cou_id = getValue("com_cou_id","str","GET","");
   $gram_det_id = getValue("gram_det_id","str","GET","");
   $db_dataGram = new db_query("SELECT les_com_id,les_det_id,com_cou_id,com_id
                                FROM lesson_details,courses_multi
                                WHERE lesson_details.les_com_id = courses_multi.com_id
                                AND lesson_details.les_det_id = ".$record_id);
   while($rowC = mysqli_fetch_array($db_dataGram->result)){
      $les_com_id = $rowC['les_com_id'];
      $com_cou_id = $rowC['com_cou_id'];
      $db_course = new db_query("SELECT courses.cou_cat_id,courses.cou_id
                     	         FROM courses,courses_multi
                                 WHERE courses.cou_id = courses_multi.com_cou_id
                                 AND courses_multi.com_id = ".$les_com_id);
        while($rowD = mysqli_fetch_array($db_course->result)){
           $cat_parent_id = $rowD['cou_cat_id'];
        }
   }
   unset($db_dataGram);
   unset($db_course);
   $com_c_id = $com_cou_id;
   $menu = new menu();
   $sql = '1';
   $listAll = $menu->getAllChild("categories_multi","cat_id","cat_parent_id","0",$sql . " AND lang_id = " . $lang_id . $sqlcategory,"cat_id,cat_name,cat_order,cat_type,cat_parent_id,cat_has_child","cat_order ASC, cat_name ASC","cat_has_child");
   $sql1 = 'com_cou_id = -1';
   if($com_c_id != '') $sql1 = 'com_cou_id = '.$com_c_id;
   if($com_c_id != "") $sqlUnit = new db_query("SELECT * FROM courses_multi WHERE com_cou_id = ".$com_c_id);

   //Call Class generate_form();
	if($cat_parent_id != "")  $sqlCourse = new db_query("SELECT cou_id,cou_name,cou_lev_id FROM courses WHERE cou_cat_id = ".$cat_parent_id );

   $myform = new generate_form();
   //Loại bỏ chuc nang thay the Tag Html
   $myform->removeHTML(0);
   $myform->add("les_com_id", "les_com_id", 1, 0, "", 1, "Bạn chưa chọn Lesson", 0, "");
   $myform->add("les_det_name","les_det_name",0,0,"",1,translate_text("Vui lòng nhập tên cho phần Grammar"),0,"");
   $myform->add("les_det_type", "les_det_type", 1, 0, 2, 0, "", 0, "");
	//Add table
	$myform->addTable("lesson_details");
	//Warning Error!
   $fs_errorMsg = "";
	//Get Action.
	$action	= getValue("action", "str", "POST", "");
   if($action == "execute"){
      //Check form data : kiêm tra lỗi
      $fs_errorMsg .= $myform->checkdata();
      //kiểm tra chuỗi thông báo lỗi. Nếu ko có lỗi => thực hiện insert vào database
      if($fs_errorMsg == ""){
      $myform->removeHTML(0);
      $db_ex 	= new db_execute_return();
      $last_id = $db_ex->db_execute($myform->generate_update_SQL("les_det_id", $record_id));
      redirect($fs_redirect);
      exit();
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
$db_data = new db_query("SELECT * FROM lesson_details WHERE les_det_id = " . $record_id);
if($row = mysqli_fetch_assoc($db_data->result)){
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
   <?=template_top($fs_title)?>
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
               <select name="com_cou_id" id="com_cou_id"  class="form_control" style="width: 200px;" onChange="window.location.href='add.php?com_cou_id='+this.value+'&cat_parent_id=<?php echo $cat_parent_id; ?>'">
         		<option value="-1">- <?=translate_text("Chọn Course")?> - </option>
         		<?
         		while($row = mysqli_fetch_assoc($sqlCourse->result)){
         		?>
         		<option value="<?=$row['cou_id']?>" <?php if($row['cou_id'] == $com_c_id ) echo "selected='selected'" ;   ?>  ><? echo nameLevel($row['cou_lev_id']).' -- '.$row['cou_name']?></option>
         		<? } ?>
         	</select>
           </td>
         </tr>
         <tr>
           <td align="right" nowrap class="form_name"><font class="form_asterisk">* </font> <?=translate_text("Chọn Unit")?> :</td>
           <td>
               <select name="les_com_id" id="les_com_id"  class="form_control" style="width: 200px;" >
         		<option value="-1">- <?=translate_text("Chọn Unit")?> - </option>
         		<?
         		while($rowUnit = mysqli_fetch_assoc($sqlUnit->result)){
         		?>
         		<option value="<?=$rowUnit['com_id']?>" <?php if($rowUnit['com_id'] == $les_com_id ) echo "selected='selected'" ;   ?>  ><? echo $rowUnit['com_name']?></option>
         		<? } ?>
         	</select>
           </td>
         </tr>
         <?=$form->text("Tiêu đề","les_det_name","les_det_name",$les_det_name,"Tiêu đề",0,250,22)?>
         <? //$form->getFile("Media cho Grammar", "voc_media_url", "voc_media_url", "Media cho Grammar", 0, 30, "", "")?>
         <?=$form->button("submit" . $form->ec . "reset", "submit" . $form->ec . "reset", "submit" . $form->ec . "reset", "Cập nhật" . $form->ec . "Làm lại", "Cập nhật" . $form->ec . "Làm lại", 'style="background:url(' . $fs_imagepath . 'button_1.gif) no-repeat"' . $form->ec . 'style="background:url(' . $fs_imagepath . 'button_2.gif)"', "");?>
         <?=$form->hidden("action", "action", "execute", "");?>
         <?
         $form->close_table();
         $form->close_form();
         unset($form);
         unset($sqlCourse);
         ?>
      </p>
   <?=template_bottom() ?>
   <? /*------------------------------------------------------------------------------------------------*/ ?>
   </body>
</html>