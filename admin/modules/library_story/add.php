<?
require_once("inc_security.php");
checkAddEdit("add");
   
//Khai bao Bien
$fs_title = $module_name . " | Thêm mới";
$add = "add.php";
$listing = "listing.php";
$after_save_data = getValue("after_save_data", "str", "POST", "add.php");
$fs_redirect = $after_save_data;
$tags            = getValue("lib_story_tags","str","POST",""); 
$title           = getValue("lib_story_title","str","POST","");
$info            = getValue("lib_story_intro","str","POST","");
$lib_cat_id      = getValue("lib_cat_id","int","POST",0);    
$type            = getValue("type","int","GET",0);
//Type Story
/* 1 - Truyện chữ ; 2 - Truyện tranh*/
$arr_type_story = array(1 => "Truyện chữ" , 2 => "Truyện tranh");


//List Danh muc
$sql = "lib_cat_type = 2";
$menu 	= new menu();
$listAll = $menu->getAllChild("library_cate","lib_cat_id","lib_cat_parent_id","0",$sql . " AND lang_id = " . $lang_id . $sqlcategory,"lib_cat_id,lib_cat_name,lib_cat_order,lib_cat_type,lib_cat_parent_id,lib_cat_has_child","lib_cat_order ASC, lib_cat_name ASC","lib_cat_has_child");


//Call Class generate_form();
$myform = new generate_form();    
//Loại bỏ chuc nang thay the Tag Html
$myform->removeHTML(0);
$myform->add("lib_story_type","lib_story_type",1,0,"",1,"Bạn chưa chọn kiểu truyện",0,"");
$myform->add("lib_story_catid","lib_cat_id",0,0,"",1,"Bạn chưa chọn danh mục truyện",0,"");
$myform->add("lib_story_title","lib_story_title",0,0,"",1,"Bạn chưa nhập tiêu đề truyện",0,"");
$myform->add("lib_story_intro","lib_story_intro",0,0,"",1,"Bạn chưa nhập phần giới thiệu");
$myform->add("lib_story_en","lib_story_en",0,0,"",0,"Bạn chưa nhập nội dung tiếng Anh",0,"");
$myform->add("lib_story_vi","lib_story_vi",0,0,"",0,"Bạn chưa nhập nội dung tiếng Việt",0,"");
$myform->add("meta_title","meta_title",0,0,"",0,"",0,"");
$myform->add("meta_description","meta_description",0,0,"",0,"",0,"");
$myform->add("meta_keywords","meta_keywords",0,0,"",0,"",0,"");
$myform->add("lib_story_tags","lib_story_tags",0,0,"",0,"",0,"");
//Add table
$myform->addTable($fs_table);
//Warning Error!
$fs_errorMsg = "";
//Get Action.
$action	= getValue("action", "str", "POST", "");
if($action == "execute"){
   //Check form data : kiêm tra lỗi
   $fs_errorMsg .= $myform->checkdata();
   if($fs_errorMsg == ""){
   	$upload_img = new upload("lib_story_image", $imgpath, $fs_extension, $fs_filesize);
   	$filename_img = $upload_img->file_name;     
      if($filename_img != ""){
         $myform->add("lib_story_image","filename_img",0,1,0,0);
         foreach($arr_resize as $type => $arr){
   		resize_image($imgpath, $filename_img, $arr["width"], $arr["height"], $arr["quality"], $type);
         }
      }
      if($fs_errorMsg == ""){    
      	$myform->removeHTML(0);
         $db_insert = new db_execute_return();
         $last_id   = $db_insert->db_execute($myform->generate_insert_SQL());
         unset($db_insert);
         //Lưu tag cho truyện (Group type:4, type:2)
         if($tags == ''){
            $tags = gen_str_cate($lib_cat_id,'library_cate','lib_cat_id','lib_cat_parent_id','lib_cat_name');
         }
         save_tags($last_id,$tags,4,2);
      	redirect($fs_redirect);
      }
   }
}
$myform->addFormname("add_new");
$myform->evaluate();
$myform->checkjavascript();
$fs_errorMsg .= $myform->strErrorField;
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<?=$load_header?>
</head>
<body>
<?=template_top($fs_title)?>
   <p align="center" style="padding-left:10px;">
   <?
   $form = new form();
   $form->create_form("add", $_SERVER["REQUEST_URI"], "post", "multipart/form-data",'onsubmit="validateForm(); return false;"');
   $form->create_table();
   ?>
      <?=$form->text_note('<strong style="textalign:center;">-- Thêm mới thư viện Truyện --</strong>')?>
      <?=$form->text_note('Những ô dấu (<font class="form_asterisk">*</font>) là bắt buộc phải nhập.')?>
      <?=$form->errorMsg($fs_errorMsg)?>
      <tr>
         <td class="form_name"><font color="red">*</font>&nbsp;Chọn kiểu truyện : </td>
         <td>
            <select class="form_control" style="width: 186px;" name="lib_story_type" id="lib_story_type" onchange="window.location.href='add.php?type='+this.value">
               <option value=""> - Chọn kiểu truyện - </option>
               <?foreach($arr_type_story as $id=>$name){?>
         			<option value="<?=$id?>"<?if($id == $type) echo "selected='selected'"?>><?=$name?></option>
         		<?}?>
            </select>
         </td>
      </tr>
      <?=$form->select_db_multi("Danh mục truyện", "lib_cat_id", "lib_cat_id", $listAll, "lib_cat_id", "lib_cat_name", $lib_cat_id, "Chọn danh mục", 1, "", 1, 0, "", "")?>
      <?=$form->text("Tiêu đề truyện", "lib_story_title", "lib_story_title", $lib_story_title, "Tên truyện", 1, 272, "", 255, "", "", "")?>
      <?=$form->getFile("Ảnh đại diện", "lib_story_image", "lib_story_image", "Ảnh truyện", 0, 30, "", "")?>
      <?=$form->textarea("Giới thiệu","lib_story_intro","lib_story_intro",$lib_story_intro,"Giới thiệu",1,"300","100")?>
      <?
         if($type == 1){
      ?>
      <tr>
         <td></td>
         <td><?=$form->wysiwyg("<font class='form_asterisk'>*</font> Nội dung tiếng anh", "lib_story_en", $lib_story_en, "../../resource/wysiwyg_editor/", 800, 250)?></td>
      </tr>
      <tr>
         <td></td>
         <td><?=$form->wysiwyg("<font class='form_asterisk'>*</font> Nội dung tiếng việt", "lib_story_vi", $lib_story_vi, "../../resource/wysiwyg_editor/", 800, 250)?></td>
      </tr>
      <?
         }
      ?>
      <?=$form->text("Title", "meta_title", "meta_title", $meta_title, "Title", 0, 450, 24, 255, "", "", "")?>
      <?=$form->text("Description", "meta_description", "meta_description", $meta_description, "Description", 0, 450, 24, 255, "", "", "")?>
      <?=$form->text("Keywords", "meta_keywords", "meta_keywords", $meta_keywords, "Keywords", 0, 450,24, 255, "", "", "")?>
      <?=$form->text("Tags", "lib_story_tags", "lib_story_tags", $lib_story_tags, "Tags", 0, 450,24, 255, "", "", "<span  style=\"color: red;padding-left: 10px;\" >(Các từ khóa viết thường, cách nhau bằng dấu \",\")</span>")?>
      <?=$form->radio("Sau khi lưu dữ liệu", "add_new" . $form->ec . "return_listing", "after_save_data", $add . $form->ec . $listing, $after_save_data, "Thêm mới" . $form->ec . "Quay về danh sách", 0, $form->ec, "");?>
      <?=$form->button("submit" . $form->ec . "reset", "submit" . $form->ec . "reset", "submit" . $form->ec . "reset", "Cập nhật" . $form->ec . "Làm lại", "Cập nhật" . $form->ec . "Làm lại", 'style="background:url(' . $fs_imagepath . 'button_1.gif) no-repeat"' . $form->ec . 'style="background:url(' . $fs_imagepath . 'button_2.gif)"', "");?>
      <?=$form->hidden("action", "action", "execute", "");?>
   <?
   $form->close_table();
   $form->close_form();
   unset($form);
   ?>
   </p>
<?=template_bottom() ?>
</body>
</html>