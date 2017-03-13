<?
include("inc_security.php");
checkAddEdit("add");
//khai báo biến
$fs_redirect 	= base64_decode(getValue("url","str","GET",base64_encode("listing.php")));
$record_id 		= getValue("record_id");
$fs_errorMsg	= '';

include ("inc_security.php");
checkAddEdit("add");
$fs_action			= getURL();
$iPara   = getValue("iPara","int","GET",0);
if($iPara > 0){
   $current_content = $iPara;
}else{
   $current_content = "";
}
//=====Get media=====/
$arr_list_para[-1] = "- Chọn Audio tương ứng cho câu hỏi -";
$db_para_select = new db_query("SELECT * FROM ielt_content WHERE iecon_iety_id = " . $record_id);
while($row_para = mysqli_fetch_assoc($db_para_select->result)){
   $arr_list_para[$row_para['iecon_id']] = $row_para['iecon_name'];
}unset($db_para_select);
//$fs_fieldupload = "images_story";
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
$myform->add("ieque_content", "ieque_content", 0, 0, "", 0, "", 0, "");
$myform->add("ieque_order", "ieque_order", 1, 0, 0, 0, "", 0, "");
$myform->add("ieque_iecon_id", "ieque_iecon_id", 1, 0, 0, 1, "Bạn chưa chon content", 0, "");
$myform->add("ieque_iety_id", "record_id", 1, 1, 0, 1, "", 0, "");
//Add table insert data
$myform->addTable("ielt_questions");

//Get action variable for add new data
$action				= getValue("action", "str", "POST", "");
//Check $action for insert new data
if($action == "execute"){
   //up audio
   $upload_img	= new upload("ieque_image", $image_path, $fs_extension_img, $fs_filesize);
   $filename_img	= $upload_img->file_name;
   if($filename_img != ""){
   	$myform->add("ieque_image","filename_img",0,1,0,0);
   	foreach($arr_resize as $type => $arr){
   			resize_image($image_path, $filename_img, $arr["width"], $arr["height"], $arr["quality"], $type);
   	}
   }
   $fs_errorMsg .= $upload_img->show_warning_error();
	//Check form data
	$fs_errorMsg .= $myform->checkdata();
	if($fs_errorMsg == ""){
		//Insert to database
      $myform->removeHTML(0);
		$db_insert		= new db_execute($myform->generate_insert_SQL());
		redirect($_SERVER['REQUEST_URI']);

	}//End if($fs_errorMsg == "")

}//End if($action == "execute")
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
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
   <?=$form->select("Chọn nội dung", "ieque_iecon_id", "ieque_iecon_id",$arr_list_para,$current_content,"Chọn level",1,"","","","","")?>
   <tr>
      <td></td>
      <td><?=$form->wysiwyg("<font class='form_asterisk'>*</font> Nội dung", "ieque_content", $ieque_content, "../../resource/wysiwyg_editor/", 800, 250)?></td>
   </tr>
   <?=$form->getFile("Tải Ảnh", "ieque_image", "ieque_image", "Tải ảnh", 0, 30, "", "")?>
	<?=$form->text("Thứ tự", "ieque_order", "ieque_order", $ieque_order, "Thứ tự", 0, 40, "", 255, "", "", "")?>
	<?=$form->button("submit" . $form->ec . "reset", "submit" . $form->ec . "reset", "submit" . $form->ec . "reset", "Cập nhật" . $form->ec . "Đóng cửa sổ", "Cập nhật" . $form->ec . "Đóng cửa sổ", 'style="background:url(' . $fs_imagepath . 'button_1.gif) no-repeat"' . $form->ec . 'style="background:url(' . $fs_imagepath . 'button_2.gif)" onclick="window.parent.tb_remove()"', "");?>
	<?=$form->hidden("action", "action", "execute", "");?>
	<?//=$form->hidden("ppic_temp_key", "ppic_temp_key", $temp_key, "");?>
	<?
	$form->close_table();
	$form->close_form();
	unset($form);
	?>

<? /*------------------------------------------------------------------------------------------------*/ ?>
	<div style="padding-left:3px; padding-right:3px;padding-top: 30px;">
	<table cellpadding="5" cellspacing="0" width="100%" style="border-collapse:collapse;" bordercolor="#CCCCCC" border="1">
		<tr>
			<th width="10">ID</th>
			<th width="200">Tiêu đề</th>
         <th width="110">Audio</th>
			<th width="50">Thứ tự</th>
         <th width="30" align="center">Sửa</th>
			<th width="30" align="center">Xóa</th>
		</tr>
		<?
		$sql = '';
		//if($temp_key != '') $sql .= " AND ppic_temp_key = '" . $temp_key . "'";
		$db_picture = new db_query("SELECT * FROM  ielt_questions
											 WHERE  ieque_iecon_id = " . $iPara  ." ORDER BY ieque_order");
		?>
		<?
		$i=0;
		while($row = mysqli_fetch_assoc($db_picture->result)){
			$i++;
		?>
			<tr <?=$fs_change_bg?>>
				<td align="center"><?=$i?></td>
				<td align="center" width="700">
               <?if($row["ieque_content"] != ""){?>
                  <p style="font-weight: bold;color: blue;">[ Click edit để xem ]</p>
               <?}else{ echo "<p style='color:red;font-weight:bold'>[ Not Content ]</p>"; }?>
            </td>
            <td align="center" width="110">
               <?
               if($row["ieque_image"] != ""){
                  $url = $data_path.$row["ieque_image"];
                  checkmedia_les(1,$url);
               }else{echo "Not Image";}
               ?>
            </td>
            <td width="50" align="center"><?=$row["ieque_order"]?></td>
				<td align="center"><a href="edit_question.php?ieque_id=<?=$row["ieque_id"]?>&url=<?=base64_encode($_SERVER['REQUEST_URI'])?>" href="#" class="edit"><img border="0" src="<?=$fs_imagepath?>edit.gif"/></a></td>
  		      <td align="center"><img src="<?=$fs_imagepath?>delete.gif" alt="DELETE" border="0" onClick="if (confirm('Are you sure to delete?')){ window.location.href='del_question.php?record_id=<?=$row["ieque_id"]?>&returnurl=<?=base64_encode(getURL())?>'}" style="cursor:pointer"></td>
          </tr>
		<?
		}
		?>
	</table>
	</div>
<? /*------------------------------------------------------------------------------------------------*/ ?>
</body>
</html>
<style>
.a_detail{padding: 3px 15px;border:solid 1px;background:#EEE;text-decoration:none;color: #8C99A5;}
</style>
<script>
$('#ieque_iecon_id').change(function (){
   var iPara =	$("#ieque_iecon_id").val();
   window.location	=	"add_question.php?record_id=<?=$record_id?>&iPara=" + iPara;
});
</script>