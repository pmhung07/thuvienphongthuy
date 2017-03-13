<?
require_once("inc_security.php");
//check quy?n them sua xoa
checkAddEdit("edit");
$fs_title = $module_name . " | Sửa";
   //Khai bao Bien
   $errorMsg = "";
   $fs_redirect = base64_decode(getValue("returnurl","str","GET",base64_encode("listdetail.php")));
   $record_id = getValue("record_id");
   $cat_parent_id = getValue("cat_parent_id","str","GET","");
   $com_cou_id = getValue("com_cou_id","str","GET","");
   $les_com_id = getValue("les_com_id","str","GET","");

   $db_nlesson = new db_query("SELECT les_com_id,les_det_id FROM  grammar_lesson,lesson_details
                               WHERE grammar_lesson.gram_det_id = lesson_details.les_det_id
                               AND   grammar_lesson.gram_id = ".$record_id);
   while($rownL = mysqli_fetch_array($db_nlesson->result)){
      $idLesson = $rownL['les_det_id'];
      $gram_det_id = $idLesson ;
   }

   $db_dataGram = new db_query("SELECT les_com_id,les_det_id,com_cou_id FROM  lesson_details,courses_multi
                                WHERE lesson_details.les_com_id = courses_multi.com_id
                                AND   lesson_details.les_det_id = ".$idLesson );

   while($rowC = mysqli_fetch_array($db_dataGram->result)){
      $les_com_id = $rowC['les_com_id'];
      $com_cou_id = $rowC['com_cou_id'];

      $db_course = new db_query("SELECT courses.cou_cat_id,courses.cou_id,courses.cou_lev_id
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
   if($com_c_id != "") $sqlUnit = new db_query("SELECT * FROM courses_multi WHERE com_cou_id = ".$com_c_id);

   //Call Class generate_form();
	if($cat_parent_id != "")  $sqlCourse = new db_query("SELECT cou_id,cou_name,cou_lev_id FROM courses WHERE cou_cat_id = ".$cat_parent_id );

	$myform = new generate_form();

	//Loại bỏ chuc nang thay the Tag Html
   $myform->removeHTML(0);
   $myform->add("gram_det_id", "gram_det_id", 1, 0, $gram_det_id, 0, "", 0, "");
   $myform->add("gram_title", "gram_title", 0, 0, "", 0, "", 0, "");
   $myform->add("gram_content_vi","gram_content_vi",0,0,"",1,translate_text("Vui lòng nhập nội dung tiếng việt cho phần Grammar"),0,"");
   $myform->add("gram_media_type","gram_media_type",1,0,"",1,translate_text("Vui lòng chọn dạng media cho phần Grammar"),0,"");
   $myform->add("gram_exam","gram_exam",0,0,"",1,translate_text("Vui lòng nhập ví dụ cho Grammar"),0,"");
   $myform->add("gram_order", "gram_order", 1, 0, 0, 0, "", 0, "");
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
         $upload = new upload("gram_media_url", $mediapath, $fs_extension, $fs_filesize);
         $uploadAudio = new upload("gram_audio_url", $mediapath, $fs_extension, $fs_filesize);

         $filename = $upload->file_name;
         $filenameAudio = $uploadAudio->file_name;

         if($filename != ""){
            delete_file($fs_table,"gram_id",$record_id,"gram_media_url",$mediapath);
            $myform->add("gram_media_url","filename",0,1,0,0);
            foreach($arr_resize as $type => $arr){
               resize_image($mediapath, $filename, $arr["width"], $arr["height"], $arr["quality"], $type);
            }
         }
         if($filenameAudio != ""){
             delete_file($fs_table,"gram_id",$record_id,"gram_audio_url",$mediapath);
             $myform->add("gram_audio_url","filenameAudio",0,1,0,0);
         }
         $fs_errorMsg .= $upload->show_warning_error();
         //kiểm tra chuỗi thông báo lỗi. Nếu ko có lỗi => thực hiện insert vào database
         if($fs_errorMsg == ""){
            $myform->removeHTML(0);
            $db_ex = new db_execute_return();
            $last_id = $db_ex->db_execute($myform->generate_update_SQL($id_field, $record_id));
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
   <?=$form->radio("Chọn kiểu media","gram_media_type","gram_media_type",1,$gram_media_type,"Ảnh",0,"","")?>
   <?=$form->radio("","gram_media_type","gram_media_type",2,$gram_media_type,"Video",0,"","")?>
   <?=$form->radio("","gram_media_type","gram_media_type",3,$gram_media_type,"Flash",0,"","")?>
   <?=$form->getFile("Media cho Grammar", "gram_media_url", "gram_media_url", "Media cho Grammar", 0, 30, "", "")?>
   <?=$form->getFile("Audio cho Grammar", "gram_audio_url", "gram_audio_url", "Audio cho Grammar", 0, 30, "", "")?>
   <? //media type = 1 (Ảnh) , 2 (Video) , 3 (Flash) ?>
    <?=$form->text("Tiêu đề", "gram_title", "gram_title", $gram_title, "Tiêu đề", 0, 218, "", 255, "", "", "")?>
   <tr>
     <td colspan="2">
        <?=$form->wysiwyg("Nội dung tiếng việt", "gram_content_vi", $gram_content_vi, "../../resource/wysiwyg_editor/", 800, 300)?>
     </td>
   </tr>
   <tr>
      <td colspan="2">
      <?=$form->wysiwyg("Giải thích và ví dụ", "gram_exam", $gram_exam, "../../resource/wysiwyg_editor/", 800, 300)?>
      </td>
  </tr>
   <?=$form->text("Thứ tự", "gram_order", "gram_order", $gram_order, "Thứ tự", 0, 40, "", 255, "", "", "")?>
   <?=$form->button("submit" . $form->ec . "reset", "submit" . $form->ec . "reset", "submit" . $form->ec . "reset", "Cập nhật" . $form->ec . "Làm lại", "Cập nhật" . $form->ec . "Làm lại", 'style="background:url(' . $fs_imagepath . 'button_1.gif) no-repeat"' . $form->ec . 'style="background:url(' . $fs_imagepath . 'button_2.gif)"', "");?>
	<?=$form->hidden("action", "action", "execute", "");?>
	<?
   $form->close_table();
   $form->close_form();
   unset($form);
   unset($sqlCourse);
   unset($db_data);
	?>
	</p>
<?=template_bottom() ?>
<? /*------------------------------------------------------------------------------------------------*/ ?>
</body>
</html>