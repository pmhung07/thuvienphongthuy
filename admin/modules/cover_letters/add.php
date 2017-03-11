<?
   include("inc_security.php");
   checkAddEdit("add");

   $fs_title = $module_name . " | Thêm mới";
   $fs_action = getURL();
   $fs_errorMsg = "";
   $add = "add.php";
   $listing = "listing.php";
   $after_save_data = getValue("after_save_data", "str", "POST", "add.php");
   $fs_redirect     = $after_save_data;
   //Lisr Danh muc
   $sql = '1';
   $menu = new menu();
   $listAll = $menu->getAllChild("categories_multi","cat_id","cat_parent_id","0",$sql . " AND lang_id = " . $lang_id . $sqlcategory . " AND cat_type = 2","cat_id,cat_name,cat_order,cat_type,cat_parent_id,cat_has_child","cat_order ASC, cat_name ASC","cat_has_child");
     
   $arrlanguage = array('1'=> 'MẪU CV TIẾNG VIỆT', '2' => 'MẪU CV TIẾNG ANH');

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
   $action = getValue("action", "str", "POST", "");

   if($action == "execute"){
     $post_cat_parent_id = 0;
     $post_cat_id = getValue("cv_cat_id", "int", "POST", 0);
     $post_cat_parent_id = $menu->getParentid('categories_multi','cat_id','cat_parent_id',$post_cat_id);
   }

   $cv_time = time();  
   //tạo mới class generate_form 
   $myform = new generate_form();
   
   $myform->add("cv_cat_id","cv_cat_id",1,0,0,1,"Bạn chưa chọn danh mục",0,""); 
   $myform->add("cv_cat_parent_id","post_cat_parent_id",1,1,0,0,"Bạn chưa chọn danh mục",0,""); 
   $myform->add("cv_language","cv_language",1,0,0,0,"Bạn chưa chọn danh mục",0,""); 
   $myform->add("cv_name", "cv_name", 0, 0, "", 1, "Bạn chưa nhập tiêu đề CV", 0, "");
   $myform->add("cv_price", "cv_price", 1, 0, "", 1, "Bạn chưa nhập giá", 0, "");
   $myform->add("cv_info","cv_info", 0, 0,"", 0, "", 0, "");
   $myform->add("cv_time","cv_time", 0, 1,"", 0, "", 0, "");
   $myform->add("cv_active","cv_active",1,0,0,0,"",0,"");
   
   $myform->add("cv_meta_title","cv_meta_title",0,0,"",0,"",0,"");
   $myform->add("cv_meta_description","cv_meta_description",0,0,"",0,"",0,"");
   $myform->add("cv_meta_keywords","cv_meta_keywords",0,0,"",0,"",0,"");
   $myform->addTable($fs_table);

   $action			= getValue("action", "str", "POST", ""); 
   if($action == "execute"){
   	$fs_errorMsg .= $myform->checkdata();      
      if($fs_errorMsg == ""){
         $upload		= new upload("cv_avatar", $imgpath, $fs_extension, $fs_filesize);
         $filename	= $upload->file_name;
         if($filename != ""){
      		$myform->add("cv_avatar","filename",0,1,0,0);
      		foreach($arr_resize as $type => $arr){
      		   resize_image($imgpath, $filename, $arr["width"], $arr["height"], $arr["quality"], $type);
      		}
   		}

         $uploadimgcontent     = new upload("cv_imgcontent", $datapath, $fs_extension, $fs_filesize);
         $filenameimgcontent   = $uploadimgcontent->file_name;
         if($filenameimgcontent != ""){
            $myform->add("cv_imgcontent","filenameimgcontent",0,1,0,0);
            foreach($arr_resize as $type => $arr){
               resize_image($imgpath, $filename, $arr["width"], $arr["height"], $arr["quality"], $type);
            }
         }

         $uploaddatadata     = new upload("cv_data", $datapath, $fs_extension, $fs_filesize);
         $filenamedata   = $uploaddatadata->file_name;
         if($filenamedata != ""){
            $myform->add("cv_data","filenamedata",0,1,0,0);
         }
        
         $fs_errorMsg .= $upload->show_warning_error();
         	     
         if($fs_errorMsg == ""){
         	$myform->removeHTML(0);
            $db_insert = new db_execute_return();
            $last_id   = $db_insert->db_execute($myform->generate_insert_SQL());
            unset($db_insert);
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
   <?=$form->select_db_multi("Danh mục", "cv_cat_id", "cv_cat_id", $listAll, "cat_id", "cat_name", $cv_cat_id, "Chọn danh mục", 1, "", 1, 0, "", "")?>
   <?=$form->select("Chọn ngôn ngữ CV", "cv_language", "cv_language", $arrlanguage, 0 ,"Chọn ngôn ngữ",1,"498",1,0,"","")?>
   <?=$form->text("Tiêu đề", "cv_name", "cv_name", $cv_name, "Tiêu đề", 1, 250, "", 255, "", "", "")?>
   <?=$form->text("Giá", "cv_price", "cv_price", $cv_price, "Giá", 1, 250, "", 255, "", "", "")?>
   <?=$form->textarea("Mô tả","cv_info","cv_info",$cv_info,"Mô tả",0,255,100,"","","")?>
   <?=$form->getFile("Ảnh đại diện", "cv_avatar", "cv_avatar", "Chọn hình ảnh", 1, 40, "", "")?>
   <?=$form->getFile("Ảnh nội dung", "cv_imgcontent", "cv_imgcontent", "Chọn hình ảnh", 1, 40, "", "")?>
   <?=$form->getFile("Dữ liệu", "cv_data", "cv_data", "Chọn hình ảnh", 1, 40, "", "")?>
   
   <?=$form->text("Title", "cv_meta_title", "cv_meta_title", $cv_meta_title, "Title", 0, 450, 24, 255, "", "", "")?>
   <?=$form->text("Description", "cv_meta_description", "cv_meta_description", $cv_meta_description, "Description", 0, 450, 24, 255, "", "", "")?>
   <?=$form->text("Keywords", "cv_meta_keywords", "cv_meta_keywords", $cv_meta_keywords, "Keywords", 0, 450,24, 255, "", "", "")?>
   <?=$form->checkbox("Kích hoạt", "cv_active", "cv_active", 1 ,$cv_active, "",0, "", "")?>
   <?=$form->radio("Sau khi lưu dữ liệu", "add_new" . $form->ec . "return_listing", "after_save_data", $add . $form->ec . $listing, $after_save_data, "Thêm mới" . $form->ec . "Quay về danh sách", 0, $form->ec, "");?>
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