<?
require_once("inc_security.php");
   error_reporting(E_ALL);
	//gọi class DataGird
	$list = new fsDataGird($id_field,$name_field,translate_text("Member listing"));
   $array_status = array( -1 => "Chưa duyệt" , 1 => "Đã duyệt" );
   $status   = getValue("user_status","int","GET",-1);
   $sql_filter = " AND use_status = ".$status;
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
   $list->addSearch(translate_text("Chọn trạng thái"),"user_status","array",$array_status,$status);
   $list->add($id_field,"ID","numbernotedit",0,1);
   $list->add($name_field,"Tên hiển thị","string",0,0);
   $list->add("use_fullname","Họ và tên","text",0,1);
   $list->add("use_email","Email","text",0,1);
   $list->add("use_phone", "Điện thoại", 'text', 0, 0);
   $list->add("use_experience", "Kinh nghiệm", 'text', 0, 0);
   $list->add("use_status","Duyệt", "checkbox", 0, 1);
   $list->ajaxedit($fs_table);
	$total		= new db_count("SELECT count(*) AS count 
      								 FROM " . $fs_table . "
      								 WHERE 1 " . $list->sqlSearch().$sql_filter);	
   
	$db_listing	= new db_query("SELECT * 
      								 FROM " . $fs_table . "
      								 WHERE 1 " . $list->sqlSearch().$sql_filter."
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
<style type="text/css">
   
</style>
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
   while($row = mysql_fetch_assoc($db_listing->result)){
   $i++;
   ?> 
   <form action="quickedit.php?returnurl=<?=base64_encode(getURL())?>" method="post" name="form_listing" id="form_listing" enctype="multipart/form-data">
   <input type="hidden" name="iQuick" value="update" />
   <?=$list->start_tr($i, $row[$id_field])?>
   <td align="center">
     <p><?=$row['use_id']?></p>
     <input type="hidden" name="record_id[]" id="record_<?=$row["use_id"]?>_<?=$i?>" value="<?=$row["use_id"]?>"/>
   </td>
   <td align="center" width="180">
      <input type="text" value="<?=$row['use_name']?>" style="width: 98%;"/>
   </td>
   <td align="center" width="180">
      <input type="text" value="<?=$row['use_fullname']?>" style="width: 98%;"/>
   </td>
   <td align="center">
      <input type="text" value="<?=$row['use_email']?>" style="width: 98%;" />
   </td>
   <td width="70" align="center">
      <input type="text" value="<?=$row['use_phone']?>" style="width: 110px;" />
   </td>
   <td width="220" align="center">
      <textarea style="width: 98%; height: 50px"><?=$row['use_experience']?></textarea>
   </td>
   <td align="center" width="60">
          <a onClick="loadactive(this); return false;" href="active.php?record_id=<?=$row['use_id']?>&value=<?=$row["use_status"]?>&url=<?=base64_encode(getURL())?>">
          <img border="0" src="<?=$fs_imagepath?>check_<?if($row["use_status"] == -1) echo '0';else echo '1';?>.gif"/>
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