<?
require_once("inc_security.php");
//check quy?n them sua xoa
checkAddEdit("add");

	//Khai bao Bien
	$fs_redirect 							= base64_decode(getValue("url","str","GET",base64_encode("listing.php")));
	$record_id 								= getValue("record_id");
    $db_lesson = new db_query("SELECT les_det_id,les_com_id,com_cou_id,com_id,com_parent_id,les_det_name,com_name
									FROM  lesson_details,courses_multi
									WHERE lesson_details.les_com_id = courses_multi.com_id
                                    AND   lesson_details.les_det_type = 3
                                    AND   courses_multi.com_parent_id =  ".$record_id );


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<?=$load_header?>
</head>
<body topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0">
<? /*------------------------------------------------------------------------------------------------*/ ?>
<?=template_top(translate_text("listing"))?>
	<?
	if(!is_array($listAll)) $listAll = array();
	?>
	<table border="1" cellpadding="3" cellspacing="0" class="table" width="100%" bordercolor="<?=$fs_border?>">
		<tr>
			<td class="bold bg" width="5"><input type="checkbox" id="check_all" onClick="check('1','<?=count($listAll)+1?>')"/></td>
			<td class="bold bg" width="2%" nowrap="nowrap" align="center"><img src="<?=$fs_imagepath?>save.png" border="0"/></td>
			<td class="bold bg" ><?=translate_text("name")?></td>
            <td class="bold bg" align="center" width="180" >chi tiết</td>
            <td class="bold bg" align="center" width="100" >Sửa chi tiết</td>
            <td class="bold bg" align="center" width="30" >Xóa</td>
		</tr>
		<form action="quickedit.php?returnurl=<?=base64_encode(getURL())?>" method="post" name="form_listing" id="form_listing" enctype="multipart/form-data">
		<input type="hidden" name="iQuick" value="update" />
		<?

		$i=0;
        $j = 0;
		while($row = mysqli_fetch_array($db_lesson->result)){ $i++;
		?>
		<tr <? if($i%2==0) echo ' bgcolor="#FAFAFA"';?>>
			<td <? if($row["admin_id"] == $admin_id) echo ' bgcolor="#FFFF66"';?>>
				<input type="checkbox" name="record_id[]" id="record_<?=$row["les_det_id"]?>_<?=$i?>" value="<?=$row["les_det_id"]?>"/>
			 </td>
			<td width="2%" nowrap="nowrap" align="center"><img src="<?=$fs_imagepath?>save.png" border="0" style="cursor:pointer" onClick="document.form_listing.submit()" alt="Save"></td>
			<td nowrap="nowrap">
				<b><a href="">Phần vocabulary của Lesson : <?php echo $row['com_name'] ?></a></b>

			</td>
            <td align="center"><a title="Xem chi tiết" class="thickbox noborder a_detail" href="listdetail.php?url=<?=base64_encode(getURL())?>&record_id=<?=$row["les_det_id"]?>&TB_iframe=true&amp;height=450&amp;width=950"">Xem chi tiết</a></td>
		    <td align="center" width="16"><a class="text" href="editvoca.php?record_id=<?=$row["les_det_id"]?>&returnurl=<?=base64_encode(getURL())?>"><img src="<?=$fs_imagepath?>edit.png" alt="EDIT" border="0"></a></td>
            <td align="center"><img src="<?=$fs_imagepath?>delete.gif" alt="DELETE" border="0" onClick="if (confirm('Are you sure to delete?')){ window.location.href='deletevoca.php?record_id=<?=$row["les_det_id"]?>&returnurl=<?=base64_encode(getURL())?>'}" style="cursor:pointer"></td>
        </tr>
		<? } unset($db_lesson) ?>
		</form>
		</table>
<?=template_bottom() ?>
<? /*------------------------------------------------------------------------------------------------*/ ?>
</body>
</html>
<? //echo'<a title="Thông tin chi tiết" class="thickbox noborder a_detail" href="confirmation.php?url='. base64_encode(getURL()) . '&record_id=' . $row["exe_id"] .'&TB_iframe=true&amp;height=450&amp;width=950" /><b>Chi tiết</b></a>';?>