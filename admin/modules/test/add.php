<?
include("inc_security.php");
checkAddEdit("add");

$fs_title			= $module_name . " | Thêm mới";
$fs_action			= getURL();
$fs_errorMsg		= "";
$add					= "add.php";
$listing				= "listing.php";
$after_save_data	= getValue("after_save_data", "str", "POST", "add.php");
$tags             = getValue("test_tags","str","POST","");
$cat_id           = getValue("cat_id","int","POST",0);
$fs_redirect		= $after_save_data;
$arr_type_test    = array(1 => "Reading" , 2 => "Listening" , 3 => "Speaking" , 4 => "Writing");
$sql = '1';
$menu = new menu();
$listAll = $menu->getAllChild("categories_multi","cat_id","cat_parent_id","0",$sql . " AND lang_id = " . $lang_id . $sqlcategory,"cat_id,cat_name,cat_order,cat_type,cat_parent_id,cat_has_child","cat_order ASC, cat_name ASC","cat_has_child");

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
   $myform->add("test_name", "test_name", 0, 0, "", 1, "Bạn chưa nhập tên của đề thi", 1, "Đề thi này đã có trong cơ sở dữ liệu!");
   $myform->add("test_cat_id","cat_id",1,0,0,1,"Bạn chưa chọn danh mục",0,""); 
   $myform->add("test_date","test_date", 0, 1,"", 0, "", 0, "");
   $myform->add("test_active","test_active",1,0,0,0,"",0,"");
   $myform->add("test_tags","test_tags",0,0,"",0,"",0,"");
	$myform->addTable($fs_table);
   //Get action variable for add new data
   $action			= getValue("action", "str", "POST", ""); 
   //Check $action for insert new data
   if($action == "execute"){
      $fs_errorMsg .= $myform->checkdata();
      if($fs_errorMsg == ""){
   		$upload		= new upload("test_image", $imgpath, $fs_extension, $fs_filesize);
   		$filename	= $upload->file_name;
         if($filename != ""){
      		$myform->add("test_image","filename",0,1,0,0);
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
            for($i = 0; $i < 4; $i++){
               $typ_type = $i + 1;
               $type_name = $arr_type_test[$typ_type];
               $myform_type = new generate_form();  
               $myform_type->add("typ_test_id", "last_test_id", 1, 1, 0, 0, "", 0, "");
               $myform_type->add("typ_name", "type_name", 0, 1, "", 1, "Bạn chưa nhập tên phần thi", 0, "");  
               $myform_type->add("typ_type", "typ_type", 1, 1, 0, 0, "", 0, "");   
            	$myform_type->addTable("type_test");
               if($fs_errorMsg == ""){
                  $myform->removeHTML(0);
               	$db_insert_type = new db_execute($myform_type->generate_insert_SQL());
                  unset($db_insert_type);
               }
            }
            //Lưu tag cho đề thi toefl (Group type:3, type:2)
            if($tags == ''){
               $tags = gen_str_cate($cat_id,'categories_multi','cat_id','cat_parent_id','cat_name');
            }
            save_tags($last_test_id,$tags,3,2);
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
   <?=$form->text("Tên đề thi", "test_name", "test_name", $test_name, "Tên đề thi", 1, 272, "", 255, "", "", "")?>
   <?=$form->select_db_multi("Danh mục", "cat_id", "cat_id", $listAll, "cat_id", "cat_name", $cat_id, "Chọn danh mục", 1, "", 1, 0, "", "")?>
   <?=$form->getFile("Hình ảnh", "test_image", "test_image", "Chọn hình ảnh", 0, 40, "", "")?>
   <?=$form->text("Tags", "test_tags", "test_tags", $test_tags, "Tags", 0, 450,24, 255, "", "", "<span  style=\"color: red;padding-left: 10px;\" >(Các từ khóa viết thường, cách nhau bằng dấu \",\")</span>")?>
   <?=$form->checkbox("Kích hoạt", "test_active", "test_active", 1 ,$test_active, "",0, "", "")?>
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