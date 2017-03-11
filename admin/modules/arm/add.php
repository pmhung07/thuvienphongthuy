<?
include("inc_security.php");
checkAddEdit("add");

//Khai báo biến khi thêm mới
$after_save_data	= getValue("after_save_data", "str", "POST", "add.php");
$add					= "add.php";
$listing				= "listing.php";
$fs_title			= "Add New Level";
$fs_action			= getURL();
$fs_redirect		= $after_save_data;
$fs_errorMsg		= "";
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
   //Call Class generate_form();
   $myform = new generate_form();
   $myform->add("listarm_name","listarm_name",0,0,"",1,"Bạn chưa nhập tên Huy hiệu!",0,"Huy hiệu này đã tồn tại !");
   $myform->add("listarm_exp","listarm_exp",1,0,"",1,"Bạn chưa nhập tên Huy hiệu!",0,"Huy hiệu này đã tồn tại !");
   $myform->addTable($fs_table);
   
   //Get action variable for add new data
   $action				= getValue("action", "str", "POST", "");

   //Check $action for insert new data
   if($action == "execute"){
   	//Check form data
   	$fs_errorMsg .= $myform->checkdata();
   	//Get $filename and upload
   	$filename	= "";
   
      $upload    = new upload("listarm_img", $imgpath, $fs_extension, $fs_filesize);
            $filename   = $upload->file_name;
            if($filename != ""){
                $myform->add("listarm_img","filename",0,1,0,0);
                foreach($arr_resize as $type => $arr){
                    resize_image($imgpath, $filename, $arr["width"], $arr["height"], $arr["quality"], $type);
                }
            }else{
                $fs_errorMsg .= "Bạn chưa chọn ảnh đại diện ! </br>";
            }
            $fs_errorMsg .= $upload->show_warning_error();
   
   	if($fs_errorMsg == ""){

         
   		//Insert to database
   	  	$myform->removeHTML(0);
   		$db_insert = new db_execute($myform->generate_insert_SQL());
   		unset($db_insert);
   		//Redirect after insert complate
   		redirect($fs_redirect);
   	}//End if($fs_errorMsg == "")
      
   }//End if($action == "insert")
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<?=$load_header?>
<? 
//add form for javacheck
$myform->addFormname("add");

$myform->checkjavascript(); 
//chuyển các trường thành biến để lấy giá trị thay cho dùng kiểu getValue
$myform->evaluate();
$fs_errorMsg .= $myform->strErrorField;
?>
</head>
<body topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0">
<? /*------------------------------------------------------------------------------------------------*/ ?>
<?=template_top($fs_title)?>
<? /*------------------------------------------------------------------------------------------------*/ ?>
	<p align="center" style="padding-left:10px;">
   <?
	$form = new form();
	$form->create_form("add", $fs_action, "post", "multipart/form-data",'onsubmit="validateForm(); return false;"');
	$form->create_table();
	?>
   <?=$form->text_note('<strong style="textalign:center;">-- --</strong>')?>
	<?=$form->errorMsg($fs_errorMsg)?>
   <?=$form->text("Tên Huy hiệu", "listarm_name", "listarm_name","" ,"Tên huy hiệu", 1, 250, "", 255, "", "", "")?>
   <?=$form->text("Điểm kinh nghiệm", "listarm_exp", "listarm_exp","" ,"Điểm kinh nghiệm", 1, 250, "", 255, "", "", "")?>
	<?=$form->getFile("Ảnh đại diện", "listarm_img", "listarm_img", "Chọn hình ảnh", 1, 40, "", "")?>
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