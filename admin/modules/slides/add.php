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
   $cat_id = 0;
   //Lisr Danh muc
   $sql = '1';
   $menu = new menu();
   $listAll = $menu->getAllChild("categories_multi","cat_id","cat_parent_id","0",$sql . " AND lang_id = " . $lang_id . $sqlcategory,"cat_id,cat_name,cat_order,cat_type,cat_parent_id,cat_has_child","cat_order ASC, cat_name ASC","cat_has_child");
   $array_type_ad = array(1=>"Banner Slider",2=>"Banner Sidebar Right",3=>"Nhà tuyển dụng hàng đầu",4=>"Banner trang giới thiệu");  
   $array_position = array(0=>"Mô tả bên trái",1=>"Mô tả bên phải");  
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
   $cou_time = time();  
   //tạo mới class generate_form 
   $myform = new generate_form();
   $myform->add("slide_name", "slide_name", 0, 0, "", 1, "Bạn chưa nhập tên ", 0, "");
   $myform->add("slide_content", "slide_content", 0, 0, "", 0, "Bạn chưa nhập nội dung ", 0, "");
   $myform->add("slide_button", "slide_button", 0, 0, "", 0, "Bạn chưa nhập nội dung ", 0, "");
   $myform->add("slide_order", "slide_order", 1, 0, "", 0, "", 0, "");
   $myform->add("slide_active","slide_active",1,0,0,0,"",0,"");
   $myform->add("slide_content_invi","slide_content_invi",1,0,0,0,"",0,"");
   $myform->add("slide_type","slide_type",1,0,1,0,"",0,"");
   $myform->add("slide_url","slide_url",0,0,1,0,"",0,"");
   $myform->add("slide_position","slide_position",1,0,1,0,"",0,"");
   $myform->addTable($fs_table);

   $action			= getValue("action", "str", "POST", ""); 
   if($action == "execute"){
   	$fs_errorMsg .= $myform->checkdata();      
      if($fs_errorMsg == ""){
         $uploadImg	= new upload("slide_img", $imgpath, $fs_extension, $fs_filesize);
         $filenameImg= $uploadImg->file_name;
        if($filenameImg != ""){
      		$myform->add("slide_img","filenameImg",0,1,0,0);
            foreach($arr_resize as $type => $arr){
      		   resize_image($imgpath, $filenameImg, $arr["width"], $arr["height"], $arr["quality"], $type);
      		}
   		}else{
   		   $fs_errorMsg .= "Bạn chưa chọn ảnh đại diện ! </br>"; 
   		}	
         $fs_errorMsg .= $uploadImg->show_warning_error();  	     
         if($fs_errorMsg == ""){
            $db_insert = new db_execute_return();
            //echo $myform->generate_insert_SQL();die();
            $last_id_courses = $db_insert->db_execute($myform->generate_insert_SQL());
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
   <?=$form->text_note('<strong style="text-align:center;">----------Thêm mới khóa học-----------</strong>')?>
   <?=$form->text_note('Những ô có dấu sao (<font class="form_asterisk">*</font>) là bắt buộc phải nhập.')?>
   <?=$form->errorMsg($fs_errorMsg)?>
   <?=$form->select("Vị trí", "slide_type", "slide_type", $array_type_ad, 0, "Vị trí quảng cáo", 1,"" , "", "", "", "")?>
   <?=$form->select("Vị trí mô tả", "slide_position", "slide_position", $array_position, 0, "Vị trí mô tả", 1,"" , "", "", "", "")?>
   <?=$form->text("Tiêu đề", "slide_name", "slide_name", '', "Mô tả", 1, 250, 24, 255, "", "", "")?>
   <?=$form->text("URL", "slide_url", "slide_url", '', "URL", 1, 250, 24, 255, "", "", "")?>
   <?=$form->text("Button", "slide_button", "slide_button", '', "URL", 1, 250, 24, 255, "", "", "")?>
   <?=$form->textarea("Mô tả ngắn", "slide_content", "slide_content", '', "Mô tả", 1, 250, 50, 255, "", "", "")?>
   <?=$form->getFile("Ảnh đại diện", "slide_img", "slide_img", "Chọn hình ảnh", 1, 40, "", "")?>
   <?=$form->text("Thứ tụ", "slide_order", "slide_order", '', "Thứ tự", 1, 250, 24, 255, "", "", "")?>
   <?=$form->create_table();?>
   <?=$form->checkbox("Kích hoạt", "slide_active", "slide_active", 1 ,"", "",0, "", "")?>
   <?=$form->checkbox("Nội dung Slide", "slide_content_invi", "slide_content_invi", 1 ,"", "",0, "", "")?>
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