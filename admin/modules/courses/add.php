<?
    require_once("inc_security.php");
    checkAddEdit("add");

    $fs_title = $module_name . " | Thêm mới";
    $fs_action = getURL();
    $fs_errorMsg = "";
    $add = "add.php";
    $listing = "listing.php";
    $after_save_data = getValue("after_save_data", "str", "POST", "add.php");
    $fs_redirect = $after_save_data;
    $tags = getValue("cou_tags","str","POST","");
    $cat_id = getValue("cat_id","int","POST",0);
    //Lisr Danh muc
    $sql = '1';
    $menu = new menu();
    $listAll = $menu->getAllChild("categories_multi","cat_id","cat_parent_id","0",$sql . " AND lang_id = " . $lang_id . $sqlcategory . " AND cat_type = 1","cat_id,cat_name,cat_order,cat_type,cat_parent_id,cat_has_child","cat_order ASC, cat_name ASC","cat_has_child");
    $cou_charge = getValue("cou_charge","int","GET","");
    $arr_form = array(-1 => "- Lựa chọn dạng khóa học -" , 1 => "Khóa học bình thường" , 2 => "Khóa học thuộc TOEFL" , 3 => "Khóa học thuộc IELTS và TOEIC");
   
     
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

    $action = getValue("action", "str", "POST", "");

    if($action == "execute"){
        $cou_cat_parent_id = 0;
        $cou_cat_id = getValue("cat_id", "int", "POST", 0);
        $cou_cat_parent_id = $menu->getParentid('categories_multi','cat_id','cat_parent_id',$cou_cat_id);
    }

    $cou_time = time();  
    //tạo mới class generate_form 
    $myform = new generate_form();
    $myform->add("cou_cat_id","cat_id",1,0,0,1,"Bạn chưa chọn danh mục",0,""); 
    $myform->add("cou_cat_parent_id","cou_cat_parent_id",1,1,0,0,"Bạn chưa chọn danh mục",0,""); 
    $myform->add("cou_time","cou_time", 0, 1,"", 0, "", 0, "");
    $myform->add("cou_name", "cou_name", 0, 0, "", 1, "Bạn chưa nhập tên của khóa học", 0, "");
    $myform->add("cou_info", "cou_info", 0, 0, "",1, "Bạn chưa nhập thông tin cho khóa học", 0, "");
    $myform->add("cou_condition", "cou_condition", 0, 0, "",0, "", 0, "");
    $myform->add("cou_goal", "cou_goal", 0, 0, "",0, "", 0, "");
    $myform->add("cou_object", "cou_object", 0, 0, "",0, "", 0, "");
    $myform->add("cou_order","cou_order",1,0,0,0,"",0,"");
    $myform->add("cou_price","cou_price",1,0,0,0,"",0,"");
    $myform->add("cou_day","cou_day",1,0,0,0,"",0,"");
    $myform->add("title", "title", 0, 0, "", 0, "", 0, "");
    $myform->add("keywords", "keywords", 0, 0, "", 0, "", 0, "");
    $myform->add("description", "description", 0, 0, "", 0, "", 0, "");
    $myform->add("cou_tags", "cou_tags", 0, 0, "", 0, "", 0, "");
    $myform->add("cou_active","cou_active",1,0,0,0,"",0,"");
   
    $myform->addTable($fs_table);
    $action			= getValue("action", "str", "POST", ""); 
    if($action == "execute"){
   	$fs_errorMsg .= $myform->checkdata();      
        if($fs_errorMsg == ""){
            $upload		= new upload("cou_avatar", $imgpath, $fs_extension, $fs_filesize);
            $filename	= $upload->file_name;
            if($filename != ""){
                $myform->add("cou_avatar","filename",0,1,0,0);
                foreach($arr_resize as $type => $arr){
      		        resize_image($imgpath, $filename, $arr["width"], $arr["height"], $arr["quality"], $type);
      		    }
   		   }else{
   		       $fs_errorMsg .= "Bạn chưa chọn ảnh đại diện cho Khóa học ! </br>";
   		   }
            $fs_errorMsg .= $upload->show_warning_error();	     
                if($fs_errorMsg == ""){
                $date = time();
                $db_insert = new db_execute_return();
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
    <?=$form->select_db_multi("Danh mục", "cat_id", "cat_id", $listAll, "cat_id", "cat_name", $cat_id, "Chọn danh mục", 1, "", 1, 0, "", "")?>	   
    <?=$form->text("Tên khóa học", "cou_name", "cou_name", $cou_name, "Tên khóa học", 1, 250, 24, 255, "", "", "")?>
    <?=$form->getFile("Ảnh đại diện", "cou_avatar", "cou_avatar", "Chọn hình ảnh", 1, 40, "", "")?>
    <?=$form->textarea("Mô tả ngắn","cou_info","cou_info",$cou_info,"Mô tả",0,300,80,"","","")?>
    <?=$form->textarea("Điều kiện học","cou_condition","cou_condition",$cou_condition,"Điều kiện học",0,300,80,"","","")?>
    <?=$form->textarea("Mục tiêu khóa học","cou_goal","cou_goal",$cou_goal,"Mục tiêu khóa học",0,300,80,"","","")?>
    <?=$form->textarea("Đối tượng học","cou_object","cou_object",$cou_object,"Đối tượng học",0,300,80,"","","")?>
    <?=$form->text("Giá", "cou_price", "cou_price", $cou_price, "cou_price", 1, 50,24, 200, "", "", "")?>
    <?=$form->text("Ngày học", "cou_day", "cou_day", $cou_day, "cou_day", 1, 50,24, 200, "", "", "")?>
    <?=$form->text("Order", "cou_order", "cou_order", $cou_order, "Order", 1, 50,24, 200, "", "", "")?>
    <?=$form->text("Title", "title", "title", $title, "Title", 0, 450, 24, 255, "", "", "")?>
    <?=$form->text("Keywords", "keywords", "keywords", $keywords, "Keywords", 0, 450, 24, 255, "", "", "")?>
    <?=$form->text("Description", "description", "description", $description, "Description", 0, 450,24, 255, "", "", "")?>
    <?=$form->text("Tags", "cou_tags", "cou_tags", $cou_tags, "Tags", 0, 450,24, 255, "", "", "<span  style=\"color: red;padding-left: 10px;\" >(Các từ khóa viết thường, cách nhau bằng dấu \",\")</span>")?>
    <?=$form->checkbox("Kích hoạt", "cou_active", "cou_active", 1 ,$cou_active, "",0, "", "")?>
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