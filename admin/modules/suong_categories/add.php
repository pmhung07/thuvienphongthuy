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
    
   $myform = new generate_form(); 
   $myform->add("cat_name", "cat_name", 0, 0, "", 1, "Bạn chưa tên danh mục", 0, "");
   $myform->add("cat_order","cat_order",1,0,0,0,"Bạn chưa nhập thứ tự",0,"");
   $myform->add("cat_description","cat_description",0,0,"",0,"",0,"");
   $myform->add("cat_active","cat_active",0,0,0,0,"");
   $myform->addTable($fs_table);
   $action	  = getValue("action", "str", "POST", "");
   if($action == "execute"){
   	$fs_errorMsg .= $myform->checkdata();      
      if($fs_errorMsg == ""){
         if($fs_errorMsg == ""){
         	$myform->removeHTML(0);
         	$db_insert = new db_execute($myform->generate_insert_SQL());
            unset($db_insert);
         	redirect('listing.php');
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
   <?=$form->text_note('<strong style="text-align:center;">Thêm mới danh mục</strong>')?>
   <?=$form->text_note('Những ô có dấu sao (<font class="form_asterisk">*</font>) là bắt buộc phải nhập.')?>
   <?=$form->errorMsg($fs_errorMsg)?>
   <?=$form->text("Tên danh mục", "cat_name", "cat_name", $cat_name, "Tên damh mục", 1, 250, "", 255, "", "", "")?>
   <?=$form->text("Thứ tự","cat_order","cat_order",$cat_order,"cat_order",0,255,"",255,"","","")?>
   <?=$form->textarea("Mô tả danh mục","cat_description","cat_description",$cat_description,"des",0,200,100,"","","")?>
   <?=$form->checkbox("Kích hoạt", "cat_active", "cat_active", 1 ,$cat_active, "",0, "", "")?>
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