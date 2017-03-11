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
   
   //Lay ra ID cua Content hien tai
   $db_skill = new db_query("SELECT * FROM skill_content,grammar_lesson
                               WHERE grammar_lesson.gram_skl_cont_id = skill_content.skl_cont_id
                               AND   grammar_lesson.gram_id = ".$record_id);
   while($row_skill = mysql_fetch_assoc($db_skill->result)){
      $idContent = $row_skill['skl_cont_id'];
      $gram_skl_cont_id = $idContent ;
   }
   unset($db_skill);
   
   //Lay ra ID cua danh muc va bai hoc hien tai
   $db_info = new db_query("SELECT * FROM skill_lesson,skill_content
                            WHERE skill_content.skl_cont_les_id = skill_lesson.skl_les_id
                            AND   skill_content.skl_cont_id = ".$idContent);
   $row_info = mysql_fetch_assoc($db_info->result);
   $idLesson = $row_info['skl_les_id'];
   $cat_parent_id = $row_info['skl_les_cat_id'];
   unset($db_info);                           
   
   //List danh muc
   $menu = new menu();
   $sql = '1';
   $sql = ' cat_type = 0';
   $listAll = $menu->getAllChild("categories_multi","cat_id","cat_parent_id","0",$sql . " AND lang_id = " . $lang_id . $sqlcategory,"cat_id,cat_name,cat_order,cat_type,cat_parent_id,cat_has_child","cat_order ASC, cat_name ASC","cat_has_child");
   
   //List bai hoc
   $db_lesson = new db_query("SELECT skl_les_id, skl_les_name
                              FROM skill_lesson
                              WHERE skl_les_cat_id = ".$cat_parent_id);
   //List Content
   $db_content = new db_query("SELECT skl_cont_id, skl_cont_title, skl_cont_order
                               FROM skill_content
                               WHERE skl_cont_les_id = ".$idLesson." ORDER BY skl_cont_order ASC");  
   
	$myform = new generate_form();
    
	//Loại bỏ chuc nang thay the Tag Html
   $myform->removeHTML(0);
   $myform->add("gram_skl_cont_id", "gram_skl_cont_id", 1, 0, $gram_skl_cont_id, 0, "", 0, "");
   $myform->add("gram_title", "gram_title", 0, 0, "", 0, "", 0, "");
   $myform->add("gram_content_vi","gram_content_vi",0,0,"",0,"",0,"");
   $myform->add("gram_media_type","gram_media_type",1,0,"",0,"",0,"");
   $myform->add("gram_exam","gram_exam",0,0,"",0,"",0,"");
   $myform->add("gram_order", "gram_order", 1, 0, 0, 0, "", 0, "");
   //$myform->add("com_cou_id","com_cou_id",1,0,$iParent,0,"",0,"");
   //Add table
   $myform->addTable("grammar_lesson");
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
            delete_file("grammar_lesson","gram_id",$record_id,"gram_media_url",$mediapath);
            $myform->add("gram_media_url","filename",0,1,0,0);
            foreach($arr_resize as $type => $arr){
               resize_image($mediapath, $filename, $arr["width"], $arr["height"], $arr["quality"], $type);
            }
         }
         if($filenameAudio != ""){
             delete_file("grammar_lesson","gram_id",$record_id,"gram_audio_url",$mediapath);
             $myform->add("gram_audio_url","filenameAudio",0,1,0,0);
         }	
         $fs_errorMsg .= $upload->show_warning_error();
         //kiểm tra chuỗi thông báo lỗi. Nếu ko có lỗi => thực hiện insert vào database	
         if($fs_errorMsg == ""){
            $myform->removeHTML(0);
            $db_ex = new db_execute_return();
            $last_id = $db_ex->db_execute($myform->generate_update_SQL("gram_id", $record_id));
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
$db_data 	= new db_query("SELECT * FROM grammar_lesson WHERE gram_id = " . $record_id);
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
	<?=$form->select_db_multi("Chọn danh mục", "cat_parent_id", "cat_parent_id", $listAll, "cat_id", "cat_name", $cat_parent_id, "Chọn chuyên mục cha", 1, "", 1, 0, "onChange=\"window.location.href='add.php?cat_parent_id='+this.value\"", "")?>
   
   <tr>
      <td align="right" style="font-size: 13px; color:#004000;">Chọn bài học :</td>
      <td align="left">
         <select id="skl_cont_les_id" name="skl_cont_les_id" class="form_control" onChange="window.location.href='add.php?skl_cont_les_id='+this.value+'&cat_parent_id=<?php echo $cat_parent_id; ?>'">
            <option value="">Chọn bài học</option>
            <?
               while($row_lesson = mysql_fetch_assoc($db_lesson->result)){
            ?>
                  <option value="<?=$row_lesson['skl_les_id']?>" <? if($row_lesson['skl_les_id'] == $idLesson) echo "selected = 'selected'"?>><?=$row_lesson['skl_les_name']?></option>
            <?      
              }unset($db_lesson); 
            ?>
         </select>
      </td>
      <td></td>
   </tr>
   <tr>
      <td align="right" style="font-size: 13px; color:#004000;">Chọn Content :</td>
      <td align="left">
         <select id="main_type" name="main_type" class="form_control">
            <option value="">Chọn Content</option>
            <?
               while($row_content = mysql_fetch_assoc($db_content->result)){
            ?>
                  <option value="<?=$row_content['skl_cont_id']?>" <? if($row_content['skl_cont_id'] == $idContent) echo "selected = 'selected'";?>><?echo "Content số ".$row_content['skl_cont_order'];?></option>
            <?      
              }unset($db_content); 
            ?>
         </select>
      </td>
      <td></td>
   </tr>
   <?=$form->radio("Chọn kiểu media","gram_media_type","gram_media_type",1,$gram_media_type,"Ảnh",0,"","")?>
   <?=$form->radio("","gram_media_type","gram_media_type",2,$gram_media_type,"Video",0,"","")?>
   <?=$form->radio("","gram_media_type","gram_media_type",3,$gram_media_type,"Flash",0,"","")?>
   <?=$form->getFile("Media", "gram_media_url", "gram_media_url", "Media", 0, 30, "", "")?>
   <?=$form->getFile("Audio", "gram_audio_url", "gram_audio_url", "Audio", 0, 30, "", "")?>
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