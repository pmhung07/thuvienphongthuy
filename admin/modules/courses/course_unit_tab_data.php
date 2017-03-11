<?
require_once("inc_security.php");
checkAddEdit("add");

$iTab = getValue('iTab');
$iUnit = getValue('iUnit');
$fs_title = $module_name . " | Thêm nội dung cho phần bài học ( Tabs )";
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
9). Loi dua ra man hinh neu co duplicatee
*/
//$cou_tab_cont_media = 1;
$cou_tab_cont_active = 1;


$myform = new generate_form();
$myform->add("cou_tab_cont_tabs_id", "iTab", 1, 1, "", 0, "", 0, "");
$myform->add("cou_tab_cont_block_id", "cou_tab_cont_block_id", 1, 0, "", 0, "", 0, "");
$myform->add("cou_tab_cont_title", "cou_tab_cont_title", 0, 0, "", 0, "", 0, "");
$myform->add("cou_tab_cont_text", "cou_tab_cont_text", 0, 0, "", 0, "", 0, "");
$myform->add("cou_tab_cont_media_type", "cou_tab_cont_media_type", 1, 0, 0, 0, "", 0, "");
$myform->add("cou_tab_cont_order", "cou_tab_cont_order", 1, 0, 0, 0, "", 0, "");
$myform->add("cou_tab_cont_active", "cou_tab_cont_active", 1, 1, 0, 0, "", 0, "");
$myform->add("cou_tab_cont_text_type", "cou_tab_cont_text_type", 1, 0, "", 0, "", 0, "");
$myform->add("cou_tab_cont_main_voca", "cou_tab_cont_main_voca", 0, 0, "", 0, "", 0, "");
$myform->add("cou_tab_cont_phonetic_voca", "cou_tab_cont_phonetic_voca", 0, 0, "", 0, "", 0, "");
$myform->add("cou_tab_cont_exam_voca", "cou_tab_cont_exam_voca", 0, 0, "", 0, "", 0, "");

//Add table insert data
$myform->addTable("courses_multi_tabs_content");
//Get action variable for add new data
$action				= getValue("action", "str", "POST", "");
//Check $action for insert new data
if($action == "execute"){
   	$upload = new upload("cou_tab_cont_media", $imgpath_data, $fs_extension_all, $fs_filesize );
	$filename = $upload->file_name;
	if($filename != ""){
		$myform->add("cou_tab_cont_media","filename", 0, 1, "", 0);
	}

	$uploadVoca = new upload("cou_tab_cont_img_voca", $imgpath_data, $fs_extension_all, $fs_filesize );
	$filenameVoca = $uploadVoca->file_name;
	if($filenameVoca != ""){
		$myform->add("cou_tab_cont_img_voca","filenameVoca", 0, 1, "", 0);
	}

	$uploadAudio = new upload("cou_tab_cont_audio_voca", $imgpath_data, $fs_extension_all, $fs_filesize );
	$filenameAudio = $uploadAudio->file_name;
	if($filenameAudio != ""){
		$myform->add("cou_tab_cont_audio_voca","filenameAudio", 0, 1, "", 0);
	}

	$fs_errorMsg 	.= $upload->show_warning_error();
	$fs_errorMsg 	.= $uploadVoca->show_warning_error();
	$fs_errorMsg 	.= $uploadAudio->show_warning_error();
	$fs_errorMsg 	.= $myform->checkdata();
	$fs_errorMsg	.= $upload->warning_error;
	if($fs_errorMsg == ""){
		$myform->removeHTML(0);
		$db_insert		= new db_execute($myform->generate_insert_SQL());
		redirect($_SERVER['REQUEST_URI']);
	}
}

$db_block = new db_query("SELECT * FROM courses_multi_tabs_block WHERE  com_block_tab_id=" . $iTab . " AND com_block_data_type ='content_data'");
$arrayBlock = array();
$arrayBlock[0] = "Chọn Block để thêm nội dung";
$i=1;
while($row = mysql_fetch_assoc($db_block->result)){
	$arrayBlock[$row['com_block_id']] = $row['com_block_data_name'];
	$i++;
}


$arrayMedia = array(
	0 => "Chon kiểu Media",
	1 => "Kiểu Video",
	2 => "Kiểu Audio",
	3 => "Kiểu Images"
);

$arrayTypeContent = array(
	"-1" => "Chọn dạng nội dung",
	"1" => "Nội dung dạng text",
	"2" => "Nội dung từ vựng"
);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<?=$load_header?>
<?//$myform->checkjavascript();?>
</head>
   	<body>
   	<? /*------------------------------------------------------------------------------------------------*/ ?>
   	<?=template_top($fs_title)?>
   	<? /*------------------------------------------------------------------------------------------------*/ ?>
   	<div class="navtool" style="width:100%;">
   		<div class="navtool_title">Unit : <span><?=$arrUnits[0]['com_name']?></span></div>
   	</div>

   	<? /*------------------------------------------------------------------------------------------------*/ ?>
	<div style="width:100%;background: #E2EDFC;">

	<div class="addblockintab" style="height: 50px;line-height: 50px;background: #BD0000;">
		<input class="addblock_<?=$iTab?>" style="height: 25px;border: none;margin-left: 115px;" type="text" value ="Tiêu đề Block">
		<span onclick="addblockintab(<?=$iTab?>)" style="cursor: pointer;height: 25px;background: rgb(48, 48, 48);padding: 7px 10px;color: white;font-weight: bold;">Thêm Block</span>
	</div>

	<?
	$form = new form();
	$form->create_form("add", $_SERVER['REQUEST_URI'], "post", "multipart/form-data",'onsubmit="validateForm(); return false;"');
	$form->create_table();
	?>
	<?=$form->text_note('Những ô có dấu sao (<font class="form_asterisk">*</font>) là bắt buộc phải nhập.')?>
	<?=$form->errorMsg($fs_errorMsg)?>
	<?=$form->select("Chọn Block", "cou_tab_cont_block_id", "cou_tab_cont_block_id", $arrayBlock, 0 ,"Chọn Block để thêm nội dung",1,"498",1,0,"","")?>
	<?=$form->select("Chọn dạng nội dung", "cou_tab_cont_text_type", "cou_tab_cont_text_type", $arrayTypeContent, -1 ,"Chọn dạng nội dung",1,"498",1,0,"","")?>
	<?=$form->text("Tiêu đề", "cou_tab_cont_title", "cou_tab_cont_title", "", "Tiêu đề", 0, 489, 20, 255, "", "", "")?>
	<?//=$form->textarea("Nội dung", "cou_tab_cont_text", "cou_tab_cont_text", "", "Nội dung", 0, 500, 20, 255, "", "", "style='resize:none;'")?>

	<tr>
		<td class="form_name">Nội dung bài viết :</td>
		<td class="form_text">
			<textarea class="cou_tab_cont_text" id="cou_tab_cont_text" name="cou_tab_cont_text" style="width:500px;height: 50px;"></textarea>
			<script src="/../../js/tinymce/tinymce.min.js" type="text/javascript" charset="utf-8"></script>
			<script type="text/javascript">
		   	tinymce.init({
				selector: "textarea",   
				plugins: [
					"advlist autolink lists link image charmap print preview hr anchor pagebreak",
					"searchreplace wordcount visualblocks visualchars code fullscreen",
					"insertdatetime media nonbreaking save table contextmenu directionality",
					"emoticons template paste textcolor jbimages"
		      	],
		      	toolbar1: "cut copy paste pastetext pasteword | insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | tablecontrols | bullist numlist outdent indent | link image ",
		      	toolbar2: "print preview media | forecolor backcolor emoticons jbimages |styleselect formatselect fontselect fontsizeselect",
		      	image_advtab: true,
		      	relative_urls : false,
		      	templates: [
		         	{title: 'Test template 1', content: 'Test 1'},
		         	{title: 'Test template 2', content: 'Test 2'}
		      	] 
		   	});
		   	</script>  
		</td>
	</tr>

	<?=$form->select("Chọn Kiểu Media", "cou_tab_cont_media_type", "cou_tab_cont_media_type", $arrayMedia, 0 ,"Chọn Kiểu Media cho nội dung",1,"500",1,0,"","")?>
	<?=$form->getFile("Upload Media", "cou_tab_cont_media", "cou_tab_cont_media", "Upload Media", 1, 30, "style='border:none;'", "")?>
   	<?=$form->text("Từ vựng", "cou_tab_cont_main_voca", "cou_tab_cont_main_voca", "", "Từ vựng", 0, 489, 20, 255, "", "", "Nhập từ vựng nếu chọn phần từ vựng")?>
   	<?=$form->text("Phiên âm và dịch", "cou_tab_cont_phonetic_voca", "cou_tab_cont_phonetic_voca", "", "Phiên âm", 0, 489, 20, 255, "", "", "Nhập phiên âm nếu chọn phần từ vựng")?>
   	<?=$form->text("Ví dụ", "cou_tab_cont_exam_voca", "cou_tab_cont_exam_voca", "", "Ví dụ", 0, 489, 20, 255, "", "", "Nhập ví dụ nếu chọn phần từ vựng")?>
   	<?=$form->getFile("Upload Ảnh Từ Vựng", "cou_tab_cont_img_voca", "cou_tab_cont_img_voca", "Upload Media", 1, 30, "style='border:none;'", "Upload ảnh nếu chọn nhập phần từ vựng")?>
   	<?=$form->getFile("Upload Audio Từ Vựng", "cou_tab_cont_audio_voca", "cou_tab_cont_audio_voca", "Upload Media", 1, 30, "style='border:none;'", "Upload audio nếu chọn nhập phần từ vựng")?>
   	<?=$form->text("Thứ tự", "cou_tab_cont_order", "cou_tab_cont_order", "", "Thứ tự", 0, 40, "", 255, "", "", "")?>
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
	<div style="width:100%;">
	<table cellpadding="5" cellspacing="0" width="100%" style="border-collapse:collapse;" bordercolor="#CCCCCC" border="1">
		<tr style="background: #303030;color:white;">
			<th width="10">ID</th>
			<th width="200">Tiêu đề</th>
			<th width="50">Sửa</th>
			<th width="20" align="center">Xóa</th>
		</tr>
		<?
		$sql = '';
		$db_picture = new db_query("SELECT * FROM courses_multi_tabs_block WHERE  com_block_tab_id=" . $iTab . " AND com_block_data_type ='content_data'");
		?>

		<?
		$i=0;
		while($row = mysql_fetch_assoc($db_picture->result)){ $i++;
		?>
			<tr style="background:#FDD5D5;">
				<td align="center"><?=$i?></td>
	            <td colspan="2" width="200">
	            	<input class="update_blockname_<?=$row["com_block_id"]?>" type="text" class="update_blockname" value="<?=$row["com_block_data_name"]?>">
		            <span onclick="update_blockname(<?=$row["com_block_id"]?>)" style="cursor:pointer;text-decoration: none;padding: 6px 10px;background: #0054C2;color: white;">Save</span>
	            </td>
	            <td width="50" align="center"><img src="<?=$fs_imagepath?>delete.gif" alt="DELETE" border="0" onClick="if (confirm('Are you sure to delete?')){ window.location.href='course_unit_data_block_delete.php?record_id=<?=$row["com_block_id"]?>&returnurl=<?=base64_encode(getURL())?>'}" style="cursor:pointer"></td>
			</tr>
			<? 
			$db_content = new db_query("SELECT * FROM courses_multi_tabs_content WHERE cou_tab_cont_tabs_id =".$iTab." AND cou_tab_cont_block_id=".$row["com_block_id"]." ORDER BY cou_tab_cont_order");
			$countarrContent = $db_content->resultArray(); 
			$j = 0;
			if(count($countarrContent) > 0){ 
				foreach($countarrContent as $key=>$value){ $j++;
			?>
			<tr style="background:rgb(179, 218, 200);border-bottom: solid 1px white;">
				<td align="center"><?=$j?></td>
	            <td width="200"><?=$value["cou_tab_cont_title"]?></td>
	            <td align="center"><a class="text" href="course_unit_tab_data_edit.php?record_id=<?=$value["cou_tab_cont_id"]?>&returnurl=<?=base64_encode(getURL())?>&iTab=<?=$iTab?>&iUnit=<?=$iUnit?>"><img src="<?=$fs_imagepath?>edit.png" alt="EDIT" border="0"/></a></td>
				<td width="50" align="center"><img src="<?=$fs_imagepath?>delete.gif" alt="DELETE" border="0" onClick="if (confirm('Are you sure to delete?')){ window.location.href='course_unit_data_content_delete.php?record_id=<?=$value["cou_tab_cont_id"]?>&returnurl=<?=base64_encode(getURL())?>'}" style="cursor:pointer"></td>
			</tr>
			<? } } ?>
		<? } ?>
	</table>
	</div>
   <?=template_bottom() ?>
   <? /*------------------------------------------------------------------------------------------------*/ ?>
   </body>
</html>

<script type="text/javascript">
function addblockintab(tab_id){
	var blockname = $(".addblock_"+tab_id).val();
	$.ajax({
		type:'POST',
		dataType:'text',
		data:{
			tab_id:tab_id,
			tab_type:"addblockintab",
			blockname:blockname
      	},
		url:'ajax.php',
		success:function(data){
			if($.trim(data) == 1){
				alert('Add Block thành công');	
				window.location.reload();
			}else{
				alert('Xảy ra lỗi trong quá trình xử lý');
			}
      	}
   	});
}
function update_blockname(cou_block_id){
   	var blockname = $('.update_blockname_'+cou_block_id).val();
	$.ajax({
		type:'POST',
		dataType:'text',
		data:{
			cou_block_id:cou_block_id,
			blockname:blockname,
			tab_type:"update_blockname"
      	},
		url:'ajax.php',
		success:function(data){
			if($.trim(data) == 1){
				alert('Update Tên Block thành công');	
				window.location.reload();
			}else{
				alert('Xảy ra lỗi trong quá trình xử lý');
			}
      	}
   	});
}
</script>

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