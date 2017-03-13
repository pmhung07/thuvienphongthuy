<?
include("inc_security.php");
checkAddEdit("add");
//khai báo biến
$fs_redirect 	= base64_decode(getValue("url","str","GET",base64_encode("listing.php")));
$record_id 		= getValue("record_id");
$fs_errorMsg	= '';
$fs_fieldupload = "images_story";
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
$myform->add("img_translate", "img_translate", 0, 0, "", 0, "", 0, "");
$myform->add("img_order", "img_order", 1, 0, 0, 0, "", 0, "");
$myform->add("img_story_id", "record_id", 1, 1, 0, 0, "", 0, "");
//Add table insert data
$myform->addTable("images_story");

//Get action variable for add new data
$action				= getValue("action", "str", "POST", "");
//Check $action for insert new data
if($action == "execute"){

	$upload			= new upload($fs_fieldupload, $imgpath_more_pic, $fs_extension, $fs_filesize);
	if($upload->file_name != ""){
		$$fs_fieldupload = $upload->file_name;
		$myform->add("img_url", $fs_fieldupload, 0, 1, "", 0, "", 0, "");
		// resize
      foreach($arr_resize as $type => $arr){
         resize_image($imgpath_more_pic, $$fs_fieldupload, $arr["width"], $arr["height"], $arr["quality"], $type);
      }
	}//End if($filename != "")

	//Check form data
	$fs_errorMsg .= $myform->checkdata();
	$fs_errorMsg	.= $upload->warning_error;
	if($fs_errorMsg == ""){

		//Insert to database
		$db_insert		= new db_execute($myform->generate_insert_SQL());
		redirect($_SERVER['REQUEST_URI']);

	}//End if($fs_errorMsg == "")

}//End if($action == "execute")
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<style type="text/css">
.info_category{
font-weight:bold;
margin:5px;
}
</style>
<?=$load_header?>
<?
$myform->checkjavascript();
//chuyển các trường thành biến để lấy giá trị thay cho dùng kiểu getValue
$myform->evaluate();
$fs_errorMsg .= $myform->strErrorField;
?>
</head>
<body topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0">
<? /*------------------------------------------------------------------------------------------------*/ ?>
	<?
	$form = new form();
	$form->create_form("add", $_SERVER['REQUEST_URI'], "post", "multipart/form-data",'onsubmit="validateForm(); return false;"');
	$form->create_table();
	?>
	<?=$form->text_note('Những ô có dấu sao (<font class="form_asterisk">*</font>) là bắt buộc phải nhập.')?>
	<?=$form->errorMsg($fs_errorMsg)?>
	<?=$form->getFile("Ảnh", $fs_fieldupload, $fs_fieldupload, "Ảnh minh họa", 1, 30, "", "")?>
	<?=$form->textarea("Bản dịch", "img_translate", "img_translate", $img_translate, "Bản dịch", 0, 300, 40, 255, "", "", "")?>
   <?=$form->text("Thứ tự", "img_order", "img_order", $img_order, "Thứ tự", 0, 40, "", 255, "", "", "")?>
	<?=$form->button("submit" . $form->ec . "reset", "submit" . $form->ec . "reset", "submit" . $form->ec . "reset", "Cập nhật" . $form->ec . "Đóng cửa sổ", "Cập nhật" . $form->ec . "Đóng cửa sổ", 'style="background:url(' . $fs_imagepath . 'button_1.gif) no-repeat"' . $form->ec . 'style="background:url(' . $fs_imagepath . 'button_2.gif)" onclick="window.parent.tb_remove()"', "");?>
	<?=$form->hidden("action", "action", "execute", "");?>
	<?//=$form->hidden("ppic_temp_key", "ppic_temp_key", $temp_key, "");?>
	<?
	$form->close_table();
	$form->close_form();
	unset($form);
	?>

<? /*------------------------------------------------------------------------------------------------*/ ?>
	<div style="padding-left:3px; padding-right:3px;">
	<table cellpadding="5" cellspacing="0" width="100%" style="border-collapse:collapse;" bordercolor="#CCCCCC" border="1">
		<tr>
			<th width="10">ID</th>
			<th>Ảnh</th>
         <th width="200">Bản dịch</th>
			<th width="10">Thứ tự</th>
         <th width="10" align="center">Sửa</th>
			<th width="10" align="center">Xóa</th>
		</tr>
		<?
		$sql = '';
		//if($temp_key != '') $sql .= " AND ppic_temp_key = '" . $temp_key . "'";
		$db_picture = new db_query("SELECT *
											 FROM images_story
											 WHERE  img_story_id=" . $record_id . $sql);
		?>
		<?
		$i=0;
		while($row = mysqli_fetch_assoc($db_picture->result)){
			$i++;
		?>
			<tr <?=$fs_change_bg?>>
				<td align="center"><?=$i?></td>
				<td align="center" width="60"><img src="<?=$imgpath_more_pic?>small_<?=$row["img_url"]?>" width="50" height="40" /></td>
            <td width="200"><textarea style="width: 300px;height: 34px;"><?=$row["img_translate"]?></textarea></td>
            <td width="50" align="center"><?=$row["img_order"]?></td>
				<td align="center"><a class="text" href="edit_picture.php?record_id=<?=$row["img_id"]?>&story_id=<?=$record_id?>&returnurl=<?=base64_encode(getURL())?>"><img src="<?=$fs_imagepath?>edit.png" alt="EDIT" border="0"/></a></td>
            <td align="center"><a onclick="if (confirm('Bạn muốn xóa bản ghi?')){ window.location.href='delete_picture.php?record_id=<?=$row["img_id"]?>&url=<?=base64_encode($_SERVER['REQUEST_URI'])?>' }" href="#" class="delete"><img border="0" src="<?=$fs_imagepath?>delete.gif"></a></td>
			</tr>
		<?
		}
		?>
	</table>
	</div>
<? /*------------------------------------------------------------------------------------------------*/ ?>

</body>
</html>