<?
require_once("inc_security.php");
//check quyền them sua xoa
checkAddEdit("add");

	//Khai bao Bien
   $fs_title = $module_name . " | Thêm mới";
	$fs_redirect = "add.php";
	$after_save_data = getValue("after_save_data", "str", "POST", "add.php");
   $tags            = getValue("lib_song_tags","str","POST",""); 
   $title           = getValue("lib_song_title","str","POST","");
   $info            = getValue("lib_song_info","str","POST","");
   $lib_cat_id      = getValue("lib_cat_id","int","POST",0);  
   $sql = "lib_cat_type = 3";
   $menu 	= new menu();
   $listAll = $menu->getAllChild("library_cate","lib_cat_id","lib_cat_parent_id","0",$sql . " AND lang_id = " . $lang_id . $sqlcategory,"lib_cat_id,lib_cat_name,lib_cat_order,lib_cat_type,lib_cat_parent_id,lib_cat_has_child","lib_cat_order ASC, lib_cat_name ASC","lib_cat_has_child");
	
   $myform = new generate_form(); 
	//Loại bỏ chuc nang thay the Tag Html
	$myform->removeHTML(0);
   $myform->add("lib_song_catid","lib_cat_id",0,0,"",1,"Bạn chưa chọn danh mục bài hát",0,"");
	$myform->add("lib_song_title","lib_song_title",0,0,"",1,translate_text("Vui lòng nhập tiêu đề bài hát"),0,"");
   $myform->add("lib_song_info","lib_song_info",0,0,"",1,translate_text("Vui lòng nhập giới thiệu"),0,"");
   $myform->add("lib_song_en","lib_song_en",0,0,"",1,translate_text("Vui lòng nhập lời bài hát tiếng anh"),0,"");
   $myform->add("lib_song_vi","lib_song_vi",0,0,"",1,translate_text("Vui lòng nhập lời bài hát tiếng việt"),0,"");
   $myform->add("meta_title","meta_title",0,0,"",0,"",0,"");
   $myform->add("meta_description","meta_description",0,0,"",0,"",0,"");
   $myform->add("meta_keywords","meta_keywords",0,0,"",0,"",0,"");
   $myform->add("lib_song_tags","lib_song_tags",0,0,"",0,"",0,"");
	//$myform->add("com_active", "com_active", 0, 0, 0, 0, "", 0, "");
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
         $upload		= new upload("lib_song_image", $imgpath, $fs_extension, $fs_filesize);
         $filename	= $upload->file_name;
         if($filename != ""){
            $myform->add("lib_song_image","filename",0,1,0,0);
            foreach($arr_resize as $type => $arr){
            	resize_image($imgpath, $filename, $arr["width"], $arr["height"], $arr["quality"], $type);
            }
         }	
         $fs_errorMsg .= $upload->show_warning_error();
         $uploadAudio = new upload("lib_song_url", $songpath, $fs_extension, $fs_filesize);
         $filenameAudio	= $uploadAudio->file_name;
         if($filenameAudio != ""){
         	$myform->add("lib_song_url","filenameAudio",0,1,0,0);
         }	
         $fs_errorMsg .= $uploadAudio->show_warning_error();
         //kiểm tra chuỗi thông báo lỗi. Nếu ko có lỗi => thực hiện insert vào database	
         if($fs_errorMsg == ""){
            //Insert to database 
            $myform->removeHTML(0);//loại bỏ  các ký tự html( 0 thi ko loại bỏ, 1: bỏ) tránh lỗi 
            //thực hiện insert 
            $db_insert = new db_execute_return();
            $last_id   = $db_insert->db_execute($myform->generate_insert_SQL());
            //unset biến để giải phóng bộ nhớ.
            unset($db_insert);
            //Lưu tag cho bài hát (Group type:4, type:3)
            if($tags == ''){
               $tags = gen_str_cate($lib_cat_id,'library_cate','lib_cat_id','lib_cat_parent_id','lib_cat_name');
            }
            save_tags($last_id,$tags,4,3);
            //Redirect after insert complate
            //$fs_redirect = "add.php?order=" . (getValue("cur_order","int","POST") + 1);
            redirect("add.php");
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
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<?=$load_header?>
<? $myform->checkjavascript();?>
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
         <?=$form->select_db_multi("Danh mục bài hát", "lib_cat_id", "lib_cat_id", $listAll, "lib_cat_id", "lib_cat_name", $lib_cat_id, "Chọn danh mục", 1, "", 1, 0, "", "")?>
         <?=$form->text("Tiêu đề bài hát", "lib_song_title", "lib_song_title", $lib_song_title, "Tiêu đề bài hát", 1, 250, "", 255, "", "", "")?>
         <?=$form->getFile("Ảnh đại diện", "lib_song_image", "lib_song_image", "Ảnh đại diện", 1, 30, "", "")?>
         <?=$form->getFile("Bài hát", "lib_song_url", "lib_song_url", "Bài hát", 1, 30, "", "")?>
         <?=$form->textarea("Giới thiệu", "lib_song_info", "lib_song_info", $lib_song_info, "Giới thiệu", 1, 400, 60, "", "", "")?>
         <tr>
           <td colspan="2"> 
           <?=$form->wysiwyg("Lời tiếng anh", "lib_song_en", $lib_song_en,  "../../resource/wysiwyg_editor/", 800, 200)?>
           </td>
         </tr>
         <tr>
           <td colspan="2"> 
           <?=$form->wysiwyg("Lời tiếng việt", "lib_song_vi", $lib_song_vi, "../../resource/wysiwyg_editor/", 800, 200)?>
           </td>
         </tr>
         <?=$form->text("Title", "meta_title", "meta_title", $meta_title, "Title", 0, 450, 24, 255, "", "", "")?>
         <?=$form->text("Description", "meta_description", "meta_description", $meta_description, "Description", 0, 450, 24, 255, "", "", "")?>
         <?=$form->text("Keywords", "meta_keywords", "meta_keywords", $meta_keywords, "Keywords", 0, 450,24, 255, "", "", "")?>
         <?=$form->text("Tags", "lib_song_tags", "lib_song_tags", $lib_song_tags, "Tags", 0, 450,24, 255, "", "", "<span  style=\"color: red;padding-left: 10px;\" >(Các từ khóa viết thường, cách nhau bằng dấu \",\")</span>")?>
         <?//$form->checkbox("Hiển thị", "com_active", "com_active", 1 ,$com_active, "lựa chọn hiển thị ", "", "", "", "", "", "", "")?>
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