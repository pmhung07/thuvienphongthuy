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
$arr_part_speak = array(-1 => "Chọn phần thi" , 1 => "Part 1" , 2 => "Part 2" , 3 => "Part 3");
$myform = new generate_form();
$myform->add("iecon_part_speak", "iecon_part_speak", 1, 0, 0, 1, "Bạn chưa chọn phần thi", 0, "");
$myform->add("iecon_name", "iecon_name", 0, 0, "", 1, "Bạn chưa nhập tiêu đề audio", 0, "");
$myform->add("iecon_content", "iecon_content", 0, 0, "", 1, "Bạn chưa nhập nội dung", 0, "");
$myform->add("iecon_order", "iecon_order", 1, 0, 0, 0, "", 0, "");
$myform->add("iecon_iety_id", "record_id", 1, 1, 0, 0, "", 0, "");
//Add table insert data
$myform->addTable("ielt_content");

//Get action variable for add new data
$action				= getValue("action", "str", "POST", "");
//Check $action for insert new data
if($action == "execute"){
   $upload		= new upload("iecon_audio", $data_path, $fs_extension, $fs_filesize);
   $filename	= $upload->file_name;
   if($filename != ""){
   	$myform->add("iecon_audio","filename",0,1,0,0);
   }
	//Check form data
	$fs_errorMsg .= $myform->checkdata();
	$fs_errorMsg .= $upload->warning_error;
   $fs_errorMsg .= $upload->show_warning_error();
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
   <?=$form->select("Chọn phần thi","iecon_part_speak","iecon_part_speak",$arr_part_speak,-1,"Chọc phần thi",1,"","",0,"","",0);?>
   <?=$form->text("Tiêu đề", "iecon_name", "iecon_name", $iecon_name, "Tiêu đề audio", 1, 272, "", 255, "", "", "")?>
   <tr>
      <td></td>
      <td><?=$form->wysiwyg("<font class='form_asterisk'>*</font> Nội dung", "iecon_content", $iecon_content, "../../resource/wysiwyg_editor/", 800, 250)?></td>
   </tr>
   <?=$form->getFile("Tải Audio", "iecon_audio", "iecon_audio", "Tải ảnh", 0, 30, "", "")?>
	<?=$form->text("Thứ tự", "iecon_order", "iecon_order", $iecon_order, "Thứ tự", 0, 40, "", 255, "", "", "")?>
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
         <th width="110">Paragraph</th>
         <th width="110">Image</th>
			<th width="50">Thứ tự</th>
         <th width="50">Part</th>
         <th width="30" align="center">Sửa</th>
			<th width="30" align="center">Xóa</th>
		</tr>
		<?
		$sql = '';
		//if($temp_key != '') $sql .= " AND ppic_temp_key = '" . $temp_key . "'";
		$db_picture = new db_query("SELECT * FROM  ielt_content
											 WHERE  iecon_iety_id = " . $record_id . $sql ." ORDER BY iecon_part_speak");
		?>
		<?
		$i=0;
		while($row = mysqli_fetch_assoc($db_picture->result)){
			$i++;
		?>
			<tr <?=$fs_change_bg?>>
				<td align="center"><?=$i?></td>
				<td align="center" width="100">
               <input style="width: 480px;background: #eee;" type="text" readonly="" value="<?=$row["iecon_name"]?>" />
            </td>
            <td align="center" width="200">
               <?if($row["iecon_content"] != ""){?>
                  <p style="font-weight: bold;color: blue;">[ Click edit để xem ]</p>
               <?}else{ echo "<p style='color:red;font-weight:bold'>[ Not Content ]</p>"; }?>
            </td>
            <td align="center" width="110">
               <?
               if($row["iecon_audio"] != ""){
                  $url = $data_path.$row["iecon_audio"];
                  checkmedia_les(2,$url);
               }else{echo "Not Audio";}
               ?>
            </td>
            <td width="50" align="center"><?=$row["iecon_order"]?></td>
            <td width="50" align="center">
               <?
               if($row["iecon_part_speak"] == 1){
                  echo "Part 1";
               }elseif($row["iecon_part_speak"] == 2){
                  echo "Part 2";
               }elseif($row["iecon_part_speak"] == 3){
                  echo "Part 3";
               }
               ?>
            </td>
				<td align="center"><a href="edit_paragraph.php?record_id=<?=$row["iecon_id"]?>&tec_typ_id=<?=$record_id?>&url=<?=base64_encode($_SERVER['REQUEST_URI'])?>" href="#" class="edit"><img border="0" src="<?=$fs_imagepath?>edit.gif"/></a></td>
  		      <td align="center"><img src="<?=$fs_imagepath?>delete.gif" alt="DELETE" border="0" onClick="if (confirm('Are you sure to delete?')){ window.location.href='del_paragraph.php?record_id=<?=$row["iecon_id"]?>&returnurl=<?=base64_encode(getURL())?>'}" style="cursor:pointer"></td>
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