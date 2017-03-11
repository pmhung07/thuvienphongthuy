<?
require_once("inc_security.php");
//check quyền them sua xoa
checkAddEdit("add");

	//Khai bao Bien
	$fs_redirect							= "add.php";
	$after_save_data						= getValue("after_save_data", "str", "POST", "add.php");
	$cat_type								= getValue("cat_type","str","GET","");
	$cat_order								= getValue("cat_order","str","GET","");
	$iParent								= getValue("iParent","str","GET","");
	$cat_order								+=	1;
	if($cat_type == "") $cat_type 	= getValue("cat_type","str","POST",-1);
	$sql									= "1";
	if($cat_type != "")  $sql				= " cat_type = '" . $cat_type . "'";
	$menu 									= new menu();
	$listAll 								= $menu->getAllChild("categories_multi","cat_id","cat_parent_id","0",$sql . " AND lang_id = " . $lang_id . $sqlcategory,"cat_id,cat_name,cat_order,cat_type,cat_parent_id,cat_has_child","cat_order ASC, cat_name ASC","cat_has_child");
	$arr_cat_view                    		= array(-1 => "- Lựa chọn hiển thị -" , 1 => "Hiển thị dạng khóa học" , 2 => "Hiển thị dạng đề thi");
    $arr_cat_view_test               		= array(-1 => "- Kiểu đề thi -" , 1 => "Hiển thị dạng TOEFL" , 2 => "Hiển thi dạng IELTS" , 3 => "Hiển thị dạng TOEIC");
    $active                          		= 1;
   //Call Class generate_form();
	$myform 									= new generate_form();
	//Loại bỏ chuc nang thay the Tag Html
	$myform->removeHTML(0);
	$myform->add("cat_type","cat_type",0,0,$cat_type,1,translate_text("Vui lòng chọn loại danh mục!"),0,"");
	$myform->add("cat_name","cat_name",0,0,"",1,translate_text("Vui lòng nhập tên danh mục"),0,"");
    $myform->add("cat_description","cat_description",0,0,"",0,"",0,"");
	if($array_config["order"]==1)  $myform->add("cat_order","cat_order",1,0,$cat_order,0,"",0,"");
	if($array_config["upper"]==1) $myform->add("cat_parent_id","cat_parent_id",1,0,$iParent,0,"",0,"");
	$myform->add("admin_id","admin_id",1,1,0,0,"",0,"");
	//Active data
	$myform->add("cat_active","active",1,1,1,0,"",0,"");
	//Add table
	$myform->addTable($fs_table);
	//Warning Error!
	$errorMsg = "";
	//Get Action.
	$action	= getValue("action", "str", "POST", "");
	if($action == "execute"){
		$errorMsg .= $myform->checkdata();
     	if($errorMsg == ""){
     		$upload		= new upload("cat_picture", $imgpath, $fs_extension, $fs_filesize);
	        $filename	= $upload->file_name;
	        if($filename != ""){
	      		$myform->add("cat_picture","filename",0,1,0,0);
	      		foreach($arr_resize as $type => $arr){
	      		   resize_image($imgpath, $filename, $arr["width"], $arr["height"], $arr["quality"], $type);
	      		}
	   		}
	   		$errorMsg .= $upload->show_warning_error();  
         	if($errorMsg == ""){  
	            $db_ex 	= new db_execute_return();
	   			$last_id = $db_ex->db_execute($myform->generate_insert_SQL());
	   			$iParent = getValue("cat_parent_id","int","POST");
						if($iParent > 0){
							$db_ex = new db_execute("UPDATE categories_multi SET cat_has_child = 1 WHERE cat_id = " . $iParent);
					}
				//echo $myform->generate_insert_SQL();
				// Redirect to add new
				$fs_redirect = "add.php?save=1&iParent=" . $iParent . "&cat_type=" . getValue("cat_type","str","POST") . "&cat_order=" . getValue("cat_order","int","POST");
				//Redirect to:
				redirect($fs_redirect);
				exit();
			}
     	} 
	}
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
<?=template_top(translate_text("Add_new_category"))?>
<? /*------------------------------------------------------------------------------------------------*/ ?>
	<p align="center" style="padding-left:10px;">
	<?
	$form = new form();
	$form->create_form("add", $_SERVER["REQUEST_URI"], "post", "multipart/form-data",'onsubmit="validateForm(); return false;"');
	$form->create_table();
	?>
	<?=$form->text_note('Những ô dấu (<font class="form_asterisk">*</font>) là bắt buộc phải nhập.')?>
	<?=$form->errorMsg($errorMsg)?>
	<tr> 
		<td align="right" nowrap class="form_name"><font class="form_asterisk">* </font> <?=translate_text("Loại danh mục")?> :</td>
		<td>
			<select name="cat_type" id="cat_type"  class="form_control" onChange="window.location.href='add.php?cat_type='+this.value">
				<option value="-1">- <?=translate_text("Chọn loại danh mục")?> - </option>
				<?
				foreach($array_value as $key => $value){
				?>
				<option value="<?=$key?>" <? if($key == $cat_type) echo "selected='selected'";?>><?=$value?></option>
				<? } ?>
			</select>
		</td>
	</tr>	
	<?=($array_config["upper"] != 0) ? $form->select_db_multi("Danh mục cha", "cat_parent_id", "cat_parent_id", $listAll, "cat_id", "cat_name", $cat_parent_id, "Chọn cấp cha", 1, "", 1, 0, "", "") : ''?>
	<?=$form->text("Tên danh mục", "cat_name", "cat_name", $cat_name, "Tên danh mục", 1, 250, "", 255, "", "", "")?>
	<?=$form->getFile("Ảnh đại diện", "cat_picture", "cat_picture", "Chọn hình ảnh", 1, 40, "", "")?>
	<?//=$form->textarea("Mô tả","cat_description","cat_description",$cat_description,"Mô tả",0,255,100,"","","")?>
	<tr>
	<td>
	  	<div class="form_name" style="text-align:left; padding:5px; width:99%;height:200px;"><font class="form_asterisk">*</font> Nội dung bài viết </div>
	</td>
	<td>
		<textarea class="cat_description" id="cat_description" name="cat_description" style="height: 250px;"><?=$cat_description?></textarea>
		<script src="/../../js/tinymce/tinymce.min.js" type="text/javascript" charset="utf-8"></script>
		<script type="text/javascript">
      	tinymce.init({
        selector: "textarea",   
        plugins: [
            "advlist autolink lists link charmap print preview anchor",
            "searchreplace visualblocks code fullscreen",
            "insertdatetime media table contextmenu paste jbimages image",
        ],
		toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image jbimages",  
		relative_urls: false , 
		theme_advanced_buttons1: "forecolor,backcolor,fontselect,fontsizeselect",  
      	});
      	</script> 
   	</td>
   	</tr>         
	<?=($array_config['order'] == 1) ? $form->text("Thứ tự", "cat_order", "cat_order", $cat_order, "Thứ tự hiển thị", 0, 50, "") : ''?>
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
<script>
	$("#cat_view_test").attr("disabled","true");
	$('#cat_view').change(function (){
		type_view_test =	$("#cat_view").val();
		if(type_view_test == 2){ 
			$("#cat_view_test").removeAttr('disabled'); 
		}else{
         	$("#cat_view_test").attr("disabled","true");
      	}
   	});  
</script>