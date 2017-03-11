<?
	require_once("inc_security.php");
	          
    $db_shop = new db_query('SELECT * FROM shop WHERE 1');
    $listShop = array();
    $listShop[0] = '-- Chọn cửa hàng --';
    while($shop = mysql_fetch_assoc($db_shop->result)) {
        $listShop[$shop['sho_id']] = $shop['sho_name'];
    }
    unset($db_shop);
    
    $listRole = array();
    $listRole[0] = '-- Quyền quản trị --';
    $listRole[1] = 'Quản lý (Admin)';
    $listRole[2] = 'Nhân viên';
    
	//khoi tao object Datagird
	$list = new fsDataGird($id_field, $name_field, translate_text("Listing"));
	
	$list->add("use_name", "Username", "string", 1, 1);
	$list->add("use_email","Email","string", 1, 1);
	$list->add("use_fullname","Tên đầy đủ","string", 1, 1);
	$list->add("use_phone","Điện thoại","string",1,1);
	$list->add("use_shop_id","Cửa hàng","string",0,0);
	$list->add("use_role","Quyền quản trị","string",0,0);
    $list->add("use_active","Active","int", 0, 0);
	$list->add("",translate_text("Edit"),"edit");
	$list->add("",translate_text("Del"),"delete");
	$list->ajaxedit($fs_table);


	$total						= new db_count("SELECT COUNT(*) AS count
											    FROM "	.	$fs_table	.	"
												WHERE 1 "	.	$list->sqlSearch() );

	$db_listing					= new db_query("SELECT  *
									    		FROM  "	.	$fs_table	.	"
										 		WHERE 1 "	.	$list->sqlSearch() . "
												ORDER BY " . $list->sqlSort() . " use_id DESC
					 							" . $list->limit($total->total));	
	$total_row					=	mysql_num_rows($db_listing->result);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?=$load_header?>
<?=$list->headerScript()?>
<script language="javascript" src="../../resource/js/swfObject.js"></script>
</head>
<body topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0">
<? /*---------Body------------*/ ?>
<div id="listing">
  <?=$list->showHeader($total_row)?>
	<?
	$i=0; 
	while($row  = mysql_fetch_assoc($db_listing->result)){
		$i++;
		?>
  		<?=$list->start_tr($i, $row[$id_field])?>
        <td>
            <input type="text" style="width:120px;" value="<?=$row['use_name']?>" name="<?="use_name".$row[$id_field]?>" id="use_name_<?=$row[$id_field]?>" title="<?=$row['use_name']?>" class="form_control" onkeyup="check_edit('record_<?=$i?>')" />
        </td>
		<td>
            <input type="text" style="width:160px;" value="<?=$row['use_email']?>" name="<?="use_email".$row[$id_field]?>" id="use_mail_<?=$row[$id_field]?>" title="<?=$row['use_email']?>" class="form_control" onkeyup="check_edit('record_<?=$i?>')" />
        </td>
		<td>
            <input type="text" style="width:150px;" value="<?=$row['use_fullname']?>" name="<?="use_fullname".$row[$id_field]?>" id="use_fullname_<?=$row[$id_field]?>" title="<?=$row['use_fullname']?>" class="form_control" onkeyup="check_edit('record_<?=$i?>')" />
        </td>
		<td>
            <input type="text" style="width:120px;" value="<?=$row['use_phone']?>" name="<?="use_phone".$row[$id_field]?>" id="use_phone_<?=$row[$id_field]?>" title="<?=$row['use_phone']?>" class="form_control" onkeyup="check_edit('record_<?=$i?>')" />
        </td>
		<td>
            <select id="use_shop_id_<?=$row[$id_field]?>"  name="use_shop_id<?=$row[$id_field]?>" onchange="check_edit('record_<?=$i?>')" class="form_control">
				<?
				foreach($listShop as $key => $value){
					?>
					<option value="<?=$key?>"<?=($key == $row['use_shop_id'] ? ' selected="selected"' : '')?>><?=$value?></option>
					<?
				}
				?>
			</select>
        </td>
        <td>
            <select id="use_role_<?=$row[$id_field]?>"  name="use_role<?=$row[$id_field]?>" onchange="check_edit('record_<?=$i?>')" class="form_control">
				<?
				foreach($listRole as $key => $value){
					?>
					<option value="<?=$key?>"<?=($key == $row['use_role'] ? ' selected="selected"' : '')?>><?=$value?></option>
					<?
				}
				?>
			</select>
        </td>
        <?=$list->showCheckbox("use_active", $row["use_active"], $row[$id_field])?>
		<?=$list->showEdit($row[$id_field]); ?>
		<?=$list->showDelete($row[$id_field]); ?>
  		<?=$list->end_tr();?>
	<?
	}
	?>
  <?=$list->showFooter($total_row); ?>
</div>
<script>
	function errorimage(obj, link){
		//$('<p>Ảnh lỗi: <a href="' + link + '" target="_blank">Xem link lấy tin</a>').insertBefore($(obj).parent());
		$(obj).parent().attr('href', '/web/index.php?url=' + link).html('Xem link lấy tin');
	}
</script>
<? /*---------Body------------*/ ?>
</body>
</html>
