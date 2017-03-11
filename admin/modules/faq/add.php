<?
require_once("inc_security.php");
//check quyền them sua xoa
checkAddEdit("add");

   //Khai bao Bien
   $fs_title = $module_name . " | Thêm mới";
   $fs_redirect = "add.php";
   $after_save_data = getValue("after_save_data", "str", "POST", "add.php");
   $cat_parent_id	= getValue("cat_parent_id","str","GET","");
   $menu = new menu();
   $sql = '1';
   $listAll = $menu->getAllChild("categories_multi","cat_id","cat_parent_id","0",$sql . " AND lang_id = " . $lang_id . $sqlcategory,"cat_id,cat_name,cat_order,cat_type,cat_parent_id,cat_has_child","cat_order ASC, cat_name ASC","cat_has_child");
	
   //Call Class generate_form();
	if($cat_parent_id != "") $sqlCourse	= new db_query("SELECT cou_id,cou_name,cou_lev_id FROM courses WHERE cou_cat_id = ".$cat_parent_id );
	$myform = new generate_form();
   
   //print_r($listCourse);
	//Loại bỏ chuc nang thay the Tag Html
   $myform -> removeHTML(0);
   $myform -> add("com_cou_id", "com_cou_id", 1, 0, 0, 1, "Bạn chưa chọn Course", 0, "");
   $myform -> add("com_name","com_name",0,0,"",1,translate_text("Vui lòng nhập tên Unit"),0,"");
   $myform -> add("com_num_unit","com_num_unit",1,0,"",1,translate_text("Vui lòng nhập số thứ tự cho Unit"),0,"");
   $myform -> add("com_content","com_content",0,0,"",1,translate_text("Vui lòng nhập mô tả cho Unit"),0,"");
   $myform -> add("title", "title", 0, 0, "", 1, "Bạn chưa nhập title của khóa học để SEO", 0, "");
   $myform -> add("keywords", "keywords", 0, 0, "", 1, "Bạn chưa nhập keywords của khóa học", 0, "");
   $myform -> add("description", "description", 0, 0, "", 1, "Bạn chưa nhập description của khóa học", 0, "");
   $myform -> add("com_active", "com_active", 0, 0, 0, 0, "", 0, "");
	
	$myform->addTable($fs_table);
	$fs_errorMsg = "";
	$action	= getValue("action", "str", "POST", "");
   if($action == "execute"){
    
   //Check form data : kiêm tra lỗi
   $fs_errorMsg .= $myform->checkdata(); 
      if($fs_errorMsg == ""){
         $upload		= new upload("com_picture", $imgpath, $fs_extension, $fs_filesize);
         $filename	= $upload->file_name;
         if($filename != ""){
            $myform->add("com_picture","filename",0,1,0,0);
            foreach($arr_resize as $type => $arr){
            	resize_image($imgpath, $filename, $arr["width"], $arr["height"], $arr["quality"], $type);
            }
         }else{
            $fs_errorMsg .= "Bạn chưa nhập ảnh đại diện cho Unit!";
         }	
       	$fs_errorMsg .= $upload->show_warning_error();
         if($fs_errorMsg == ""){     
            $myform->removeHTML(0);
            $db_insert = new db_execute_return();
		      $last_test_id = $db_insert->db_execute($myform->generate_insert_SQL());
            unset($db_insert);
            for($i = 0; $i < 3; $i++){
               $les_det_type = $i + 1;
               $myform_type = new generate_form();  
               $myform_type->add("les_com_id	", "last_test_id", 1, 1, 0, 0, "", 0, ""); 
               $myform_type->add("les_det_type", "les_det_type", 1, 1, 0, 0, "", 0, "");   
            	$myform_type->addTable("lesson_details");
               $myform->removeHTML(0);
            	$db_insert_type = new db_execute($myform_type->generate_insert_SQL());
               unset($db_insert_type);
            }
            $exe_type = 0;
            $exe_type_lesson = 0;
            $exe_date = time();
            $exe_active = 1;
            $exe_name = "Quiz Unit";
            $myform_exe = new generate_form();
            $myform_exe->add("exe_com_id","last_test_id",1,1,"",1,"",0,"");
            $myform_exe->add("exe_name","exe_name",0,1,"",1,"Bạn chưa nhập tên [Quiz]",0,"");
            $myform_exe->add("exe_type","exe_type",1,1,0,0,"",0,"");
            $myform_exe->add("exe_type_lesson","exe_type_lesson",1,1,0,0,"",0,"");
            $myform_exe->add("exe_date","exe_date",1,1,0,0,"",0,"");
            $myform_exe->add("exe_active","exe_active",1,1,0,0,"",0,"");
            $myform_exe->addTable("exercises");
            $myform->removeHTML(0);
            $db_insert_exe = new db_execute($myform_exe->generate_insert_SQL());
            unset($db_insert_exe);
            redirect("add.php");
    		}
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
<? $myform->checkjavascript();?>
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
   	<?=$form->text_note('Những ô dấu (<font class="form_asterisk">*</font>) là bắt buộc phải nhập.')?>
   	<?=$form->errorMsg($fs_errorMsg)?>
   	<?=$form->select_db_multi("Chọn chuyên mục cha", "cat_parent_id", "cat_parent_id", $listAll, "cat_id", "cat_name", $cat_parent_id, "Chọn chuyên mục cha", 0, "", 1, 0, "onChange=\"window.location.href='add.php?cat_parent_id='+this.value\"", "")?>
       <? //$form->select_db_multi("Chọn Course", "com_cou_id", "com_cou_id", $listCourse, "cou_id", "cou_name", $com_cou_id, "Chọn Course", 1, "", 1, 0, "", "")?>
       <tr>
           <td align="right" nowrap="" class="form_name"><font class="form_asterisk">* </font> <?=translate_text("Chọn Course")?> :</td>
           <td>
               <select name="com_cou_id" id="com_cou_id"  class="form_control" style="width: 300px;">
   				<option value="-1">- <?=translate_text("Chọn Course")?> - </option>
   				<?
   				while($row = mysql_fetch_assoc($sqlCourse->result)){
   				   
   				?>
   				<option value="<?=$row['cou_id']?>" ><? echo nameLevel($row['cou_lev_id']).' -- '.$row['cou_name']?></option>
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
       <?=$form->getFile("Ảnh Unit", "com_picture", "com_picture", "Ảnh Unit", 1, 30, "", "")?>
       <?=$form->checkbox("Hiển thị", "com_active", "com_active", 1 ,$com_active, "lựa chọn hiển thị ", "", "", "", "", "", "", "")?>
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