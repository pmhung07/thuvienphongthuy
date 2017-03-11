<?
require_once("inc_security.php");
checkAddEdit("add");

	$record_id = getValue('iCourses');
	$fs_title = $module_name . " | Danh sách quản lý Bài học";
	$fs_redirect = "add.php";
	$after_save_data = getValue("after_save_data", "str", "POST", "add.php");
	$com_active = 1;
	
	$myform = new generate_form();

	$myform -> removeHTML(0);
	$myform -> add("com_cou_id", "record_id", 1, 1, 0, 1, "Bạn chưa chọn Khóa học", 0, "");
	$myform -> add("com_name","com_name",0,0,"",1,translate_text("Vui lòng nhập tên Unit"),0,"");
	$myform -> add("com_num_unit","com_num_unit",1,0,"",1,translate_text("Vui lòng nhập số thứ tự cho Unit"),0,"");
	$myform -> add("com_active", "com_active", 1, 1, 0, 0, "", 0, "");
	
	$myform->addTable("courses_multi");
	$fs_errorMsg = "";
	$action	= getValue("action", "str", "POST", "");
   	if($action == "execute"){
		$fs_errorMsg .= $myform->checkdata(); 
		if($fs_errorMsg == ""){     
			$myform->removeHTML(0);
			$db_insert = new db_execute_return();
		  	$last_test_id = $db_insert->db_execute($myform->generate_insert_SQL());
			unset($db_insert);
			redirect("course_unit.php?iCourses=".$record_id);
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
   	<a style="background: #A0007F;text-decoration: none;color: white;padding: 10px 20px;display: -webkit-inline-box;text-transform: uppercase;" href="course_unit_withbom.php?iCourses=<?=$record_id?>">Refresh</a>	
   	<p align="center" style="padding-left:10px;">

   	<?
   	$form = new form();
   	$form->create_form("add", $_SERVER["REQUEST_URI"], "post", "multipart/form-data",'onsubmit="validateForm(); return false;"');
   	//$form->create_table();
   	?>
   	<table class="form_table" cellpadding="3" cellspacing="3" style="background: #D4E1F2;"><tbody>
   	<?=$form->text_note('Những ô dấu (<font class="form_asterisk">*</font>) là bắt buộc phải nhập.')?>
   	<?=$form->errorMsg($fs_errorMsg)?>
	<?=$form->text("Tên Bài học", "com_name", "com_name", $com_name, "Tên Unit", 1, 250, "", 255, "", "", "")?>
	<?=$form->text("Số thứ tự bài học", "com_num_unit", "com_num_unit", $com_num_unit, "Số thứ tự của Unit", 1, 25, "", 255, "", "", "")?>
	<?//=$form->checkbox("Hiển thị", "com_active", "com_active", 1 ,$com_active, "lựa chọn hiển thị ", "", "", "", "", "", "", "")?>
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

   <? /*------------------------------------------------------------------------------------------------*/ ?>
	<div class="wrap-add-content" style="padding-left:3px; padding-right:3px;">
	<table class="background: #C7DBFF;" cellpadding="5" cellspacing="0" width="100%" style="border-collapse:collapse;" bordercolor="#CCCCCC" border="1">
		<tr style="background: #3D3D3F;color: white;">
			<th width="10">ID</th>
			<th width="200">Tên bài học</th>
			<th>Khóa học</th>
			<th width="100">Thứ tự</th>
			<th width="100" align="center">Chi tiết bài học</th>
			<th width="200" align="center">Thêm Tabs bài học</th>
     		<th width="10" align="center">Sửa</th>
			<th width="10" align="center">Xóa</th>
		</tr>
		<?
		$sql = '';
		$db_picture = new db_query("SELECT * 
									  FROM courses_multi a , courses b
									 WHERE a.com_cou_id = b.cou_id 
									   AND com_cou_id=" . $record_id." ORDER BY com_num_unit");
		$i=0;
		while($row = mysql_fetch_assoc($db_picture->result)){
			$i++;
		?>
			<tr <?=$fs_change_bg?>>
				<td align="center"><?=$i?></td>
            	<td align="center" align="center">
            		<input class="update_unitname_<?=$row["com_id"]?>" type="text" class="update_unitname" value="<?=$row["com_name"]?>">
		            <span onclick="update_unitname(<?=$row["com_id"]?>)" style="cursor:pointer;text-decoration: none;padding: 6px 10px;background: #0054C2;color: white;">Save</span>
            	</td>
            	<td align="center" align="center"><?=$row["cou_name"]?></td>
            	<td align="center">
            		<input class="valueorder_<?=$row["com_id"]?>" style="width:15px;" type="text" value="<?=$row["com_num_unit"]?>">
		            <span onclick="update_orderunit(<?=$row["com_id"]?>)" style="cursor:pointer;text-decoration: none;padding: 6px 10px;background: #00C28E;color: white;" href="course_unit.php?iCourses=<?=$row[$id_field]?>">Update</span>
            	</td>
            	<td align="">
		            <span onclick="invitr(<?=$row["com_id"]?>)" style="cursor:pointer;text-decoration: none;padding: 6px 10px;background: #AE0000;color: white;">Chi tiết</span>
		        </td>
		        <td align="center">
		        	<input class="valuetab_<?=$row["com_id"]?>" type="text" class="add_tab" value="">
		            <span onclick="addtabs(<?=$row["com_id"]?>)" style="cursor:pointer;text-decoration: none;padding: 6px 10px;background: #0054C2;color: white;">Thêm</span>
		        </td>
				<td align="center"><a class="text" href="edit_picture.php?record_id=<?=$row["img_id"]?>&story_id=<?=$record_id?>&returnurl=<?=base64_encode(getURL())?>"><img src="<?=$fs_imagepath?>edit.png" alt="EDIT" border="0"/></a></td>
            	<td align="center"><a onclick="if (confirm('Bạn muốn xóa bản ghi?')){ window.location.href='delete_picture.php?record_id=<?=$row["img_id"]?>&url=<?=base64_encode($_SERVER['REQUEST_URI'])?>' }" href="#" class="delete"><img border="0" src="<?=$fs_imagepath?>delete.gif"></a></td>
			</tr>
			<?  
			$db_tabs = new db_query("SELECT * FROM courses_multi_tabs WHERE cou_tab_com_id=" . $row["com_id"]." ORDER BY cou_tab_order");
			$j=0;
			while($rowtab = mysql_fetch_assoc($db_tabs->result)){
			$j++;
			?>
			<tr class="trinvi trinvi_<?=$row["com_id"]?>" style="background:rgb(221, 223, 255);">
				<td align="center"><?=$j?></td>
            	<td align="center" align="center">
            		<input class="update_tabname_<?=$rowtab["cou_tab_id"]?>" type="text" class="update_unitname" value="<?=$rowtab["cou_tab_name"]?>">
		            <span onclick="update_tabname(<?=$rowtab["cou_tab_id"]?>)" style="cursor:pointer;text-decoration: none;padding: 6px 10px;background: #0054C2;color: white;">Save</span>
            	</td>
            	<td align="center" align="center"><?=$row["cou_name"]?></td>
            	<td align="center">
            		<input class="value_ordertab_<?=$rowtab["cou_tab_id"]?>" style="width:15px;" type="text" class="" value="<?=$rowtab["cou_tab_order"]?>">
		            <span onclick="update_ordertab(<?=$rowtab["cou_tab_id"]?>)" style="cursor:pointer;text-decoration: none;padding: 6px 10px;background: #00C28E;color: white;" href="">Update</span>
            	</td>
            	<td colspan="3" align="">
		            <a style="text-decoration: none;padding: 6px 45px;background: #00515F;color: white;" href="course_unit_data.php?iTab=<?=$rowtab["cou_tab_id"]?>&iUnit=<?=$row["com_id"]?>&url=<?=base64_encode($_SERVER['REQUEST_URI'])?>">Chi tiết</a>
		        </td>
            	<td align="center"><a onclick="if (confirm('Bạn muốn xóa bản ghi?')){ window.location.href='delete_picture.php?record_id=<?=$row["img_id"]?>&url=<?=base64_encode($_SERVER['REQUEST_URI'])?>' }" href="#" class="delete"><img border="0" src="<?=$fs_imagepath?>delete.gif"></a></td>
			</tr>
			<? } ?>
		<? } ?>
	</table>
	</div>
<? /*------------------------------------------------------------------------------------------------*/ ?>


   </body>
</html>

<script type="text/javascript">
//-------------------------------------------------



function invitr(com_id){
	$(".trinvi").css("display","none");	
   	$(".trinvi_"+com_id).fadeIn(300); //css("display","table-row");
}

function addtabs(com_id){
   	var valtab = $('.valuetab_'+com_id).val();
	$.ajax({
		type:'POST',
		dataType:'json',
		data:{
			com_id:com_id,
			valtab:valtab,
			tab_type:"add_tabs"
      	},
		url:'ajax.php',
		success:function(data){
			if(data.err == ''){
				alert(data.msg);	
				window.location.reload();
			}else{
				alert(data.err);
			}
      	}
   	});
}

function update_unitname(com_id){
   	var unitname = $('.update_unitname_'+com_id).val();
	$.ajax({
		type:'POST',
		dataType:'json',
		data:{
			com_id:com_id,
			unitname:unitname,
			tab_type:"update_unitname"
      	},
		url:'ajax.php',
		success:function(data){
			if(data.err == ''){
				alert(data.msg);	
				window.location.reload();
			}else{
				alert(data.err);
			}
      	}
   	});
}

function update_tabname(cou_tab_id){
   	var unitname = $('.update_tabname_'+cou_tab_id).val();
	$.ajax({
		type:'POST',
		dataType:'json',
		data:{
			cou_tab_id:cou_tab_id,
			unitname:unitname,
			tab_type:"update_tabname"
      	},
		url:'ajax.php',
		success:function(data){
			if(data.err == ''){
				alert(data.msg);	
				window.location.reload();
			}else{
				alert(data.err);
			}
      	}
   	});
}

function update_orderunit(com_id){
   	var order = $('.valueorder_'+com_id).val();
	$.ajax({
		type:'POST',
		dataType:'json',
		data:{
			com_id:com_id,
			order:order,
			tab_type:"update_orderunit"
      	},
		url:'ajax.php',
		success:function(data){
			if(data.err == ''){
				alert(data.msg);	
				//window.location.reload();
			}else{
				alert(data.err);
			}
      	}
   	});
}

function update_ordertab(com_id){
   	var order = $('.value_ordertab_'+com_id).val();
	$.ajax({
		type:'POST',
		dataType:'json',
		data:{
			cou_tab_id:com_id,
			order:order,
			tab_type:"update_ordertab"
      	},
		url:'ajax.php',
		success:function(data){
			if(data.err == ''){
				alert(data.msg);	
				//window.location.reload();
			}else{
				alert(data.err);
			}
      	}
   	});
}

</script>

<style type="text/css">
.trinvi{display: none;}
.wrap-add-content span:hover{
	background: #1C3D7B!important;
}
.wrap-add-content a:hover{
	background: #1C3D7B!important;
}
</style>