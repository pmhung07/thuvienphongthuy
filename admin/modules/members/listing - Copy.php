<?
require_once("inc_security.php");

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
	$list->add($name_field,"Tên hiển thị","string",0,0);
	$list->add("use_login","Tên đăng nhập","text",0,1);
   $list->add("use_email","Email","text",0,1);
   $list->add("use_phone", "Điện thoại", 'text', 0, 1);
   $list->add("use_active","Active", "checkbox", 0, 1);
	$list->add("use_date","Ngày tạo","date",0,0);
	$list->add("","Edit","edit");
	//$list->add("","Delete","delete");
	
	$list->ajaxedit($fs_table);
	
	$total		= new db_count("SELECT count(*) AS count 
      								 FROM " . $fs_table . "
      								 WHERE 1 " . $list->sqlSearch());	
   
	$db_listing	= new db_query("SELECT * 
      								 FROM " . $fs_table . "
      								 WHERE 1 " . $list->sqlSearch() . "
      								 ORDER BY " . $list->sqlSort() . $id_field ." DESC
      								 " . $list->limit($total->total));
   
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
  <?=$list->showTable($db_listing,$total)?>
</div>
<? /*---------Body------------*/ ?>
</body>
</html>