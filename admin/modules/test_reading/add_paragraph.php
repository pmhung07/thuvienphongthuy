<?
include("inc_security.php");
checkAddEdit("add");
//khai báo biến
$fs_redirect 	= base64_decode(getValue("url","str","GET",base64_encode("listing.php")));
$record_id 		= getValue("record_id");
$fs_errorMsg	= '';
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

//câu lệnh select dữ liêu										  
$db_listing = new db_query("SELECT * FROM  test_content WHERE tec_typ_id = ".$record_id." ORDER BY tec_order");
$total_row = mysql_num_rows($db_listing->result);

$myform = new generate_form();
$myform->add("tec_name", "tec_name", 0, 0, "", 1, "Bạn chưa nhập tiêu đề đoạn văn", 0, "");
$myform->add("tec_content", "tec_content", 0, 0, "", 1, "Bạn chưa nhập nội dung cho đoạn văn", 0, "");
$myform->add("tec_order", "tec_order", 1, 0, 0, 0, "", 0, "");
$myform->add("tec_typ_id", "record_id", 1, 1, 0, 0, "", 0, "");
//Add table insert data
$myform->addTable("test_content");

//Get action variable for add new data
$action	= getValue("action", "str", "POST", "");
//Check $action for insert new data
if($action == "execute"){
   if($total_row < 5){
	if($fs_errorMsg == ""){
		//Insert to database
      $myform->removeHTML(0);
		$db_insert		= new db_execute($myform->generate_insert_SQL());
		redirect($_SERVER['REQUEST_URI']);
      }	
	}else{
      echo("<script>alert('Chỉ được thêm 5 đoạn văn trong phần Reading')</script>");
      redirect($_SERVER['REQUEST_URI']);
   }
}

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
$myform->evaluate();
$fs_errorMsg .= $myform->strErrorField;
?>
</head>
<body>
<? /*------------------------------------------------------------------------------------------------*/ ?>
	<?
	$form = new form();
	$form->create_form("add", $_SERVER['REQUEST_URI'], "post", "multipart/form-data",'onsubmit="validateForm(); return false;"');
	$form->create_table();
	?>
	<?=$form->text_note('Những ô có dấu sao (<font class="form_asterisk">*</font>) là bắt buộc phải nhập.')?>
	<?=$form->errorMsg($fs_errorMsg)?>
   <?=$form->text("Tiêu đề", "tec_name", "tec_name", $tec_name, "Tiêu đề đoạn văn", 1, 272, "", 255, "", "", "")?>
   <tr>
      <td></td>
      <td><?=$form->wysiwyg("<font class='form_asterisk'>*</font> Nội dung đoạn văn", "tec_content", $tec_content, "../../resource/wysiwyg_editor/", 800, 250)?></td>
   </tr>
	<?=$form->text("Thứ tự", "tec_order", "tec_order", $tec_order, "Thứ tự", 0, 40, "", 255, "", "", "")?>
	<?=$form->button("submit" . $form->ec . "reset", "submit" . $form->ec . "reset", "submit" . $form->ec . "reset", "Cập nhật" . $form->ec . "Đóng cửa sổ", "Cập nhật" . $form->ec . "Đóng cửa sổ", 'style="background:url(' . $fs_imagepath . 'button_1.gif) no-repeat"' . $form->ec . 'style="background:url(' . $fs_imagepath . 'button_2.gif)" onclick="window.parent.tb_remove()"', "");?>
	<?=$form->hidden("action", "action", "execute", "");?>
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
			<th width="200px">Tiêu đề</th>
         <th width="620">Nội dung</th>
			<th width="50">Thứ tự</th>
         <th width="30" align="center">Sửa</th>
			<th width="30" align="center">Xóa</th>
		</tr>
		<?
		$sql = '';
		$db_picture = new db_query("SELECT * FROM  test_content
											 WHERE  tec_typ_id = " . $record_id . $sql);
		?>
		<?
		$i=0;
		while($row = mysql_fetch_assoc($db_picture->result)){
			$i++;
		?>
			<tr <?=$fs_change_bg?>>
				<td align="center"><?=$i?></td>
				<td align="center" width="100">
               <input style="width: 195px;" type="text" readonly="" value="<?=$row["tec_name"]?>" />
            </td>
            <td align="center" width="610px">
               <textarea style="width: 610px;height: 40px;"> <?=removeHTML($row["tec_content"])?></textarea>
            </td>
            <td width="50" align="center"><?=$row["tec_order"]?></td>
				<td align="center"><a href="edit_paragraph.php?record_id=<?=$row["tec_id"]?>&tec_typ_id=<?=$record_id?>&url=<?=base64_encode($_SERVER['REQUEST_URI'])?>" href="#" class="edit"><img border="0" src="<?=$fs_imagepath?>edit.gif"/></a></td>
  		      <td align="center"><img src="<?=$fs_imagepath?>delete.gif" alt="DELETE" border="0" onClick="if (confirm('Are you sure to delete?')){ window.location.href='del_paragraph.php?record_id=<?=$row["tec_id"]?>&returnurl=<?=base64_encode(getURL())?>'}" style="cursor:pointer"></td>   
          </tr>
		<?
		}
		?>
	</table>
	</div>
<? /*------------------------------------------------------------------------------------------------*/ ?>

</body>
</html>