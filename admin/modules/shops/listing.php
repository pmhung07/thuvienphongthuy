<?
require_once("inc_security.php");
$list          = new fsDataGird($id_field,$name_field,translate_text("Countries Listing"));
//$list->addSearch(translate_text("Level"),"iLev","array",$arr_lev,$iLev);
/*
1: Ten truong trong bang
2: Tieu de header
3: kieu du lieu
4: co sap xep hay khong, co thi de la 1, khong thi de la 0
5: co tim kiem hay khong, co thi de la 1, khong thi de la 0
*/
$arr_city      = array(0=>'Chọn thành phố');
$db_city       = new db_query('SELECT *
                              FROM provinces');
while($row = mysql_fetch_array($db_city->result)){
	$arr_city[$row["id"]] = $row["name"];
}
unset($db_city);
$sqlSearch = '';
$search = getValue('search','int','GET',0);
if($search == 1){
   $name_shop = getValue('sho_name','str','GET','');
   $id_city = getValue('sho_province','int','GET',0);
   $name_shop = ($name_shop == 'Enter keyword')?'':$name_shop;
   if($name_shop==''){
      $sqlSearch = " AND sho_province =".$id_city;
   }else if($id_city==0){
      $sqlSearch = " AND sho_name = '".$name_shop."'";
   }else{
      $sqlSearch = " AND sho_name = '".$name_shop."' AND sho_province =".$id_city;
   }
}
$list->add($name_field,"Tên cửa hàng","string", 0, 0);
$list->add("","Quận/huyện - Tỉnh/thành","string",0,0);
$list->add("sho_address","Địa chỉ","string",0,0);
$list->add("sho_phone","Điện thoại","int",0,0);
$list->add("sho_date","Ngày tạo","int",0,0);
$list->add("sho_negative","Âm tiền","int", 0, 0);
$list->add("sho_active","Active","int", 0, 0);
$list->add("",translate_text("Edit"),"edit");
$list->add("",translate_text("Delete"),"delete");
$list->addSearch(translate_text("Tên cửa hàng"),"sho_name","text","","sho_name");
$list->addSearch(translate_text("Tỉnh"),"sho_province","array",$arr_city,"sho_province");

//$list->quickEdit = false;
$list->ajaxedit($fs_table);
//tính tổng các rows trong csdl để phục vụ phân trang
$total			= new db_count("SELECT 	count(*) AS count 
										 FROM ".$fs_table."
                               WHERE 1".$sqlSearch);
//câu lệnh select dữ liêu						 
$db_listing 	= new db_query("SELECT * FROM ".$fs_table." 
								 		 WHERE 1".$sqlSearch
									   . " ORDER BY " . $list->sqlSort() . "sho_id DESC "
                              .	$list->limit($total->total));
                                 
$total_row = mysql_num_rows($db_listing->result);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<?=$load_header?>
<?=$list->headerScript()?>
</head>
<body>
<? /*---------Body------------*/ ?>
<div id="listing">
   <?=$list->showHeader($total_row)?>
   <?
   $i = 0;
   //thực hiện lênh select csdl
   while($row	=	mysql_fetch_assoc($db_listing->result)){
   $i++;
        $db_districts = new db_query('SELECT * FROM districts WHERE id = '.$row['sho_district']);
        $districts = mysql_fetch_assoc($db_districts->result);unset($db_districts);
        $db_provinces = new db_query('SELECT * FROM provinces WHERE id = '.$row['sho_province']);
        $provinces = mysql_fetch_assoc($db_provinces->result);unset($db_provinces);                   
   ?>    
      <?=$list->start_tr($i, $row[$id_field])?>
      <td width="250" class="bold" align="center">
         <input type="text" style="width: 240px;color: red;" value="<?=$row[$name_field]?>" />
      </td>  
      <td width="250" class="bold" align="center">
         <p><?=$districts['name'].' - '.$provinces['name']?></p>
      </td>   
      <td width="250" class="bold" align="center">
         <input type="text" style="width: 240px;color: red;" value="<?=$row['sho_address']?>" />
      </td>   
      <td width="100" class="bold" align="center">
         <input type="text" style="width: 100px;color: red;" value="<?=$row['sho_phone']?>" />
      </td>   
      <td align="center"><?=date("d/m/Y",$row['sho_date'])?></td>
      <?=$list->showCheckbox("sho_negative", $row["sho_negative"], $row[$id_field])?>
      <?=$list->showCheckbox("sho_active", $row["sho_active"], $row[$id_field])?>
      <?=$list->showEdit($row['sho_id'])?>
      <?=$list->showDelete($row['sho_id'])?>
      <?=$list->end_tr()?>
   <?
     }
   ?>  
   <?=$list->showFooter($total_row)?>
</div>
<? /*---------Body------------*/ ?>
</body>
</html>