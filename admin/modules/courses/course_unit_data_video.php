<?
require_once("inc_security.php");
checkAddEdit("add");

$iUnit = getValue('iUnit');
error_reporting(E_ALL);
$fs_title = $module_name . " | Thêm nội dung Video chung cho toàn bộ bài học";
$fs_redirect = base64_decode(getValue("url","str","GET",base64_encode("listing.php")));
$after_save_data = getValue("after_save_data", "str", "POST", "add.php");
$com_active = 1;
$fs_errorMsg = "";
$fs_fieldupload = "";

$myform = new generate_form();

$dbquery2 = new db_query("SELECT * FROM courses_multi WHERE com_id =".$iUnit);
$arrUnits = $dbquery2->resultArray();

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
$myform->add("cou_tab_media_name", "cou_tab_media_name", 0, 0, "", 0, "", 0, "");
$myform->add("cou_tab_media_order", "cou_tab_media_order", 1, 0, 0, 0, "", 0, "");
$myform->add("cou_tab_media_unit_id", "iUnit", 1, 1, 0, 0, "", 0, "");
//Add table insert data
$myform->addTable("courses_multi_tab_media");
//Get action variable for add new data
$action				= getValue("action", "str", "POST", "");
//Check $action for insert new data
if($action == "execute"){
   	$upload = new upload("cou_tab_media_url", $imgpath_data, $fs_extension_vid, $fs_filesize );
	$filename = $upload->file_name;
	if($filename != ""){
		$myform->add("cou_tab_media_url","filename", 0, 1, "", 0);
	}
	$fs_errorMsg 	.= $upload->show_warning_error();
	$fs_errorMsg 	.= $myform->checkdata();
	$fs_errorMsg	.= $upload->warning_error;
	if($fs_errorMsg == ""){
		$db_insert		= new db_execute($myform->generate_insert_SQL());
		redirect($_SERVER['REQUEST_URI']);
	}
}
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
   	<div class="navtool" style="width:50%;">
   		<div class="navtool_title">Unit : <span><?=$arrUnits[0]['com_name']?></span></div>
   	</div>

   	<? /*------------------------------------------------------------------------------------------------*/ ?>
	<div style="width:50%;background: #E2EDFC;">
	<?
	$form = new form();
	$form->create_form("add", $_SERVER['REQUEST_URI'], "post", "multipart/form-data",'onsubmit="validateForm(); return false;"');
	$form->create_table();
	?>
	<?=$form->text_note('Những ô có dấu sao (<font class="form_asterisk">*</font>) là bắt buộc phải nhập.')?>
	<?=$form->errorMsg($fs_errorMsg)?>
	<?=$form->text("Tiêu đề Video", "cou_tab_media_name", "cou_tab_media_name", "", "Tiêu đề Video", 0, 300, 20, 255, "", "", "")?>
	<?=$form->getFile("Upload Video", "cou_tab_media_url", "cou_tab_media_url", "Upload Video", 1, 30, "style='border:none;'", "")?>
   	<?=$form->text("Thứ tự", "cou_tab_media_order", "cou_tab_media_order", "", "Thứ tự", 0, 40, "", 255, "", "", "")?>
	<?=$form->button("submit" . $form->ec . "reset", "submit" . $form->ec . "reset", "submit" . $form->ec . "reset", "Cập nhật" . $form->ec . "Đóng cửa sổ", "Cập nhật" . $form->ec . "Đóng cửa sổ", 'style="background:url(' . $fs_imagepath . 'button_1.gif) no-repeat"' . $form->ec . 'style="background:url(' . $fs_imagepath . 'button_2.gif)" onclick="window.parent.tb_remove()"', "");?>
	<?=$form->hidden("action", "action", "execute", "");?>
	<?//=$form->hidden("ppic_temp_key", "ppic_temp_key", $temp_key, "");?>
	<?
	$form->close_table();
	$form->close_form();
	unset($form);
	?>
	</div>

<? /*------------------------------------------------------------------------------------------------*/ ?>
	<div style="width:50%;">
	<table cellpadding="5" cellspacing="0" width="100%" style="border-collapse:collapse;" bordercolor="#CCCCCC" border="1">
		<tr style="background: #02919D;color:white;">
			<th width="10">ID</th>
			<th width="200">Tiêu đề</th>
			<th width="100">URL VIDEO</th>
			<th width="50">Thứ tự</th>
			<th width="50">Sửa</th>
			<th width="20" align="center">Xóa</th>
		</tr>
		<?
		$sql = '';
		$db_picture = new db_query("SELECT * FROM courses_multi_tab_media WHERE  cou_tab_media_unit_id=" . $iUnit . $sql);
		?>
		<?
		$i=0;
		while($row = mysqli_fetch_assoc($db_picture->result)){
			$i++;
		?>
			<tr <?=$fs_change_bg?>>
				<td align="center"><?=$i?></td>
				<td align="center" width="60">REQUEST</td>
	            <td width="200"><?=$row["cou_tab_media_name"]?></td>
	            <td width="50" align="center"><?=$row["cou_tab_media_order"]?></td>
	            <td align="center"><a class="text" href="course_unit_data_video_edit.php?record_id=<?=$row["cou_tab_media_id"]?>&returnurl=<?=base64_encode(getURL())?>"><img src="<?=$fs_imagepath?>edit.png" alt="EDIT" border="0"/></a></td>
	            <td align="center"><a onclick="if (confirm('Bạn muốn xóa bản ghi?')){ window.location.href='course_unit_data_video_delete.php?record_id=<?=$row["cou_tab_media_id"]?>&returnurl=<?=base64_encode(getURL())?>' }" href="#" class="delete"><img border="0" src="<?=$fs_imagepath?>delete.gif"></a></td>
			</tr>
		<?
		}
		?>
	</table>
	</div>



   <?=template_bottom() ?>
   <? /*------------------------------------------------------------------------------------------------*/ ?>




   </body>
</html>
<style type="text/css">
.tab_videocodinh{
	background: #18A892!important;
}
.tab_noidung{
	background: #1887A8!important;
}
.tab_baitap{
	background: #A85A18!important;
}
.trinvi{display: none;}
.wrap-add-content span:hover{
	background: #1C3D7B!important;
}
.wrap-add-content a:hover{
	background: #1C3D7B!important;
}
.navtool{
	overflow: hidden;
	width: 100%;
}
.navtool_title{
	height: 35px;
	line-height: 35px;
	background: #303030;
	color: white;
	font-size: 11px;
	padding-left: 20px;
	margin-top: 2px;
}
.navtool_title span{
	text-transform: uppercase;
}
.sidebartool{
	float: left;
	width: 100%;
}
.contenttool{
	float: left;
	width: 75%;
	height: 300px;
}
.sidebartool a{
	width: 25%;
	display: block;
	height: 30px;
	line-height: 30px;
	text-decoration: none;
	padding-left: 20px;
	background: #454545;
	color: white;
	margin-bottom: 1px;
}
.sidebartool a:hover{
	margin-left: 5px;
}
</style>