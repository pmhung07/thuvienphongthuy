<?
require_once("inc_security.php");
$list          = new fsDataGird($id_field,$name_field,translate_text("Countries Listing"));
$fs_redirect 	= base64_decode(getValue("url","str","GET",base64_encode("cou_detail.php")));

$iCat	   = getValue("iCat");
$iParent = getValue("iParent");
//$iLev    = getValue("iLev");

//unlink("../../../pictures/courses/small_vnd1343381100.jpg");

$sql_filter = "";
if($iParent !=""){
   if($iCat !="") $sql_filter .= " AND scat_parent_id = '".$iParent."'";
   else $sql_filter .= " AND scat_id = '".$iParent."'"; 
}
if($iCat !="") $sql_filter  .= " AND scat_id = '" . $iCat . "'";
//if($iLev !="") $sql_filter  .= " AND lev_id = '" . $iLev . "'";

//Lay ra danh muc cha
$arrayParent = array();
$arrayParent[''] = "Chọn Danh mục cha";
foreach($array_value as $key=>$value){
   $arrayParent[$key] = $value;
}
//Lấy ra tất cả danh mục con
$db_cateogryAll = new db_query("SELECT scat_name,scat_id
                                FROM support_category
                                WHERE scat_type = 0");
$arr_catAll = $db_cateogryAll->resultArray();
                            
//Lay ra danh muc con
$arrayCat = array();
$arrayCat[''] = "Chọn Danh mục con";
$db_cateogry = new db_query("SELECT scat_name,scat_id
                            FROM support_category
                            WHERE scat_type = 0");
while($row = mysql_fetch_array($db_cateogry->result)){
  $arrayCat[$row["scat_id"]] = $row["scat_name"];
}unset($db_cateogry);



//Tim kiem theo Danh muc va theo Level
//$list->addSearch(translate_text("Danh mục cha"),"iParent","array",$arrayParent,$iParent);
$list->addSearch(translate_text("Danh mục con"),"iCat","array",$arrayCat,$iCat);
//$list->addSearch(translate_text("Level"),"iLev","array",$arr_lev,$iLev);
/*
1: Ten truong trong bang
2: Tieu de header
3: kieu du lieu
4: co sap xep hay khong, co thi de la 1, khong thi de la 0
5: co tim kiem hay khong, co thi de la 1, khong thi de la 0
*/
$list->add($name_field,"Tiêu đề","string", 1, 1);
$list->add("ssha_cat_id","Danh mục","string",0,0);
$list->add("ssha_time","Ngày tạo","string",0,0);
$list->add("ssha_view","View","int",1,0);
$list->add("ssha_active","Active","int", 0, 0);
$list->add("ssha_process","Process","int", 0, 0);
$list->add("",translate_text("Edit"),"edit");
$list->add("",translate_text("Delete"),"delete");
//$list->quickEdit = false;
$list->ajaxedit($fs_table);
//tính tổng các rows trong csdl để phục vụ phân trang
$total			= new db_count("SELECT 	count(*) AS count 
                                FROM ".$fs_table."
                                INNER JOIN support_category ON support_share.ssha_cat_id = support_category.scat_id 
                                WHERE 1".$list->sqlSearch().$sql_filter);
//câu lệnh select dữ liêu										 
$db_listing 	= new db_query("SELECT * FROM support_share 
                               INNER JOIN support_category ON support_share.ssha_cat_id = support_category.scat_id 
						 		 WHERE 1".$list->sqlSearch().$sql_filter
							   . " ORDER BY " . $list->sqlSort() . "ssha_id DESC "
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
   ?>    
      <?=$list->start_tr($i, $row[$id_field])?>
      <td width="250" class="bold" align="center">
         <textarea cols="60" rows="3"><?=$row[$name_field]?></textarea>
      </td>
      <td width="250" align="center">
            <select name="scat_id" id="scat_id"  class="form_control">
            	<?
            	foreach($arr_catAll as $key => $value){
            	?>
            	<option value="<?=$key?>" <? if($value['scat_id'] == $row['ssha_cat_id']) echo "selected='selected'";?>><?=$value['scat_name']?></option>
            	<? } ?>
            </select>
        </td>
      <td align="center" width="50"><?=date("d/m/Y",$row['ssha_time'])?></td>
      <td align="center" width="50"><?=$row['ssha_view'];?></td>
      <?=$list->showCheckbox("ssha_active", $row["ssha_active"], $row[$id_field])?>
      <?=$list->showCheckbox("ssha_process", $row["ssha_process"], $row[$id_field])?>
      <?=$list->showEdit($row['ssha_id'])?>
      <?=$list->showDelete($row['ssha_id'])?>
      <?=$list->end_tr()?>
   <?
     }
   ?>  
   <?=$list->showFooter($total_row)?>
</div>
<? /*---------Body------------*/ ?>
</body>
</html>
<script>
   $(document).ready(function() {
      $('#iParent').change(function (){
         var iParent		   =	$("#iParent").val();
         window.location	=	"listing.php?iParent=" +iParent;
      });
      $('#iCat').change(function (){
         var iParent		   =	$("#iParent").val();
         var iCat		      =	$("#iCat").val();
         window.location	=	"listing.php?iParent="+ iParent +"&iCat="+ iCat;
      });
   });
</script>