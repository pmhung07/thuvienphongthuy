    <?
    include("inc_security.php");
    checkAddEdit("edit");

    $fs_title			= $module_name . " | Sửa đổi";
    $fs_action			= getURL();
    $fs_errorMsg		= "";

    $fs_redirect 	= base64_decode(getValue("url","str","GET",base64_encode("listing.php")));
    $record_id 		= getValue("record_id");
    //$pcat_id        = getValue("pcat_id");



    //Call class menu - lay ra danh sach Category
    $sql = 'scat_type = 1';
    $menu 									= new menu();
    $listAll 								= $menu->getAllChild("support_category","scat_id","scat_parent_id","0",$sql . " AND lang_id = " . $lang_id . $sqlcategory,"scat_id,scat_name,scat_order,scat_type,scat_parent_id,scat_has_child","scat_order ASC, scat_name ASC","scat_has_child");
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
    $myform->add("snew_cat_id","snew_cat_id",1,0,0,1,"Bạn chưa chọn danh mục",0,"");
    $myform->add("snew_title", "snew_title", 0, 0, "", 1, "Bạn chưa nhập tiêu đề ", 0, "");
    $myform->add("snew_description","snew_description", 0, 0,"", 1, "Bạn chưa nhập nội dung", 0, "");
    $myform->add("snew_active","snew_active",1,0,0,0,"",0,"");
    $myform->addTable($fs_table);
    $action = getValue("action", "str", "POST", "");
    if($action == "execute"){
       $errorMsg= $myform->checkdata();
       if($errorMsg == ""){
			$db_ex 	= new db_execute_return();
			$last_id = $db_ex->db_execute($myform->generate_update_SQL($id_field, $record_id));
			$iParent = getValue("scat_parent_id","int","POST");
			if($iParent > 0){
				$db_ex = new db_execute("UPDATE post_category SET pcat_has_child = 1 WHERE scat_id = " . $iParent);
			}
			redirect($fs_redirect);
			exit();
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
    $db_data 	= new db_query("SELECT * FROM ".$fs_table."
                                INNER JOIN support_category
                                ON (snew_cat_id = scat_id)
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
    <?=$form->text_note('<strong style="text-align:center;">----------Sửa đổi nội dung-----------</strong>')?>
    <?=$form->text_note('Những ô có dấu sao (<font class="form_asterisk">*</font>) là bắt buộc phải nhập.')?>
    <?=$form->errorMsg($fs_errorMsg)?>
    <?=$form->select_db_multi("Danh mục", "snew_cat_id", "snew_cat_id", $listAll, "scat_id", "scat_name", $snew_cat_id, "Chọn danh mục", 1, "", 1, 0, "", "")?>
    <?=$form->text("Tiêu đề bài viết", "snew_title", "snew_title", $snew_title, "Tiêu đề", 1, 250, "", 255, "", "", "")?>
    <?=$form->close_table();?>
    <?=$form->wysiwyg("<font class='form_asterisk'>*</font> Nội dung bài viết ", "snew_description", $snew_description, "../../resource/wysiwyg_editor/", "99%", 450)?>
    <?=$form->create_table();?>
    <?=$form->checkbox("Kích hoạt", "snew_active", "snew_active", 1 ,$snew_active, "",0, "", "")?>
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