<?
include("inc_security.php");
checkAddEdit("edit");

$fs_title			= $module_name . " | Sửa đổi";
$fs_action			= getURL();
$fs_errorMsg		= "";

$fs_redirect 	= base64_decode(getValue("url","str","GET",base64_encode("listing.php")));
$record_id 		= getValue("record_id");
$tags          = getValue("postcom_tag","str","POST","");
//$pcat_id        = getValue("pcat_id");



//Call class menu - lay ra danh sach Category
$sql = 'cat_type=2';
$menu 									= new menu();
$listAll 								= $menu->getAllChild("categories_multi","cat_id","cat_parent_id","0",$sql . " AND lang_id = " . $lang_id . $sqlcategory,"cat_id,cat_name,cat_order,cat_type,cat_parent_id,cat_has_child","cat_order ASC, cat_name ASC","cat_has_child");

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
   $myform = new generate_form();
   $myform->add("postcom_cat_id","cat_id",1,0,0,1,"Bạn chưa chọn danh mục",0,"");
   $myform->add("postcom_title", "postcom_title", 0, 0, "", 1, "Bạn chưa nhập tiêu đề bài viết", 0, "");
   $myform->add("postcom_content", "postcom_content", 0, 0, "", 0, "",0, "");
   $myform->add("postcom_tag", "postcom_tag", 0, 0, "", 0, "",0, "");
   $myform->add("postcom_active","postcom_active",1,0,0,0,"",0,"");

	$myform->addTable($fs_table);
   $action = getValue("action", "str", "POST", "");
   if($action == "execute"){
   	$fs_errorMsg .= $myform->checkdata();
   	if($fs_errorMsg == ""){
      	$myform->removeHTML(0);
      	$db_ex = new db_execute($myform->generate_update_SQL($id_field, $record_id));
         //Lưu tag cho bài viết của user cộng đồng (Group type: 5, type: 2)
         if($tags != '') save_tags($record_id,$tags,5,2);
     		redirect($fs_redirect);
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
$db_data 	= new db_query("SELECT * FROM post_community
                            INNER JOIN categories_multi ON post_community.postcom_cat_id=categories_multi.cat_id
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
   <?=$form->select_db_multi("Danh mục", "cat_id", "cat_id", $listAll, "cat_id", "cat_name", $cat_id, "Chọn danh mục", 1, "", 1, 0, "", "")?>
   <?=$form->text("Tiêu đề bài viết", "postcom_title", "postcom_title", $postcom_title, "Tiêu đề", 1, 250, "", 255, "", "", "")?>
   <?=$form->text("Tags", "postcom_tag", "postcom_tag", $postcom_tag, "Tags", 0, 450,24, 255, "", "", "")?>
   <?=$form->close_table();?>
   <?//=$form->wysiwyg("<font class='form_asterisk'>*</font> Nội dung bài viết ", "postcom_content", $postcom_content, "../../resource/wysiwyg_editor/", "99%", 450)?>
   <div class="form_name" style="text-align:left; padding:5px; width:99%"><font class="form_asterisk">*</font> Nội dung bài viết </div>
   <textarea class="postcom_content" id="postcom_content" name="postcom_content" style="height: 400px;"><?=$postcom_content?></textarea>
   <script src="/../../js/tinymce/tinymce.min.js" type="text/javascript" charset="utf-8"></script>
   <script type="text/javascript">
   tinymce.init({
      selector: "textarea",
      plugins: [
         "advlist autolink lists link charmap print preview anchor",
         "searchreplace visualblocks code fullscreen",
         "insertdatetime media table contextmenu paste jbimages image",
      ],
      toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image jbimages",
      relative_urls: false ,
      theme_advanced_buttons1: "forecolor,backcolor,fontselect,fontsizeselect",
   });
   </script>
   <?=$form->create_table();?>
   <?=$form->checkbox("Kích hoạt", "postcom_active", "postcom_active", 1 ,$postcom_active, "",0, "", "")?>
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