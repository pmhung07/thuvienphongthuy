<?php
require_once("inc_security.php");

    $startdate		    = getValue("startdate", "str", "GET", "dd/mm/yyyy");
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
	$list->add("use_id","ID","numbernotedit",0,1);
	$list->add($name_field,"Họ và tên","string",0,0);
    $list->add("use_email","Email","text",0,1);
    $list->add("use_phone", "Điện thoại", 'text', 0, 1);
    $list->add("use_date","Ngày tạo","date",0,0);
    $list->add("use_active","Active", "checkbox", 0, 1);
    $list->add("use_teacher","Giáo viên", "checkbox", 1, 1);
	$list->add("","Edit","edit");
    //$list->addSearch("Từ", "startdate", "date", "", "");
	//$list->addSearch("Đến", "enddate", "date", "", "");
	//$list->add("","Delete","delete");
	$list->ajaxedit($fs_table);
    $sql = '';
	if($startdate != "dd/mm/yyyy"){
		$intdate		=	convertDateTime($startdate, "0:0:0");
		$sql			.= " AND use_date >= " . $intdate;
	}
	if($enddate != "dd/mm/yyyy"){
		$intdate		=	convertDateTime($enddate, "23:59:59");
		$sql			.= " AND use_date <= " . $intdate;
	}
	$total		= new db_count("SELECT count(*) AS count 
      								 FROM " . $fs_table . "
      								 WHERE 1 " . $list->sqlSearch().$sql);	
   
	$db_listing	= new db_query("SELECT * 
      								 FROM " . $fs_table . "
      								 WHERE 1 " . $list->sqlSearch().$sql."
      								 ORDER BY " . $list->sqlSort() . $id_field ." DESC
      								 " . $list->limit($total->total));
    $total_row = mysql_num_rows($db_listing->result);
   
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<?=$load_header?>
<?=$list->headerScript()?>
</head>
<body topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0">
<?php /*---------Body------------*/ ?>
<div id="listing" style="font-size: 11px!important;">
    <?php //echo $list->showTable($db_listing,$total)?>
    <?=$list->showHeader($total_row);?>
    <?php
    $i = 0;
    $check_content = '';
    while($row = mysql_fetch_assoc($db_listing->result)){
    $i++;
    ?> 
    <form action="quickedit.php?returnurl=<?=base64_encode(getURL())?>" method="post" name="form_listing" id="form_listing" enctype="multipart/form-data">
    <input type="hidden" name="iQuick" value="update" />
    <?=$list->start_tr($i, $row[$id_field])?>
    <td>
        <p style="text-align:center;"><?=$row['use_id']?></p>
        <input type="hidden" name="record_id[]" id="record_<?=$row["use_id"]?>_<?=$i?>" value="<?=$row["use_id"]?>"/>
    </td>
    <td>
        <p style="font-size: 11px;"><?=$row['use_name']?> </p>
    </td>
    <td>
        <p style="font-size: 11px;color:#B50000;"><?=$row['use_email']?> </p>
    </td>
    <td>
        <p style="font-size: 11px;color:#B50000;"><?=$row['use_phone']?> </p>
    </td>

    <td>
        <p><?=date("h:i d/m/y",$row['use_date'])?></p>
    </td>
     <td align="center" width="16">
          <a onClick="update_check(this); return false;" href="active.php?record_id=<?=$row["use_id"]?>&value=<?=abs($row["use_active"]-1)?>&url=<?=base64_encode(getURL())?>">
          <img border="0" src="<?=$fs_imagepath?>check_<?=$row["use_active"];?>.gif" title="Active!">
        </a>
    </td>
    <td align="center" width="16">
          <a onClick="update_check(this); return false;" href="active_teacher.php?record_id=<?=$row["use_id"]?>&value=<?=abs($row["use_teacher"]-1)?>&url=<?=base64_encode(getURL())?>">
          <img border="0" src="<?=$fs_imagepath?>check_<?=$row["use_teacher"];?>.gif" title="Active!">
        </a>
    </td>
    <td>
        <a class="text" href="edit.php?record_id=<?=$row['use_id']?>"><img src="<?=$fs_imagepath?>edit.png" alt="EDIT" border="0"></a>
    </td>
   
    <?php } ?>
    </form>
    <?=$list->showFooter($total_row);?>
</div>
<? /*---------Body------------*/ ?>
</body>
</html>