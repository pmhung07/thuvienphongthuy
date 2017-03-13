<?
require_once("inc_security.php");
//check quyền them sua xoa
checkAddEdit("add");
   $fs_title			= $module_name . " | Thêm mới";
   //Khai bao Bien
   $fs_redirect							= "add.php";
   $after_save_data						= getValue("after_save_data", "str", "POST", "add.php");
   $cat_parent_id							= getValue("cat_parent_id","str","GET","");
   $com_cou_id                      = getValue("com_cou_id","str","GET","");
   $com_c_id = $com_cou_id;
   $les_com_id							   = getValue("les_com_id","str","GET","");
   $menu 									= new menu();
   $sql                             = '1';
   $listAll 								= $menu->getAllChild("categories_multi","cat_id","cat_parent_id","0",$sql . " AND lang_id = " . $lang_id . $sqlcategory,"cat_id,cat_name,cat_order,cat_type,cat_parent_id,cat_has_child","cat_order ASC, cat_name ASC","cat_has_child");
   $sql1                            = 'com_cou_id = -1';

   //if($com_c_id != "") $sqlUnit     = new db_query("SELECT * FROM courses_multi WHERE com_cou_id = ".$com_c_id);
    $array_unit = array();
   if($com_cou_id > 0){
      $unit_select = new db_query("SELECT com_id,com_name FROM courses_multi
                                    WHERE com_cou_id =" .$com_cou_id. " AND com_active = 1");
      while($row_unit = mysqli_fetch_assoc($unit_select->result)){
         $array_unit[$row_unit["com_id"]] = $row_unit["com_name"];
      }unset($unit_select);
   }

   $arr_check = array();
   $db_select_unit = new db_query("SELECT * FROM courses_multi
                                    INNER JOIN lesson_details ON courses_multi.com_id = lesson_details.les_com_id
                                    WHERE les_det_type = 3");
   $i = 0;
   while($row_a = mysqli_fetch_assoc($db_select_unit->result)){
      $arr_check[$i] = $row_a["com_id"];
      $i++;
   }
   //Call Class generate_form();

   if($cat_parent_id != "")  $sqlCourse	= new db_query("SELECT cou_id,cou_name,cou_lev_id FROM courses WHERE cou_cat_id = ".$cat_parent_id );

   $myform 								   = new generate_form();
   //Loại bỏ chuc nang thay the Tag Html
   $myform->removeHTML(0);
   $myform->add("les_com_id", "les_com_id", 1, 0, "", 1, "Bạn chưa chọn Lesson", 0, "");
   $myform->add("les_det_name","les_det_name",0,0,"",1,translate_text("Vui lòng nhập tên cho phần Vocabulary"),0,"");
   $myform->add("les_det_type", "les_det_type", 1, 0, 3, 1, "Bạn chưa chọn Lesson", 0, "");
   //$myform->add("com_cou_id","com_cou_id",1,0,$iParent,0,"",0,"");
   //Add table
   $myform->addTable("lesson_details");
   //Warning Error!
   $fs_errorMsg = "";
   //Get Action.
   $action	= getValue("action", "str", "POST", "");
    if($action == "execute"){
        if($fs_errorMsg == ""){
    			//Insert to database
    			$myform->removeHTML(0);//loại bỏ  các ký tự html( 0 thi ko loại bỏ, 1: bỏ) tránh lỗi
                //thực hiện insert
    			$db_insert = new db_execute($myform->generate_insert_SQL());
    			//unset biến để giải phóng bộ nhớ.
                unset($db_insert);
    			//Redirect after insert complate
    			//$fs_redirect = "add.php?order=" . (getValue("cur_order","int","POST") + 1);
    			redirect("add.php");
    	}//End if($fs_errorMsg == "")

    }//End if($action == "insert")
	//add form for javacheck
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
<body topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0">
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
   <?=$form->select_db_multi("Chọn chuyên mục cha", "cat_parent_id", "cat_parent_id", $listAll, "cat_id", "cat_name", $cat_parent_id, "Chọn chuyên mục cha", 1, "", 1, 0, "onChange=\"window.location.href='add.php?cat_parent_id='+this.value\"", "")?>
   <?//$form->select_db_multi("Chọn Course", "com_cou_id", "com_cou_id", $listCourse, "cou_id", "cou_name", $com_cou_id, "Chọn Course", 1, "", 1, 0, "", "")?>
   <tr>
      <td align="right" nowrap class="form_name"><font class="form_asterisk">* </font> <?=translate_text("Chọn Course")?> :</td>
      <td>
         <select name="com_cou_id" id="com_cou_id"  class="form_control" style="width: 200px;" onChange="window.location.href='add.php?com_cou_id='+this.value+'&cat_parent_id=<?php echo $cat_parent_id; ?>'">
            <option value="-1">- <?=translate_text("Chọn Course")?> - </option>
            <?
            while($row = mysqli_fetch_assoc($sqlCourse->result)){
            ?>
            <option value="<?=$row['cou_id']?>" <?php if($row['cou_id'] == $com_c_id ) echo "selected='selected'" ;   ?>  ><? echo nameLevel($row['cou_lev_id']).' -- '.$row['cou_name']?></option>
            <? } ?>
         </select>
      </td>
   </tr>
   <tr>
      <td align="right" nowrap class="form_name"><font class="form_asterisk">* </font> <?=translate_text("Chọn Unit")?> :</td>
      <td>
         <select class="form_control" style="width: 186px;" name="les_com_id" id="les_com_id">
            <option value=""> - Chọn Unit - </option>
            <?foreach($array_unit as $id=>$name){
            if(in_array($id,$arr_check)) continue;
            ?>
     			<option value="<?=$id?>"><?=$name?></option>
      		<?}?>
         </select>
      </td>
   </tr>
    <?=$form->text("Tiêu đề","les_det_name","les_det_name",$les_det_name,"Tiêu đề",0,250,22)?>
    <?//$form->getFile("Media cho Grammar", "voc_media_url", "voc_media_url", "Media cho Grammar", 0, 30, "", "")?>
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