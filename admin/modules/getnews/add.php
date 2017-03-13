<?
   include("inc_security.php");
   checkAddEdit("add");

   $fs_title = $module_name . " | Thêm mới";
   $fs_action = getURL();
   $fs_errorMsg = "";
   $err_email = "";
   $add = "add.php";
   $listing = "listing.php";
   $after_save_data = getValue("after_save_data", "str", "POST", "add.php");
   $fs_redirect = $after_save_data;
   //Lisr Danh muc
   $sql = 'cat_type=2';
   $menu = new menu();
   $listAll = $menu->getAllChild("categories_multi","cat_id","cat_parent_id","0",$sql .$sqlcategory,"cat_id,cat_name,cat_order,cat_type,cat_parent_id,cat_has_child","cat_order ASC, cat_name ASC","cat_has_child");
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
   $post_time  = time();
   //tạo mới class generate_form
   $email      = getValue('post_email','str','POST',"");
   $db_user_id = new db_query("SELECT use_id
                              FROM users
                              WHERE 1 AND use_email = '".$email."'");
   $user_id    = mysqli_fetch_assoc($db_user_id->result);
   unset($db_user_id);
   if($user_id){
      $postcom_user_id = $user_id['use_id'];
   }else{
      $fs_errorMsg .= 'Email này chưa đăng ký hoặc sai định dạng email';
   }
   $myform = new generate_form();
   $myform->add("postcom_title", "postcom_title", 0, 0, "", 1, "Bạn chưa nhập tiêu đề bài viết", 0, "");
   $myform->add("postcom_cat_id","postcom_cat_id",1,0,0,1,"Bạn chưa chọn danh mục",0,"");
   $myform->add("postcom_user_id","postcom_user_id",1,1,"",0,"",0,"");
   $myform->add("postcom_content", "postcom_content", 0, 0, "", 0, "",0, "");
   $myform->add("postcom_time","post_time", 0, 1,"", 0, "", 0, "");
   $myform->add("postcom_active","postcom_active",0,1,1,0,"");
   $myform->addTable($fs_table);
   $action	  = getValue("action", "str", "POST", "");
   if($action == "execute"){
   	$fs_errorMsg .= $myform->checkdata();
      if($fs_errorMsg == ""){
         if($fs_errorMsg == ""){
         	$myform->removeHTML(0);
         	$db_insert = new db_execute($myform->generate_insert_SQL());
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
   <?=$form->text_note('<strong style="text-align:center;">Quản lý bài Post </strong>')?>
   <?=$form->text_note('Những ô có dấu sao (<font class="form_asterisk">*</font>) là bắt buộc phải nhập.')?>
   <?=$form->errorMsg($fs_errorMsg)?>
   <?=$form->text("Tiêu đề bài viết", "postcom_title", "postcom_title", $postcom_title, "Tiêu đề", 1, 250, "", 255, "", "", "")?>
   <?=$form->select_db_multi("Danh mục", "postcom_cat_id", "postcom_cat_id", $listAll, "cat_id", "cat_name",$postcom_cat_id, "Chọn danh mục", 1, "", 1, 0, "", "")?>
   <?=$form->text("Email","post_email","post_email",$email,"Email",1,255,"",255,"","","")?>
   <?=$form->close_table();?>
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