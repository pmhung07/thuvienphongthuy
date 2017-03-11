<?
include("inc_security.php");
checkAddEdit("edit");

$fs_title			= $module_name . " | Sửa đổi";
$fs_action			= getURL();
$fs_errorMsg		= "";

$fs_redirect 	= base64_decode(getValue("url","str","GET",base64_encode("listing.php")));
$record_id 		= getValue("record_id");
$cat_id        = getValue("cat_id");
$tags          = getValue("skl_les_tags","str","POST","");
//$lev_id        = getValue("lev_select");
//$cou_charge    = getValue("cou_charge");
// $arr_form = array(-1 => "- Lựa chọn dạng khóa học -" , 1 => "Khóa học bình thường" , 2 => "Khóa học thuộc TOEFL" , 3 => "Khóa học thuộc IELTS và TOEIC");
//Call class menu - lay ra danh sach Category
$sql = '1';
$sql = ' cat_type = 0';
$menu 	= new menu();
$listAll   = $menu->getAllChild("categories_multi","cat_id","cat_parent_id","0",$sql . " AND lang_id = " . $lang_id . $sqlcategory,"cat_id,cat_name,cat_order,cat_type,cat_parent_id,cat_has_child","cat_order ASC, cat_name ASC","cat_has_child");

$arr_type = array(
                   1 => "Bài học thường(không chấm)" , 
                   2 => "Bài học chấm luyện nói" , 
                   3 => "Bài học chấm viết thường" ,
                   4 => "Bài học chấm viết email" ,
                   5 => "Bài học chấm luyện phát âm");
// Lay ra danh sach Level
/*
$lev_slct	= new db_query("SELECT lev_id, lev_name FROM levels" );
$arr_selectlev[''] = "--Chọn Level--";
while( $newarr = mysql_fetch_assoc($lev_slct->result)){
  $arr_selectlev[$newarr['lev_id']]= $newarr['lev_name'];
};
*/
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
   $myform->add("skl_les_name", "skl_les_name", 0, 0, "", 1, "Bạn chưa nhập tên của bài học", 0, "Tên bài học này đã có trong cơ sở dữ liệu!");
   $myform->add("skl_les_cat_id","cat_id",1,0,0,1,"Bạn chưa chọn danh mục",0,""); 
   //$myform->add("cou_lev_id", "lev_select",1,0,0,1,"Bạn chưa chọn level",0,"");
   //$myform->add("cou_form", "cou_form",1,0,1,1,"Bạn chưa chọn level",0,"");
   //$myform->add("cou_charge", "cou_charge", 1, 0, 0, 1, "Bạn chưa chọn hình thức khóa học",0, "");
   $myform->add("skl_les_desc", "skl_les_desc", 0, 0, "",0, "", 0, "");
   $myform->add("skl_les_active","skl_les_active",1,0,0,0,"",0,"");
   $myform->add("skl_les_type","skl_les_type",1,0,0,0,"",0,"");
	$myform->add("meta_title","meta_title",0,0,"",0,"",0,"");
   $myform->add("meta_description","meta_description",0,0,"",0,"",0,"");
   $myform->add("meta_keywords","meta_keywords",0,0,"",0,"",0,"");
   $myform->add("skl_les_tags","skl_les_tags",0,0,"",0,"",0,"");
   $myform->addTable($fs_table);
   $action = getValue("action", "str", "POST", "");
   if($action == "execute"){
   	$fs_errorMsg .= $myform->checkdata();
   	if($fs_errorMsg == ""){	   	
         $upload = new upload("skl_les_img", $imgpath, $fs_extension, $fs_filesize );
         
         $filename = $upload->file_name;
         
   		if($filename != ""){
            delete_file($fs_table,$id_field,$record_id,"skl_les_img",$imgpath);
   			$myform->add("skl_les_img","filename", 0, 1, "", 0);
   			foreach($arr_resize as $type=>$arr){
   				resize_image($imgpath, $filename, $arr["width"], $arr["height"], $arr["quality"], $type);
   			}
   		}
         
         $fs_errorMsg .= $upload->show_warning_error();
         if($fs_errorMsg == ""){                  
         	$myform->removeHTML(0);
         	$db_ex = new db_execute($myform->generate_update_SQL($id_field, $record_id));
            //Lưu tag cho bài học kĩ năng (Group type:2, type:1)
            if($tags != '') save_tags($record_id,$tags,2,1);
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
//chuyển các trường thành biến để lấy giá trị thay cho dùng kiểu getValue
$myform->evaluate();
$fs_errorMsg .= $myform->strErrorField;
//lay du lieu cua record can sua doi
$db_data 	= new db_query("SELECT * FROM skill_lesson
                            INNER JOIN categories_multi ON skill_lesson.skl_les_cat_id=categories_multi.cat_id 
                            WHERE " . $id_field . " = " . $record_id);
if($row 		= mysql_fetch_assoc($db_data->result)){
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
   <?=$form->text_note('<strong style="text-align:center;">----------Sửa đổi bài học-----------</strong>')?>
   <?=$form->text_note('Những ô có dấu sao (<font class="form_asterisk">*</font>) là bắt buộc phải nhập.')?>
   <?=$form->errorMsg($fs_errorMsg)?>
   
   <?=$form->select_db_multi("Danh mục", "cat_id", "cat_id", $listAll, "cat_id", "cat_name", $cat_id, "Chọn danh mục", 1, "", 1, 0, "", "")?>
   <?//=$form->select("Level", "lev_select", "lev_select",$arr_selectlev,$lev_id,"Chọn level",1,"","","","","<span  style=\"color: red;padding-left: 10px;\" >(Khi add Course cho phần luyện thi thì bạn không được chọn Lever Upper Intermediate)</span>")?>
   <?//=$form->select("Form", "cou_form", "cou_form", $arr_form, $cou_form ,"Chọn dạng khóa học",1,"",1,0,"","")?>
   <?=$form->select("Dạng bài học", "skl_les_type", "skl_les_type", $arr_type, $skl_les_type,"Chọn dạng bài học",1,"",1,0,"","")?>
   <tr>
      <td></td>
      <td style="color: red;">Tất cả các bài học ko có chấm điểm thì chọn dạng "Bài học thường"</td>
   </tr>
   <?=$form->text("Tên bài học", "skl_les_name", "skl_les_name", $skl_les_name, "Tên bài học", 1, 250, "", 255, "", "", "")?>
   <?=$form->getFile("Hình ảnh đại diện", "skl_les_img", "skl_les_img", "Chọn hình ảnh", 1, 40, "", "")?>
   
   <?=$form->text("Title", "meta_title", "meta_title", $meta_title, "Title", 0, 450, 24, 255, "", "", "")?>
   <?=$form->text("Description", "meta_description", "meta_description", $meta_description, "Description", 0, 450, 24, 255, "", "", "")?>
   <?=$form->text("Keywords", "meta_keywords", "meta_keywords", $meta_keywords, "Keywords", 0, 450,24, 255, "", "", "")?>
   <?=$form->text("Tags", "skl_les_tags", "skl_les_tags", $skl_les_tags, "Tags", 0, 450,24, 255, "", "", "<span  style=\"color: red;padding-left: 10px;\" >(Các từ khóa viết thường, cách nhau bằng dấu \",\")</span>")?>
   <?//=$form->getFile("Ảnh nội dung", "cou_image", "cou_image", "Chọn hình ảnh", 1, 40, "", "")?>
   <?=$form->close_table();?>
   <?=$form->wysiwyg("Thông tin khóa học", "skl_les_desc", $skl_les_desc, "../../resource/wysiwyg_editor/", "99%", 450)?>
   <?=$form->create_table();?>
   <?=$form->checkbox("Kích hoạt", "skl_les_active", "skl_les_active", 1 ,$skl_les_active, "",0, "", "")?>  
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