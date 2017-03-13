<?
require_once("inc_security.php");
$list = new fsDataGird($id_field,$name_field,translate_text("Level Listing"));
/*
1: Ten truong trong bang
2: Tieu de header
3: kieu du lieu
4: co sap xep hay khong, co thi de la 1, khong thi de la 0
5: co tim kiem hay khong, co thi de la 1, khong thi de la 0
*/
$list->add($name_field,"Mô tả","string", 1, 1);
$list->add("listexp_code","CODE","string", 1, 1);
$list->add("listexp_exp","EXP","int", 1, 1);
$list->add("",translate_text("Edit"),"edit");
$list->add("",translate_text("Delete"),"delete");

//$list->quickEdit = false;
$list->ajaxedit($fs_table);

//tính tổng các rows trong csdl để phục vụ phân trang
$total			= new db_count("SELECT 	count(*) AS count
										 FROM 	".$fs_table);

//câu lệnh select dữ liêu
$db_listing 	= new db_query("SELECT * FROM " . $fs_table .
								 			" WHERE 1". $list->sqlSearch()
										   . " ORDER BY " . $list->sqlSort() . "listexp_id DESC "
                                 .	$list->limit($total->total));

$total_row = mysqli_num_rows($db_listing->result);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<?=$load_header?>
<?=$list->headerScript()?>
</head>
<body topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0">
<? /*---------Body------------*/ ?>
<div id="listing">
   <?=$list->showHeader($total_row)?>
   <?
   $i = 0;
   //thực hiện lênh select csdl
   while($row	=	mysqli_fetch_assoc($db_listing->result)){
   	$i++;
  	?>
   	<?=$list->start_tr($i, $row[$id_field])?>
   	<td class="bold" align="left">
   	  <?=$row[$name_field]?>
   	</td>
    <td class="bold" align="center">
      <?=$row['listexp_code']?>
    </td>
    <td class="bold" align="center">
      <?=$row['listexp_exp']?>
    </td>
   	<?=$list->showEdit($row['listexp_id'])?>
   	<?=$list->showDelete($row['listexp_id'])?>
   	<?=$list->end_tr()?>
  	<?
   }
   ?>
   <?=$list->showFooter($total_row)?>
</div>
<? /*---------Body------------*/ ?>
</body>
</html>