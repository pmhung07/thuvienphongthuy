<?
include("inc_security.php");
checkAddEdit("edit");

$fs_title			= $module_name . " | Sửa đổi";
$fs_action			= getURL();
$fs_errorMsg		= "";

$fs_redirect 	= base64_decode(getValue("url","str","GET",base64_encode("listing.php")));
$record_id 		= getValue("record_id");
//$pcat_id        = getValue("pcat_id");

$arrlanguage = array('1'=> 'MẪU CV TIẾNG VIỆT', '2' => 'MẪU CV TIẾNG ANH');

//Call class menu - lay ra danh sach Category
$sql = '1';
$menu 									= new menu();
$listAll 								= $menu->getAllChild("categories_multi","cat_id","cat_parent_id","0",$sql . " AND lang_id = " . $lang_id . $sqlcategory . " AND cat_type = 2","cat_id,cat_name,cat_order,cat_type,cat_parent_id,cat_has_child","cat_order ASC, cat_name ASC","cat_has_child");

	/*
	Call class form:
	1). Ten truong
	2). Ten form
	3). Kieu du lieu , 0 : string , 1 : kieu int, 2 : kieu email, 3 : kieu double, 4 : kieu hash password
	4). Noi luu giu data  0 : post, 1 : variable
	5). Gia tri mac dinh, neu require thi phai lon hon hoac bang default
	6). Du lieu nay co can thiet hay khong
	7). Loi dua ra man hinh
	8). Chi co duy nhat trong database
	9). Loi dua ra man hinh neu co duplicate
	*/
   $action = getValue("action", "str", "POST", "");

   if($action == "execute"){
     $post_cat_parent_id = 0;
     $post_cat_id = getValue("cv_cat_id", "int", "POST", 0);
     $post_cat_parent_id = $menu->getParentid('categories_multi','cat_id','cat_parent_id',$post_cat_id);
   }

   $cv_time = time(); 

   $myform = new generate_form();
   $myform->add("cv_cat_id","cv_cat_id",1,0,0,1,"Bạn chưa chọn danh mục",0,""); 
   $myform->add("cv_cat_parent_id","post_cat_parent_id",1,1,0,0,"Bạn chưa chọn danh mục",0,""); 
   $myform->add("cv_language","cv_language",1,0,0,0,"",0,""); 
   $myform->add("cv_name", "cv_name", 0, 0, "", 1, "Bạn chưa nhập tiêu đề CV", 0, "");
   $myform->add("cv_price", "cv_price", 0, 0, "", 1, "Bạn chưa nhập giá", 0, "");
   $myform->add("cv_info","cv_info", 0, 0,"", 0, "", 0, "");
   $myform->add("cv_time","cv_time", 0, 1,"", 0, "", 0, "");
   $myform->add("cv_active","cv_active",1,0,0,0,"",0,"");
   
   $myform->add("cv_meta_title","cv_meta_title",0,0,"",0,"",0,"");
   $myform->add("cv_meta_description","cv_meta_description",0,0,"",0,"",0,"");
   $myform->add("cv_meta_keywords","cv_meta_keywords",0,0,"",0,"",0,"");
	$myform->addTable($fs_table);

   $action = getValue("action", "str", "POST", "");
   if($action == "execute"){
   	$fs_errorMsg .= $myform->checkdata();
   	if($fs_errorMsg == ""){	   	
         
         $upload     = new upload("cv_avatar", $imgpath, $fs_extension, $fs_filesize);
         $filename   = $upload->file_name;
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
         	$db_ex = new db_execute($myform->generate_update_SQL($id_field, $record_id));
        		redirect($fs_redirect);	
         }         
   	}
   }
   $myform->addFormname("add_new");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<?=$load_header?>
<? 
$myform->checkjavascript(); 
//chuyển các trường thành biến để lấy giá trị thay cho dùng kiểu getValue
$myform->evaluate();
$fs_errorMsg .= $myform->strErrorField;
//lay du lieu cua record can sua doi
$db_data 	= new db_query("SELECT * FROM cover_letters 
                            INNER JOIN categories_multi ON cover_letters.cv_cat_id=categories_multi.cat_id 
                            WHERE " . $id_field . " = " . $record_id);
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
   <?=template_top($fs_title)?>
   <? /*------------------------------------------------------------------------------------------------*/ ?>
   <p align="center" style="padding-left:10px;">
   <?
   $form = new form();
   $form->create_form("add", $fs_action, "post", "multipart/form-data",'onsubmit="validateForm(); return false;"');
   $form->create_table();
   ?>
   <?=$form->text_note('<strong style="text-align:center;">----------Sửa đổi bài viết-----------</strong>')?>
   <?=$form->text_note('Những ô có dấu sao (<font class="form_asterisk">*</font>) là bắt buộc phải nhập.')?>
   <?=$form->errorMsg($fs_errorMsg)?>
   <?=$form->select_db_multi("Danh mục", "cv_cat_id", "cv_cat_id", $listAll, "cat_id", "cat_name", $cv_cat_id, "Chọn danh mục", 1, "", 1, 0, "", "")?>
   <?=$form->text("Tiêu đề", "cv_name", "cv_name", $cv_name, "Tiêu đề", 1, 250, "", 255, "", "", "")?>
   <?=$form->select("Chọn ngôn ngữ CV", "cv_language", "cv_language", $arrlanguage, $cv_language ,"Chọn ngôn ngữ",1,"498",1,0,"","")?>
   <?=$form->text("Giá", "cv_price", "cv_price", $cv_price, "Giá", 1, 250, "", 255, "", "", "")?>
   <?=$form->textarea("Mô tả","cv_info","cv_info",$cv_info,"Mô tả",0,255,100,"","","")?>
   <?=$form->getFile("Ảnh đại diện", "cv_avatar", "cv_avatar", "Chọn hình ảnh", 1, 40, "", "")?>
   <?=$form->getFile("Ảnh nội dung", "cv_imgcontent", "cv_imgcontent", "Chọn hình ảnh", 1, 40, "", "")?>
   <?=$form->getFile("Data", "cv_data", "cv_data", "Chọn data", 1, 40, "", "")?>
   <?=$form->text("Title", "cv_meta_title", "cv_meta_title", $cv_meta_title, "Tiêu đề", 1, 250, "", 255, "", "", "")?>
   <?=$form->text("Description", "cv_meta_description", "cv_meta_description", $cv_meta_description, "description", 1, 250, "", 255, "", "", "")?>
   <?=$form->text("Keywords", "cv_meta_keywords", "cv_meta_keywords", $cv_meta_keywords, "keywords", 1, 250, "", 255, "", "", "")?>
   <?=$form->checkbox("Kích hoạt", "cv_active", "cv_active", 1 ,$cv_active, "",0, "", "")?>
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