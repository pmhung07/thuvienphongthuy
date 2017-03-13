<?
require_once("inc_security.php");
   $startdate		= getValue("startdate", "str", "GET", "dd/mm/yyyy");
   $enddate			= getValue("enddate", "str", "GET", "dd/mm/yyyy");
   //gọi class DataGird
   $list = new fsDataGird($id_field,$name_field,translate_text("Member listing"));
   $sta_category_id	= array();
   $class_menu			= new menu();
   $listAll			= $class_menu->getAllChild("categories_multi", "cat_id", "cat_parent_id", 0, "cat_type='news' AND cat_id IN (" . $fs_category . ") AND lang_id = " . $lang_id, "cat_id,cat_name,cat_type", "cat_order ASC,cat_name ASC", "cat_has_child", 0);
   unset($class_menu);
   if($listAll != '') foreach($listAll as $key=>$row) $new_category_id[$row["cat_id"]] = $row["cat_name"];
	/*
	1: Ten truong trong bang
	2: Tieu de header
	3: kieu du lieu ( vnd : kiểu tiền VNĐ, usd : kiểu USD, date : kiểu ngày tháng, picture : kiểu hình ảnh,
							array : kiểu combobox có thể edit, arraytext : kiểu combobox ko edit,
							copy : kieu copy, checkbox : kieu check box, edit : kiểu edit, delete : kiểu delete, string : kiểu text có thể edit,
							number : kiểu số, text : kiểu text không edit
	4: co sap xep hay khong, co thi de la 1, khong thi de la 0
	5: co tim kiem hay khong, co thi de la 1, khong thi de la 0
	*/
   $list->add("sig_id","ID","numbernotedit",0,1);
   $list->add($name_field,"Tên","string",0,0);
   $list->add("sig_shop_name","Cửa hàng","text",0,1);
   $list->add("sig_phone", "Điện thoại", 'text', 0, 1);
   $list->add("sig_cmnd", "CMND", 'int', 0, 1);
   $list->add("sig_email","Email","date",0,0);
   $list->add("sig_address","Địa chỉ","date",0,0);
   $list->add("sig_mes","Tin nhắn","date",0,0);
   $list->add("sig_time","Ngày tạo","date",0,0);
   $list->add("sig_active","Active", "checkbox", 0, 1);
	//$list->add("","Delete","delete");
	$list->ajaxedit($fs_table);
   $sql = '';
	$total		= new db_count("SELECT count(*) AS count
      								 FROM " . $fs_table . "
      								 WHERE 1 " . $list->sqlSearch().$sql);

	$db_listing	= new db_query("SELECT *
      								 FROM " . $fs_table . "
      								 WHERE 1 " . $list->sqlSearch().$sql."
      								 ORDER BY " . $list->sqlSort() . $id_field ." DESC
      								 " . $list->limit($total->total));
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
    <?php //echo $list->showTable($db_listing,$total)?>

  <?=$list->showHeader($total_row);?>
  <?
   $i = 0;
   //thực hiện lênh select csdl
   $check_content = '';
   while($row = mysqli_fetch_assoc($db_listing->result)){
   $i++;
   ?>
   <form action="quickedit.php?returnurl=<?=base64_encode(getURL())?>" method="post" name="form_listing" id="form_listing" enctype="multipart/form-data">
   <input type="hidden" name="iQuick" value="update" />
   <?=$list->start_tr($i, $row[$id_field])?>
   <td>
        <p><?=$row['use_id']?></p>
        <input type="hidden" name="record_id[]" id="record_<?=$row["use_id"]?>_<?=$i?>" value="<?=$row["use_id"]?>"/>
   </td>
   <td>
        <p><?=$row['sig_name']?></p>
   </td>
   <td>
        <p><?=$row['sig_shop_name']?></p>
   </td>
   <td>
        <p><?=$row['sig_phone']?></p>
   </td>
   <td>
        <p><?=$row['sig_cmnd']?></p>
   </td>
   <td>
        <p><?=$row['sig_email']?></p>
   </td>
   <td>
        <p><?=$row['sig_address']?></p>
   </td>
   <td>
        <p><?=$row['sig_mes']?></p>
   </td>
   <td>
        <p><?=date("h:i d/m/y",$row['sig_time'])?></p>
   </td>
   <td align="center" width="16">
          <a onClick="loadactive(this); return false;" href="active.php?record_id=<?=$row['sig_id']?>&value=<?=abs($row["sig_active"]-1)?>&url=<?=base64_encode(getURL())?>">
          <img border="0" src="<?=$fs_imagepath?>check_<?=$row["sig_active"]?>.gif" title="Active!"/>
        </a>
   </td>
   <?
     }
   ?>
    </form>
  <?=$list->showFooter($total_row);?>
</div>
<? /*---------Body------------*/ ?>
</body>
</html>