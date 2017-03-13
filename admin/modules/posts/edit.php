<?
include("inc_security.php");
checkAddEdit("edit");

$fs_title			= $module_name . " | Sửa đổi";
$fs_action			= getURL();
$fs_errorMsg		= "";

$fs_redirect 	= base64_decode(getValue("url","str","GET",base64_encode("listing.php")));
$record_id 		= getValue("record_id");
//$pcat_id        = getValue("pcat_id");



//Call class menu - lay ra danh sach Category
$sql = '1';
$menu 									= new menu();
$listAll 								= $menu->getAllChild("categories_multi","cat_id","cat_parent_id","0",$sql . " AND lang_id = " . $lang_id . $sqlcategory . " AND cat_type = 3","cat_id,cat_name,cat_order,cat_type,cat_parent_id,cat_has_child","cat_order ASC, cat_name ASC","cat_has_child");
$listAllRelated                  = $menu->getAllChild("categories_multi","cat_id","cat_parent_id","0",$sql . " AND lang_id = " . $lang_id . $sqlcategory,"cat_id,cat_name,cat_order,cat_type,cat_parent_id,cat_has_child","cat_order ASC, cat_name ASC","cat_has_child");

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
     $post_cat_id = getValue("cat_id", "int", "POST", 0);
     $post_cat_parent_id = $menu->getParentid('categories_multi','cat_id','cat_parent_id',$post_cat_id);
   }

   $myform = new generate_form();
   $myform->add("post_cat_id","post_cat_id",1,0,0,1,"Bạn chưa chọn danh mục",0,"");
   $myform->add("post_cat_parent_id","post_cat_parent_id",1,1,0,0,"Bạn chưa chọn danh mục",0,"");
   $myform->add("post_cat_related_id","post_cat_related_id",1,0,0,0,"Bạn chưa chọn danh mục",0,"");
   $myform->add("post_title", "post_title", 0, 0, "", 1, "Bạn chưa nhập tiêu đề bài viết", 0, "");
   $myform->add("post_description","post_description", 0, 0,"", 0, "", 0, "");
   $myform->add("post_content", "post_content", 0, 0, "", 0, "",0, "");
   $myform->add("post_active","post_active",1,0,0,0,"",0,"");

   $myform->add("post_meta_title","post_meta_title",0,0,"",0,"",0,"");
   $myform->add("post_meta_description","post_meta_description",0,0,"",0,"",0,"");
   $myform->add("post_meta_keywords","post_meta_keywords",0,0,"",0,"",0,"");
	$myform->addTable($fs_table);
   $action = getValue("action", "str", "POST", "");
   if($action == "execute"){
   	$fs_errorMsg .= $myform->checkdata();
   	if($fs_errorMsg == ""){
         $upload = new upload("post_picture", $imgpath, $fs_extension, $fs_filesize );

         $filename = $upload->file_name;

   		if($filename != ""){
            delete_file($fs_table,$id_field,$record_id,"post_picture",$imgpath);
   			$myform->add("post_picture","filename", 0, 1, "", 0);
   			foreach($arr_resize as $type=>$arr){
   				resize_image($imgpath, $filename, $arr["width"], $arr["height"], $arr["quality"], $type);
   			}
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
$db_data 	= new db_query("SELECT * FROM posts
                            INNER JOIN categories_multi ON posts.post_cat_id=categories_multi.cat_id
                            WHERE " . $id_field . " = " . $record_id);
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
   <?=$form->select_db_multi("Danh mục", "post_cat_id", "post_cat_id", $listAll, "cat_id", "cat_name", $post_cat_id, "Chọn danh mục", 1, "", 1, 0, "", "")?>
   <?=$form->select_db_multi("Related", "post_cat_related_id", "post_cat_related_id", $listAllRelated, "cat_id", "cat_name", $post_cat_related_id, "Chọn danh mục", 1, "", 1, 0, "", "")?>
   <?=$form->text("Tiêu đề bài viết", "post_title", "post_title", $post_title, "Tiêu đề", 1, 250, "", 255, "", "", "")?>
   <?=$form->textarea("Mô tả","post_description","post_description",$post_description,"Mô tả",0,255,100,"","","")?>
   <?=$form->getFile("Ảnh đại diện", "post_picture", "post_picture", "Chọn hình ảnh", 1, 40, "", "")?>

   <?=$form->text("Title", "post_meta_title", "post_meta_title", $post_meta_title, "Tiêu đề", 1, 250, "", 255, "", "", "")?>
   <?=$form->text("Description", "post_meta_description", "post_meta_description", $post_meta_description, "description", 1, 250, "", 255, "", "", "")?>
   <?=$form->text("Keywords", "post_meta_keywords", "post_meta_keywords", $post_meta_keywords, "keywords", 1, 250, "", 255, "", "", "")?>
   <tr>
      <td class="form_name">Nội dung</td>
      <td class="form_text">
         <textarea class="post_content" id="post_content" name="post_content" style="height: 400px;"><?=$post_content?></textarea>
         <script src="/../../js/tinymce/tinymce.min.js" type="text/javascript" charset="utf-8"></script>
         <script type="text/javascript">
         tinymce.init({
            selector: "textarea",
            plugins: [
               "advlist autolink lists link image charmap print preview hr anchor pagebreak",
               "searchreplace wordcount visualblocks visualchars code fullscreen",
               "insertdatetime media nonbreaking save table contextmenu directionality",
               "emoticons template paste textcolor jbimages"
            ],
            toolbar1: "cut copy paste pastetext pasteword | insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | tablecontrols | bullist numlist outdent indent | link image ",
            toolbar2: "print preview media | forecolor backcolor emoticons jbimages |styleselect formatselect fontselect fontsizeselect",
            image_advtab: true,
            templates: [
               {title: 'Test template 1', content: 'Test 1'},
               {title: 'Test template 2', content: 'Test 2'}
            ]
         });
         </script>
      </td>
   </tr>
   <?=$form->checkbox("Kích hoạt", "post_active", "post_active", 1 ,$post_active, "",0, "", "")?>
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