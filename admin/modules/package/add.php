<?
require_once("inc_security.php");
//check quyền them sua xoa
checkAddEdit("add");

   //Khai bao Bien
   $fs_title = $module_name . " | Thêm mới";
   $fs_redirect = "add.php";
   $after_save_data = getValue("after_save_data", "str", "POST", "add.php");
   $cat_parent_id = getValue("cat_parent_id","str","GET","");
   $pack_cat_id                = getValue("pack_cat_id","str","GET","");
   $idCat = getValue('id','int','GET',0);
   $menu = new menu();
   $sql = '1';
   $pack_date = time();
   $listAll                 = $menu->getAllChild("categories_multi","cat_id","cat_parent_id","0",$sql . " AND cat_type =  1 AND cat_parent_id = 0 AND cat_active  = 1 AND lang_id = " . $lang_id . $sqlcategory,"cat_id,cat_name,cat_order,cat_type,cat_parent_id,cat_has_child","cat_order ASC, cat_name ASC","cat_has_child");
   // $listCate = new db_query("SELECT cat_id,cat_name
   //                           FROM categories_multi
   //                           WHERE ")
   //Call Class generate_form();
   $myform = new generate_form();
   //print_r($listCourse);
   //Loại bỏ chuc nang thay the Tag Html
   $myform -> removeHTML(0);
   $myform -> add("pack_name", "pack_name", 0, 0, $pack_cat_id, 1, "Bạn chưa nhập tên gói", 1, "Tên gói đã bị trùng");
   $myform -> add("pack_cat_id","pack_cat_id",1,0,0,1,translate_text("Vui lòng chọn loại danh mục!"),0);
   $myform -> add("pack_description", "pack_description", 0, 0, "", 0, "", 0, "");
   $myform -> add("pack_price", "pack_price", 0, 0, "", 1, "Bạn chưa nhập giá cho gói", 0, "");
   $myform -> add("pack_totalday", "pack_totalday", 0, 0, "", 1, "Bạn chưa nhập thời gian", 0, "");
   $myform -> add("pack_date", "pack_date", 0, 1, "", 0, "", 0, "");
   $myform -> add("pack_type", "pack_type", 0, 0, 1, 0, "", 0, "");
   $myform->addTable($fs_table);
   $fs_errorMsg = "";
   $action  = getValue("action", "str", "POST", "");
   if($action == "execute"){
    
   //Check form data : kiêm tra lỗi
   $fs_errorMsg .= $myform->checkdata(); 
      if($fs_errorMsg == ""){
         /*$upload     = new upload("pack_picture", $imgpath, $fs_extension_img, $fs_filesize);
         $filename   = $upload->file_name;
         if($filename != ""){
            $myform->add("pack_picture","filename",0,1,0,0);
            foreach($arr_resize as $type => $arr){
               resize_image($imgpath, $filename, $arr["width"], $arr["height"], $arr["quality"], $type);
            }
         }else{
            $fs_errorMsg .= "Bạn chưa nhập ảnh đại diện cho Unit!";
         }  
         $fs_errorMsg .= $upload->show_warning_error();*/
         if($fs_errorMsg == ""){     
            $myform->removeHTML(0);
            $db_insert = new db_execute_return();
            $last_test_id = $db_insert->db_execute($myform->generate_insert_SQL());
            unset($last_test_id);
            redirect("add.php");
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
<? $myform->checkjavascript();?>
</head>
   <body>
   <? /*------------------------------------------------------------------------------------------------*/ ?>
   <?=template_top($fs_title)?>
   <? /*------------------------------------------------------------------------------------------------*/ ?>
      <p align="center" style="padding-left:10px;">
      <?
      $form = new form();
      $form->create_form("add", $_SERVER["REQUEST_URI"], "post", "multipart/form-data",'onsubmit="validateForm(); return false;"');
      $form->create_table();
      ?>
      <?=$form->text_note('Những ô dấu (<font class="form_asterisk">*</font>) là bắt buộc phải nhập.')?>
      <?=$form->errorMsg($fs_errorMsg)?>
       <?=$form->text("Tên gói", "pack_name", "pack_name", $pack_name, "Tên gói", "", 250, "", 255, "", "", "")?>
       <tr> 
        <td align="right" nowrap class="form_name"><font class="form_asterisk">* </font> <?=translate_text("Danh mục")?> :</td>
        <td>
          <select name="pack_cat_id" id="pack_cat_id"  class="form_control" style="width: 255px;">
            <option value="">- <?=translate_text("Danh mục")?> - </option>
            <?
            foreach($listAll as $value){
            ?>
            <option value="<?=$value['cat_id']?>" <? if($pack_cat_id == $value['cat_id']) echo "selected='selected'";?>><?=$value['cat_name']?></option>
            <? } ?>
          </select>
        </td>
      </tr> 
       <?=$form->textarea("Mô tả gói", "pack_description", "pack_description", $pack_description, "Mô tả ngắn về gói", 1, 250, 60, "", "", "")?>
       <?=$form->text("Giá tiền", "pack_price", "pack_price", $pack_price, "Số tiền", 1, 250, "", 255, "", "", "")?>
       <?=$form->text("Thời gian học", "pack_totalday", "pack_totalday", $pack_totalday, "Thời gian", 1, 250, 24, 255, "", "", "")?>
       <?//=$form->text("Ngày tạo", "pack_date", "pack_date", $pack_date, "Ngày tạo", 1, 200, 24, 255, "", "", "")?>
       <?//=$form->getFile("Ảnh", "pack_picture", "pack_picture", "Ảnh", 1, 30, "", "")?>
       <?=$form->button("submit" . $form->ec . "reset", "submit" . $form->ec . "reset", "submit" . $form->ec . "reset", "Cập nhật" . $form->ec . "Làm lại", "Cập nhật" . $form->ec . "Làm lại", 'style="background:url(' . $fs_imagepath . 'button_1.gif) no-repeat"' . $form->ec . 'style="background:url(' . $fs_imagepath . 'button_2.gif)"', "");?>
      <?=$form->hidden("action", "action", "execute", "");?>
      <?
      $form->close_table();
      $form->close_form();
      unset($form);
       unset($sqlCourse);
      ?>
      </p>
   <?=template_bottom() ?>
   <? /*------------------------------------------------------------------------------------------------*/ ?>
   </body>
</html>