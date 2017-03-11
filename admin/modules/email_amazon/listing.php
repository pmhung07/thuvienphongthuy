<?
	require_once("inc_security.php");
    
	//khoi tao object Datagird
	$list = new fsDataGird($id_field, $name_field, translate_text("Listing"));
	
	$list->add("ema_title", "Tiêu đề email", "string", 1, 1);
	$list->add("ema_send","Email gửi","string", 1, 1);
    $list->add("ema_time","Ngày gửi","int",0,0);
    $list->add("ema_view","Lượt click","int",0,0);
    $list->add("ema_active","Số email gửi","int",0,0);
	$list->ajaxedit($fs_table);


	$total						= new db_count("SELECT COUNT(*) AS count
											    FROM "	.	$fs_table	.	"
												WHERE 1 "	.	$list->sqlSearch() );

	$db_listing					= new db_query("SELECT  *
									    		FROM  "	.	$fs_table	.	"
										 		WHERE 1 "	.	$list->sqlSearch() . "
												ORDER BY " . $list->sqlSort() . " ema_id DESC
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
            <p><?=$row['ema_title']?></p>
        </td>
        <td>
            <p><?=$row['ema_send']?></p>
        </td>
        <td>
            <p><?=date("h:i a - d/m/Y",$row['ema_time'])?></p>
        </td>
        <td>
            <p><?=$row['ema_view']?></p>
        </td>
        <td>
            <p><?=$row['ema_active'] == 0 ? 'Thất bại' : $row['ema_active']?></p>
        </td>
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
