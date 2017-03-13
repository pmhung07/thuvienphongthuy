<?
require_once("inc_security.php");
//check quyền them sua xoa
checkAddEdit("add");

   //Khai bao Bien
   $fs_title = $module_name . " | Thêm mới";
   $add = "add.php";
   $listing = "listing.php";
	$after_save_data = getValue("after_save_data", "str", "POST", "add.php");
   $fs_redirect = $after_save_data;
   $cat_parent_id = getValue("cat_parent_id","str","GET","");
   $skl_cont_les_id = getValue("skl_cont_les_id","int","GET","");
   $skl_c_les_id = $skl_cont_les_id;
   $fs_errorMsg = "";

   //Array type of Skill Content
   $arr_type = array( 1 => translate_text("Dạng 1"),
                      2 => translate_text("Dạng 2"),
                      3 => translate_text("Dạng 3"),
                      4 => translate_text("Dạng 4"),
                      5 => translate_text("Dạng 5")
                     );
   //Mang kiem tra content co cham diem hay khong
   $arr_mark = array( 0 => translate_text("Không chấm"),
                      1 => translate_text("Chấm ghi âm"),
                      2 => translate_text("Chấm bài viết"));

   //Mang lua chon vi tri cua content
   $arr_pos = array(  1 => translate_text("Box1 (Top - Left)"),
                      2 => translate_text("Box2 (Top - Right)"),
                      3 => translate_text("Box3 (Middle)"));

   //List Danh muc
   $menu = new menu();
   $sql = '1';
   $sql = ' cat_type = 0';
   $listAll = $menu->getAllChild("categories_multi","cat_id","cat_parent_id","0",$sql . " AND lang_id = " . $lang_id . $sqlcategory,"cat_id,cat_name,cat_order,cat_type,cat_parent_id,cat_has_child","cat_order ASC, cat_name ASC","cat_has_child");
   //========================================================================================//
	if($cat_parent_id != "")  $sqlLesson	= new db_query("SELECT * FROM skill_lesson WHERE skl_les_cat_id = ".$cat_parent_id );

	$myform 		= new generate_form();
	$myform->removeHTML(0);
   $myform->add("skl_cont_les_id", "skl_cont_les_id", 1, 0, 0, 1, "Bạn chưa chọn bài học", 0, "");
	$myform->add("skl_cont_title","skl_cont_title",0,0,"",0,"",0,"");
   $myform->add("skl_content","skl_content",0,0,"",0,"",0,"");
   $myform->add("skl_cont_type","skl_cont_type",1,0,1,1,"Bạn chưa chọn kiểu nội dung",0,"");
   $myform->add("skl_cont_mark","skl_cont_mark",1,0,0,0,"",0,"");
   $myform->add("skl_cont_pos","skl_cont_pos",1,0,1,0,"",0,"");
   $myform->add("skl_cont_order","skl_cont_order",1,0,0,1,"Bạn chưa nhập thứ tự cho Content",0,"");
   $myform->add("skl_cont_active","skl_cont_active",1,0,0,0,"",0,"");
	$myform->addTable($fs_table);

	//Get Action.
	$action	= getValue("action", "str", "POST", "");
   if($action == "execute"){
      //Check form data : kiêm tra lỗi
   $fs_errorMsg .= $myform->checkdata();
      if($fs_errorMsg == ""){
      	$myform->removeHTML(0);
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
	$form->create_form("add", $_SERVER["REQUEST_URI"], "post", "multipart/form-data",'onsubmit="validateForm(); return false;"');
	$form->create_table();
	?>
   <?//=$form->text_note('<strong style="text-align:center;">----------Thêm mới bài học chính-----------</strong>')?>
	<?=$form->text_note('Những ô dấu (<font class="form_asterisk">*</font>) là bắt buộc phải nhập.')?>
	<?=$form->errorMsg($fs_errorMsg)?>
	<?=$form->select_db_multi("Chọn danh mục", "cat_parent_id", "cat_parent_id", $listAll, "cat_id", "cat_name", $cat_parent_id, "Chọn danh mục", 1, "", 1, 0, "onChange=\"window.location.href='add.php?cat_parent_id='+this.value\"", "")?>
   <tr>
      <td align="right" nowrap="" class="form_name"><font class="form_asterisk">* </font> <?=translate_text("Chọn bài học")?> :</td>
      <td>
         <select name="skl_cont_les_id" id="skl_cont_les_id"  class="form_control" style="width: 200px;">
         	<option value="-1">- <?=translate_text("Chọn bài học")?> - </option>
         	<?
         	while($row = mysqli_fetch_assoc($sqlLesson->result)){
         	?>
         	<option value="<?=$row['skl_les_id']?>" <?if($row['skl_les_id'] == $skl_c_les_id) echo "selected='selected'";?>><?=$row['skl_les_name']?></option>
            <?} ?>
         </select>
      </td>
   </tr>
   <tr>
      <td align="right" nowrap="" class="form_name"><font class="form_asterisk">* </font> <?=translate_text("Chọn kiểu hiển thị nội dung")?> :</td>
      <td>
         <select name="skl_cont_type" id="skl_cont_type"  class="form_control" style="width: 200px;">
         	<option value="-1">- <?=translate_text("Chọn kiểu nội dung")?> - </option>
         	<?
            foreach($arr_type as $key => $value){
            ?>
               <option value="<?=$key?>">-<?=$value?>- </option>
            <?
            }
            ?>
         </select>
      </td>
   </tr>
   <tr>
      <td></td>
      <td class="red">Dạng 1: Media(Video,Image,Flash).Có nút nội dung, có nút dịch...(Giống dạng main lesson)</td>
   </tr>
   <tr>
      <td></td>
      <td class="red">Dạng 2: Media(Video,Image,Flash).Hiển thị text nội dung...(Giống dạng grammar lesson)</td>
   </tr>
   <tr>
      <td></td>
      <td class="red">Dạng 3: Media(Video,Image,Flash).Hiển thị text nội dung...(Giống dạng vocab lesson)</td>
   </tr>
   <tr>
      <td></td>
      <td class="red">Dạng 4: Media(Video,Image,Flash).Hiển thị text nội dung...(Giống dạng learn writing)</td>
   </tr>
   <tr>
      <td align="right" nowrap="" class="form_name"><font class="form_asterisk">* </font> <?=translate_text("Chấm điểm")?> :</td>
      <td>
         <select name="skl_cont_mark" id="skl_cont_mark"  class="form_control" style="width: 200px;">
         	<?
            foreach($arr_mark as $key => $value){
            ?>
               <option value="<?=$key?>">-<?=$value?>- </option>
            <?
            }
            ?>
         </select>
      </td>
   </tr>
   <tr>
      <td align="right" nowrap="" class="form_name"><font class="form_asterisk">* </font> <?=translate_text("Chọn vị trí của content")?> :</td>
      <td>
         <select name="skl_cont_pos" id="skl_cont_pos"  class="form_control" style="width: 200px;">
         	<?
            foreach($arr_pos as $key => $value){
            ?>
               <option value="<?=$key?>">-<?=$value?>- </option>
            <?
            }
            ?>
         </select>
      </td>
   </tr>
   <tr>
      <td></td>
      <td class="red">Nếu bài học có dạng CHẤM LUYỆN NÓI hoặc CHẤM LUYỆN VIẾT thì Content luôn chọn dạng Box1</td>
   </tr>
   <?=$form->text("Tiêu đề","skl_cont_title","skl_cont_title",$skl_cont_title,"Tiêu đề",0,250,"",255,"","","");?>
   <?=$form->textarea("Nội dung","skl_content","skl_content",$skl_content,"Nội dung",0,300,100,"","","");?>
   <?=$form->text("Thứ tự","skl_cont_order","skl_cont_order",$skl_cont_order,"Thứ tự",1,50,"",50,"","","");?>
   <?=$form->checkbox("Kích hoạt", "skl_cont_active", "skl_cont_active", 1, $skl_cont_active, "Kích hoạt", 0, "", "")?>
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
<? /*------------------------------------------------------------------------------------------------*/ ?>
</body>
</html>
<style type="text/css">
.red{
   color: red
}
</style>