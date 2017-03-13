<?
   include("inc_security.php");
   checkAddEdit("add");

   $fs_title = $module_name . " | Thêm mới";
   $fs_action = getURL();
   $fs_errorMsg = "";
   $add = "add.php";
   $listing = "listing.php";
   $after_save_data = getValue("after_save_data", "str", "POST", "add.php");
   $fs_redirect = $after_save_data;
   $sql			= " scat_type = 0";
   $menu = new menu();
   $listAll = $menu->getAllChild("support_category","scat_id","scat_parent_id","0",$sql . " AND lang_id = " . $lang_id . $sqlcategory,"scat_id,scat_name,scat_order,scat_type,scat_parent_id,scat_has_child","scat_order ASC, scat_name ASC","scat_has_child");



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
   $date = time();
   $myform->add("ssha_cat_id","ssha_cat_id",1,0,0,1,"Bạn chưa chọn danh mục",0,"");
   $myform->add("ssha_title", "ssha_title", 0, 0, "", 1, "Bạn chưa nhập tiêu đề câu hỏi", 0, "");
   $myform->add("ssha_content","ssha_content", 0, 0,"", 1, "Bạn chưa nhập nội dung câu hỏi", 0, "");
   $myform->add("ssha_time","date", 1, 1,"", 0, "", 0, "");
   $myform->add("ssha_active","ssha_active",1,0,0,0,"",0,"");
   $myform->addTable($fs_table);
   $action			= getValue("action", "str", "POST", "");
   if($action == "execute"){
   	$fs_errorMsg .= $myform->checkdata();
      if($fs_errorMsg == ""){
            $email      = getValue('by_email','str','POST',"");
            $db_user_id = new db_query("SELECT use_id
                                       FROM users
                                       WHERE 1 AND use_email = '".$email."'");
            $user_id    = mysqli_fetch_assoc($db_user_id->result);
            unset($db_user_id);
            if($user_id){
               $ssha_user_id = $user_id['use_id'];
            }else{
               $fs_errorMsg .= 'Email này chưa đăng ký hoặc sai định dạng email';
            }
            $myform->add("ssha_user_id","ssha_user_id",1,1,"",1,"Bạn chưa nhập email",0,"");
            $fs_errorMsg .= $myform->checkdata();
            if($fs_errorMsg == ""){
             	$myform->removeHTML(1);
             	$db_insert = new db_execute($myform->generate_insert_SQL());
                unset($db_insert);
             	//redirect($fs_redirect);
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
   <?=$form->text_note('<strong style="text-align:center;">Thêm mới câu hỏi support</strong>')?>
   <?=$form->text_note('Những ô có dấu sao (<font class="form_asterisk">*</font>) là bắt buộc phải nhập.')?>
   <?=$form->errorMsg($fs_errorMsg)?>
   <?=$form->select_db_multi("Danh mục", "ssha_cat_id", "ssha_cat_id", $listAll, "scat_id", "scat_name", $ssha_cat_id, "Chọn danh mục", 1, "", 1, 0, "", "")?>
   <?=$form->text("Tiêu đề", "ssha_title", "ssha_title", $ssha_title, "Tiêu đề", 1, 250, "", 255, "", "", "")?>
   <?=$form->text("Người tạo", "by_email", "by_email", '', "Email", 1, 250, "", 255, "", "", "")?>
   <?=$form->textarea("Nội dung câu hỏi","ssha_content","ssha_content",$ssha_content,'',1,400,100)?>
   <?=$form->checkbox("Kích hoạt", "ssha_active", "ssha_active", 1 ,$ssha_active, "",0, "", "")?>
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