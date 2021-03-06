<?
include("inc_security.php");
require_once("../../../classes/tag.php");
checkAddEdit("add");

$fs_title			= $module_name . " | Thêm mới";
$fs_action			= getURL();
$fs_errorMsg		= "";
$add					= "add.php";
$listing				= "listing.php";
$after_save_data	= getValue("after_save_data", "str", "POST", "add.php");
$fs_redirect		= $after_save_data;
$tags             = getValue("uni_test_tags","str","POST","");
$name             = getValue("uni_test_name","str","POST","");
$arr_type_test    = array(1 => "Reading" , 2 => "Listening");
$ielt_active      = 1;
$uni_test_date        = time();
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
   $test_date = time();  
   //tạo mới class generate_form 
   $myform = new generate_form();  
   $myform->add("uni_test_name", "uni_test_name", 0, 0, "", 1, "Bạn chưa nhập tên của đề thi", 1, "Đề thi này đã có trong cơ sở dữ liệu!");
   $myform->add("uni_test_date","uni_test_date", 0, 1,"", 0, "", 0, "");
   $myform->add("uni_test_active","uni_test_active",1,0,0,0,"",0,"");
   $myform->add("uni_test_tags","uni_test_tags",0,0,"",0,"",0,"");
	$myform->addTable($fs_table);
   //Get action variable for add new data
   $action			= getValue("action", "str", "POST", ""); 
   //Check $action for insert new data
   if($action == "execute"){
      $fs_errorMsg .= $myform->checkdata();
      if($fs_errorMsg == ""){
   		$upload		= new upload("uni_test_image", $imgpath, $fs_extension, $fs_filesize);
   		$filename	= $upload->file_name;
         if($filename != ""){
      		$myform->add("uni_test_image","filename",0,1,0,0);
      		foreach($arr_resize as $type => $arr){
    				resize_image($imgpath, $filename, $arr["width"], $arr["height"], $arr["quality"], $type);
      		}
   		}	
      	$fs_errorMsg .= $upload->show_warning_error();
         if($fs_errorMsg == ""){
         	$myform->removeHTML(0);   	
            $db_insert 	= new db_execute_return();
		      $last_test_id = $db_insert->db_execute($myform->generate_insert_SQL());
            unset($db_insert);
            //Lưu tag cho đề thi ĐH (Group type:3, type:4)
            if($tags != '') save_tags($last_test_id,$tags,3,4);
            else{
               $tags = new tag($last_test_id,'',$name,'',3,4);
               $tags->insert_tag(2);
               unset($tags);
            }
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
$myform->evaluate();
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
   <?=$form->text_note('<strong style="text-align:center;">----------Thêm mới Đề thi-----------</strong>')?>
   <?=$form->text_note('Những ô có dấu sao (<font class="form_asterisk">*</font>) là bắt buộc phải nhập.')?>
   <?=$form->errorMsg($fs_errorMsg)?>
   <?=$form->text("Tên đề thi", "uni_test_name", "uni_test_name", $uni_test_name, "Tên đề thi", 1, 272, "", 255, "", "", "")?>
   <?=$form->getFile("Hình ảnh", "uni_test_image", "uni_test_image", "Chọn hình ảnh", 0, 40, "", "")?>
   <?=$form->text("Tags", "uni_test_tags", "uni_test_tags", $uni_test_tags, "Tags", 0, 450,24, 255, "", "", "<span  style=\"color: red;padding-left: 10px;\" >(Các từ khóa viết thường, cách nhau bằng dấu \",\")</span>")?>
   <?=$form->checkbox("Kích hoạt", "uni_test_active", "uni_test_active", 1 ,$uni_test_active, "",0, "", "")?>
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