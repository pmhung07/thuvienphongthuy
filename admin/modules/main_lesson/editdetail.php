<?
require_once("inc_security.php");
//check quy?n them sua xoa
checkAddEdit("edit");

   //Khai bao Bien
   $fs_redirect = base64_decode(getValue("returnurl","str","GET",base64_encode("listing.php")));
   $record_id = getValue("record_id");
   $cat_parent_id = getValue("cat_parent_id","str","GET","");
   $com_cou_id = getValue("com_cou_id","str","GET","");
   $les_com_id = getValue("les_com_id","str","GET","");
   $media_type = getValue("main_media_type");
   $main_type = getValue("main_type");
   $db_nlesson = new db_query("SELECT les_com_id,les_det_id FROM  main_lesson,lesson_details
                               WHERE main_lesson.main_det_id = lesson_details.les_det_id
                               AND   main_lesson.main_id = ".$record_id);
   while($rownL = mysqli_fetch_array($db_nlesson->result)){
      $idLesson = $rownL['les_det_id'];
      $main_det_id = $idLesson ;
   }

   $db_dataMain = new db_query("SELECT les_com_id,les_det_id,com_cou_id,com_id FROM  lesson_details,courses_multi
                                WHERE lesson_details.les_com_id = courses_multi.com_id
                                AND   lesson_details.les_det_id = ".$idLesson );

   while($rowC = mysqli_fetch_array($db_dataMain->result)){
          $les_com_id = $rowC['les_com_id'];
          $com_cou_id = $rowC['com_cou_id'];

          $db_course = new db_query("SELECT courses.cou_cat_id,courses.cou_id,courses_multi.com_id,courses.cou_lev_id
                           	       FROM  courses,courses_multi
                                     WHERE courses.cou_id = courses_multi.com_cou_id
                                     AND   courses_multi.com_id = ".$les_com_id);
           while($rowD = mysqli_fetch_array($db_course->result)){
              $cat_parent_id = $rowD['cou_cat_id'];
           }

   }
   unset($db_dataMain);
   unset($db_course);
   $com_c_id = $com_cou_id;
   $menu = new menu();
   $sql = '1';
   $listAll = $menu->getAllChild("categories_multi","cat_id","cat_parent_id","0",$sql . " AND lang_id = " . $lang_id . $sqlcategory,"cat_id,cat_name,cat_order,cat_type,cat_parent_id,cat_has_child","cat_order ASC, cat_name ASC","cat_has_child");

   $array_unit[""] = "Chọn Unit";
   if($com_cou_id > 0){
      $unit_select = new db_query("SELECT com_id,com_name FROM courses_multi
                                   WHERE com_cou_id =" .$com_cou_id. " AND com_active = 1");
      while($row_unit = mysqli_fetch_assoc($unit_select->result)){
         $array_unit[$row_unit["com_id"]] = $row_unit["com_name"];
      }unset($unit_select);
   }

   //Call Class generate_form()
   if($cat_parent_id != "")  $sqlCourse = new db_query("SELECT cou_id,cou_name,cou_lev_id FROM courses WHERE cou_cat_id = ".$cat_parent_id );
   //Khai bao mang kieu bai hoc chinh
   $array_main_type 		= array(0 => translate_text("Ẩn")
                               ,1 => translate_text("Hiển thị")
                                );
   $myform = new generate_form();
   //Loại bỏ chuc nang thay the Tag Html
   $myform->removeHTML(0);
   $myform->add("main_det_id", "main_det_id", 1, 0, $main_det_id, 0, "", 0, "");
   $myform->add("main_content_en","main_content_en",0,0,"",1,translate_text("Bạn chưa nhập nội dung tiếng Anh"),0,"");
   $myform->add("main_content_vi","main_content_vi",0,0,"",1,translate_text("Bạn chưa nhập nội dung tiếng Việt"),0,"");
   $myform->add("main_media_type","main_media_type",0,0,"",0,"","","");
   $myform->add("main_type","main_type",1,0,0,0);
   $myform->add("main_order", "main_order", 1, 0, 0, 0, "", 0, "");
   //$myform->add("com_cou_id","com_cou_id",1,0,$iParent,0,"",0,"");
   //Add table
	$myform->addTable("main_lesson");
	//Warning Error!
   $errorMsg = "";
	$fs_errorMsg = "";
	//Get Action.
	$action	= getValue("action", "str", "POST", "");
   if($action == "execute"){
      //Check form data : kiêm tra lỗi
      $fs_errorMsg .= $myform->checkdata();
      if($fs_errorMsg == ""){
         $upload1		    = new upload("main_media_url1", $imgpath, $fs_extension, $fs_filesize);
         $filename1	= $upload1->file_name;
         if($filename1 != ""){
            if($filename1 != $main_media_url1) delete_file("main_lesson","main_id",$record_id,"main_media_url1",$imgpath);
            $myform->add("main_media_url1","filename1",0,1,0,0);
            foreach($arr_resize as $type => $arr){
         	resize_image($imgpath, $filename1, $arr["width"], $arr["height"], $arr["quality"], $type);
            }
         }
         $fs_errorMsg .= $upload1->show_warning_error();
         //================================================================================//
         /*
         $upload2	    = new upload("main_media_url2", $imgpath, $fs_extension, $fs_filesize);
         $filename2	= $upload2->file_name;
         if($filename2 != ""){
         if($filename2 != $main_media_url2) delete_file("main_lesson","main_id",$record_id,"main_media_url2",$imgpath);
         $myform->add("main_media_url2","filename2",0,1,0,0);
            foreach($arr_resize as $type => $arr){
         	resize_image($imgpath, $filename2, $arr["width"], $arr["height"], $arr["quality"], $type);
            }
         }
         $fs_errorMsg .= $upload2->show_warning_error();
         //================================================================================//

         $upload3		    = new upload("main_media_url3", $imgpath, $fs_extension, $fs_filesize);
 			$filename3	= $upload3->file_name;
         if($filename3 != ""){
            if($filename3 != $main_media_url3) delete_file("main_lesson","main_id",$record_id,"main_media_url3",$imgpath);
 			   $myform->add("main_media_url3","filename3",0,1,0,0);
 		      foreach($arr_resize as $type => $arr){
				resize_image($imgpath, $filename3, $arr["width"], $arr["height"], $arr["quality"], $type);
			   }
 		   }
         $fs_errorMsg .= $upload3->show_warning_error();
         //==================================================================================//

         $upload4		    = new upload("main_media_url4", $imgpath, $fs_extension, $fs_filesize);
 			$filename4	= $upload4->file_name;
         if($filename4 != ""){
            if($filename4 != $main_media_url4) delete_file("main_lesson","main_id",$record_id,"main_media_url4",$imgpath);
 			   $myform->add("main_media_url4","filename4",0,1,0,0);
 		      foreach($arr_resize as $type => $arr){
				resize_image($imgpath, $filename4, $arr["width"], $arr["height"], $arr["quality"], $type);
            }
 		   }
         $fs_errorMsg .= $upload4->show_warning_error();
         //=================================================================================//

         $upload5		    = new upload("main_media_url5", $imgpath, $fs_extension, $fs_filesize);
 			$filename5	= $upload5->file_name;
         if($filename5 != ""){
 			   if($filename5 != $main_media_url5) delete_file("main_lesson","main_id",$record_id,"main_media_url5",$imgpath);
            $myform->add("main_media_url5","filename5",0,1,0,0);
 		      foreach($arr_resize as $type => $arr){
				resize_image($imgpath, $filename5, $arr["width"], $arr["height"], $arr["quality"], $type);
			   }
 		   }
         $fs_errorMsg .= $upload5->show_warning_error();
    	*/
      //kiểm tra chuỗi thông báo lỗi. Nếu ko có lỗi => thực hiện insert vào database
         if($fs_errorMsg == ""){
            $myform->removeHTML(0);
    		   $db_ex 	= new db_execute_return();
			   $last_id = $db_ex->db_execute($myform->generate_update_SQL("main_id", $record_id));

            echo 'Đã cập nhật xong';
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
$db_data 	= new db_query("SELECT * FROM main_lesson  WHERE main_id = " . $record_id);
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
<?=template_top(translate_text("Edit_detail"))?>
<? /*------------------------------------------------------------------------------------------------*/ ?>
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
   <?=$form->select("Chọn Unit","les_com_id","les_com_id",$array_unit,$les_com_id,"Chọn Unit",1,"","")?>
   <tr>
         <td align="right" style="font-size: 13px; color:#004000;">Chọn kiểu bài học chính :</td>
         <td align="left">
            <select id="main_type" name="main_type" class="form_control">
               <option value="">Chọn kiểu bài học</option>
               <?
                  foreach($array_main_type as $key => $value){
               ?>
                     <option value="<?=$key?>" <? if($key == $main_type) echo "selected = 'selected'"?>><?=$value?></option>
               <?
                  }
               ?>
            </select>
         </td>
         <td></td>
      </tr>
   <tr>
   <td align="right" nowrap class="form_name" width="200"><font class="form_asterisk">* </font> <?=translate_text("Chọn kiểu media")?> :</td>
   <td>
   	<input type="radio" name="main_media_type" value="1" <? if($main_media_type == 1) echo 'checked="checked"' ?>  />Ảnh<br/>
      <input type="radio" name="main_media_type" value="2" <? if($main_media_type == 2) echo 'checked="checked"' ?> />Video<br/>
      <input type="radio" name="main_media_type" value="3" <? if($main_media_type == 3) echo 'checked="checked"' ?> />Flash<br/>
   </td>
   </tr>
   <?=$form->getFile("Media 1", "main_media_url1", "main_media_url1", "Media cho Bài học chính", 0, 30, "", "")?>
   <?//=$form->getFile("Media 2", "main_media_url2", "main_media_url2", "Media cho Bài học chính", 0, 30, "", "")?>
   <?//=$form->getFile("Media 3", "main_media_url3", "main_media_url3", "Media cho Bài học chính", 0, 30, "", "")?>
   <?//=$form->getFile("Media 4", "main_media_url4", "main_media_url4", "Media cho Bài học chính", 0, 30, "", "")?>
   <?//=$form->getFile("Media 5", "main_media_url5", "main_media_url5", "Media cho Bài học chính", 0, 30, "", "")?>
   <tr>
      <td colspan="2">
      <?=$form->wysiwyg("Nội dung tiếng anh", "main_content_en", $main_content_en,  "../../resource/wysiwyg_editor/", 800, 200)?>
      </td>
    </tr>
   <tr>
      <td colspan="2">
      <?=$form->wysiwyg("Nội dung tiếng việt", "main_content_vi", $main_content_vi, "../../resource/wysiwyg_editor/", 800, 200)?>
      </td>
   </tr>
   <?=$form->text("Thứ tự", "main_order", "main_order", $main_order, "Thứ tự", 0, 40, "", 255, "", "", "")?>
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