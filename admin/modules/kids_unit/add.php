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
   $sqlCourse	= new db_query("SELECT * FROM kids_courses");  
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
   //tạo mới class generate_form 
   $myform = new generate_form();
   $myform -> removeHTML(0);
   $myform ->add("kcou_id", "kcou_id", 1, 0, 0, 1, "Bạn chưa chọn Course", 0, "");
   $myform->add("kunit_title", "kunit_title", 0, 0, "", 1, "Bạn chưa nhập tên của Unit", 0, "");
   $myform->add("kunit_title_vie", "kunit_title_vie", 0, 0, "", 1, "Bạn chưa nhập tên tiếng việt của Unit", 0, "");
   $myform->add("kunit_desc", "kunit_desc", 0, 0, "",1, "Bạn chưa nhập thông tin cho Unit", 0, "");
   $myform->addTable($fs_table);
   $fs_errorMsg = "";
   $action	= getValue("action", "str", "POST", "");
   if($action == "execute"){
    
    //Check form data : kiêm tra lỗi
    $fs_errorMsg .= $myform->checkdata();
		if($fs_errorMsg == ""){ 
			$myform->removeHTML(0);
            $db_insert = new db_execute_return();
		    $db_insert = new db_execute($myform->generate_insert_SQL());
            unset($db_insert);
         	redirect($fs_redirect);
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
   <?=$form->text_note('<strong style="text-align:center;">----------Thêm mới Unit-----------</strong>')?>
   <?=$form->text_note('Những ô có dấu sao (<font class="form_asterisk">*</font>) là bắt buộc phải nhập.')?>
   <?=$form->errorMsg($fs_errorMsg)?>	
	<tr>
	   <td align="right" nowrap="" class="form_name"><font class="form_asterisk">* </font> <?=translate_text("Chọn Course")?> :</td>
	   <td>
		   <select name="kcou_id" id="kcou_id"  class="form_control" style="width: 300px;">
			<option value="-1">- <?=translate_text("Chọn Course")?> - </option>
			<?
			while($row = mysql_fetch_assoc($sqlCourse->result)){
			   
			?>
			<option value="<?=$row['kcou_id']?>" ><? echo ' -- '.$row['kcou_title']?></option>
			<? } ?>
		</select>
	   </td>
   </tr>   
   <?=$form->text("Tên Unit", "kunit_title", "kunit_title", $kunit_title, "Tên Unit", 1, 250, 24, 255, "", "", "")?>
   <?=$form->text("Tên TV Unit", "kunit_title_vie", "kunit_title_vie", $kunit_title_vie, "Tên TV Unit", 1, 250, 24, 255, "", "", "")?>
   <?=$form->textarea("Thông tin Unit", "kunit_desc", "kunit_desc", $kunit_desc, "Thông tin Unit", 1, 400, 60, "", "", "")?>
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