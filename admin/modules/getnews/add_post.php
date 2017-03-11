<?
   include("inc_security.php");
   require_once("../../../classes/tag.php");
   checkAddEdit("add");

   $fs_title = $module_name . " | Thêm mới";
   $fs_action = getURL();
   $fs_errorMsg = "";
   $add = "add.php";
   $listing = "listing.php";
   $fs_redirect 	= base64_decode(getValue("url","str","GET",base64_encode("listing.php")));
   $record_id 		= getValue("record_id");
   $tags          = getValue("post_tags","str","POST","");
   $title         = getValue("post_title","str","POST","");
   $desc          = getValue("post_description","str","POST","");
   $content       = getValue("post_content","str","POST","");
   $db_new = new db_query('SELECT * FROM '.$fs_table.'
                           WHERE 1 AND gen_id = '.$record_id);
   $list_new = mysql_fetch_assoc($db_new->result);
   //Lisr Danh muc
   $sql = '1';
   $menu = new menu();
   $listAll = $menu->getAllChild("post_category","pcat_id","pcat_parent_id","0",$sql . " AND lang_id = " . $lang_id . $sqlcategory,"pcat_id,pcat_name,pcat_order,pcat_type,pcat_parent_id,pcat_has_child","pcat_order ASC, pcat_name ASC","pcat_has_child");
   
   
     
    /*
	Call class form:
	1). Ten truong
	2). Ten form 
	3). Kieu du lieu , 0 : string , 1 : kieu int, 2 : kieu email, 3 : kieu double, 4 : kieu hash password
	4). Noi luu giu data  0 : post(sẽ tìm trong form ở dưới có cotrol nào có name đc khai báo ở (2)), 1 : variable (sẽ tìm những biến nào có tên đã đc khai báo ở (2) )
	5). Gia tri mac dinh, neu require thi phai lon hon hoac bang default
	6). Du lieu nay co can thiet hay khong (tương ứng với bên form bên dưới)
	7). Loi dua ra man hinh nếu mà ko nhập
	8). Chi co duy nhat trong database (0: cho phép trùng ; 1: ko cho phép)
	9). Loi dua ra man hinh neu co duplicate
	*/
   $post_time = time();  
   //tạo mới class generate_form 
   $myform = new generate_form();
   
   $myform->add("post_pcat_id","post_pcat_id",1,0,0,1,"Bạn chưa chọn danh mục",0,""); 
   $myform->add("post_title", "post_title", 0, 0, "", 1, "Bạn chưa nhập tiêu đề bài viết", 0, "");
   $myform->add("post_description","post_description", 0, 0,"", 0, "", 0, "");
   $myform->add("post_content", "post_content", 0, 0, "", 0, "",0, "");
   $myform->add("post_time","post_time", 0, 1,"", 0, "", 0, "");
   $myform->add("post_active","post_active",1,0,0,0,"",0,"");
   
   $myform->add("meta_title","meta_title",0,0,"",0,"",0,"");
   $myform->add("meta_description","meta_description",0,0,"",0,"",0,"");
   $myform->add("meta_keywords","meta_keywords",0,0,"",0,"",0,"");
   $myform->add("post_tags","post_tags", 0, 0,"", 0, "", 0, "");
   $myform->addTable('posts');

   $action			= getValue("action", "str", "POST", ""); 
   if($action == "execute"){
   	$fs_errorMsg .= $myform->checkdata();      
      if($fs_errorMsg == ""){
         $upload		= new upload("post_picture", $imgpath, $fs_extension, $fs_filesize);
         
         $filename	= $upload->file_name;
         
         if($filename != ""){
      		$myform->add("post_picture","filename",0,1,0,0);
      		foreach($arr_resize as $type => $arr){
      		   resize_image($imgpath, $filename, $arr["width"], $arr["height"], $arr["quality"], $type);
      		}
   		}else{
   		   $fs_errorMsg .= "Bạn chưa chọn ảnh đại diện cho bài viết ! </br>";
   		}
        
         $fs_errorMsg .= $upload->show_warning_error();
         	     
         if($fs_errorMsg == ""){
         	$myform->removeHTML(0);
            $db_insert = new db_execute_return();
            $last_id   = $db_insert->db_execute($myform->generate_insert_SQL());
            $db_move   = new db_execute('UPDATE get_new_db SET gen_move = 1 WHERE gen_id ='.$record_id);
            unset($db_move);
            unset($db_insert);
            //Lưu tag cho tin tức (Group type: 5, type: 1)
            if($tags != '') save_tags($last_id,$tags,5,1);
            else{
               $tags = new tag($last_id,$content,$title,$desc,5,1);
               $tags->insert_tag(2);
               unset($tags);
            }
         	redirect($fs_redirect);
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
  
	$form->create_form("add", $fs_action, "post", "multipart/form-data",'onsubmit="validateForm(); return false;"');
   $form->create_table();
	?>
   <?=$form->text_note('<strong style="text-align:center;">----------Thêm mới bài viết-----------</strong>')?>
   <?=$form->text_note('Những ô có dấu sao (<font class="form_asterisk">*</font>) là bắt buộc phải nhập.')?>
   <?=$form->errorMsg($fs_errorMsg)?>
   <?=$form->select_db_multi("Danh mục", "post_pcat_id", "post_pcat_id", $listAll, "pcat_id", "pcat_name", $post_pcat_id, "Chọn danh mục", 1, "", 1, 0, "", "")?>
   <?=$form->text("Tiêu đề bài viết", "post_title", "post_title", $list_new['gen_title'], "Tiêu đề", 1, 250, "", 255, "", "", "")?>
   <?=$form->textarea("Mô tả","post_description","post_description",removeHTML($list_new['gen_teaser']),"Mô tả",0,255,100,"","","")?>
   <?=$form->getFile("Ảnh đại diện", "post_picture", "post_picture", "Chọn hình ảnh", 1, 40, "", "")?>
   
   <?=$form->text("Title", "meta_title", "meta_title", $list_new['gen_title'], "Title", 0, 450, 24, 255, "", "", "")?>
   <?=$form->text("Description", "meta_description", "meta_description", removeHTML($list_new['gen_teaser']), "Description", 0, 450, 24, 255, "", "", "")?>
   <?=$form->text("Keywords", "meta_keywords", "meta_keywords", $meta_keywords, "Keywords", 0, 450,24, 255, "", "", "")?>
   <?=$form->text("Tags", "post_tags", "post_tags", $post_tags, "Tags", 0, 450,24, 255, "", "", "")?>
   <?=$form->close_table();?>
   <?=$form->wysiwyg("<font class='form_asterisk'>*</font> Nội dung bài viết ", "post_content", $list_new['gen_details'], "../../resource/wysiwyg_editor/", "99%", 450)?>
   <?=$form->create_table();?>
   <?=$form->checkbox("Kích hoạt", "post_active", "post_active", 1 ,$post_active, "",0, "", "")?>
   <?=$form->radio("Sau khi lưu dữ liệu", "add_new" . $form->ec . "return_listing", "after_save_data", $add . $form->ec . $listing, $fs_redirect, "Thêm mới" . $form->ec . "Quay về danh sách", 0, $form->ec, "");?>
   <?=$form->button("submit" . $form->ec . "reset", "submit" . $form->ec . "reset", "submit" . $form->ec . "reset", "Cập nhật" . $form->ec . "Làm lại", "Cập nhật" . $form->ec . "Làm lại", 'style="background:url(' . $fs_imagepath . 'button_1.gif) no-repeat"' . $form->ec . 'style="background:url(' . $fs_imagepath . 'button_2.gif)"', "");?>
   <?=$form->hidden("action", "action", "execute", "");?>
   <?
   $form->close_table();
   $form->close_form();
   unset($form);
   ?>
	</p>
<? /*------------------------------------------------------------------------------------------------*/ ?>
<?=template_bottom() ?>
<? /*------------------------------------------------------------------------------------------------*/ ?>
</body>
</html>