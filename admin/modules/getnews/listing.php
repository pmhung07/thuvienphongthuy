<?
require_once("inc_security.php");
$list = new fsDataGird($id_field,$name_field,translate_text("Listing"));
$iCat	   = getValue("iCat");
$iParent = getValue("iParent");
$sql_filter = "";
if($iParent !=""){
   if($iCat !="") $sql_filter .= " AND pcat_parent_id = '".$iParent."'";
   else $sql_filter .= " AND pcat_id = '".$iParent."'";
}
if($iCat !="") $sql_filter  .= " AND pcat_id = '" . $iCat . "'";
//if($iLev !="") $sql_filter  .= " AND lev_id = '" . $iLev . "'";

/*
1: Ten truong trong bang
2: Tieu de header
3: kieu du lieu
4: co sap xep hay khong, co thi de la 1, khong thi de la 0
5: co tim kiem hay khong, co thi de la 1, khong thi de la 0
*/
$list->add($name_field,"Tên tin","string", 1, 1);
$list->add("gen_name_face","Facebook","string",0,0);
$list->add("gen_date","Ngày lấy tin","string",0,0);
$list->add("gen_detais","Nội dung","string",0,0);
$list->add("",translate_text("Link gốc"),"Link gốc");
$list->add("",translate_text("Tin tức"),"Tin tức");
$list->add("",translate_text("Cộng đồng"),"Cộng đồng");
$list->add("",translate_text("Delete"),"delete");
//$list->quickEdit = false;
$list->ajaxedit($fs_table);
//tính tổng các rows trong csdl để phục vụ phân trang
$total			= new db_count("SELECT 	count(*) AS count
                              FROM ".$fs_table."
                              WHERE 1 AND gen_move = 0".$list->sqlSearch().$sql_filter);
//câu lệnh select dữ liêu
$db_listing 	= new db_query("SELECT * FROM ".$fs_table."
 								 		WHERE 1 AND gen_move = 0 ".$list->sqlSearch().$sql_filter
 									   . " ORDER BY " . $list->sqlSort() . "gen_date DESC "
                               .	$list->limit($total->total));

$total_row = mysqli_num_rows($db_listing->result);
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
   while($row	=	mysqli_fetch_assoc($db_listing->result)){
   $i++;
   ?>
      <?=$list->start_tr($i, $row[$id_field])?>
      <td width="225" class="bold" align="center"><?=$row[$name_field]?></td>
      <td align="center" width="30"><?=$row['gen_name_face']?></td>
      <td align="center" width="30"><?=date("d/m/Y",$row['gen_date'])?></td>
      <td width="60px" align="center">
         <? echo'<a title="Chi tiết" style="padding: 3px 15px;border: solid 1px;background: #EEE;text-decoration: none;" class="thickbox noborder a_detail" href="show_details.php?url='. base64_encode(getURL()) . '&record_id=' . $row["gen_id"] .'.&TB_iframe=true&amp;height=600&amp;width=1000&" /><b>Chi tiết</b></a>';?>
      </td>
      <td align="center" width="60"><a style='padding: 3px 15px;border: solid 1px;background: #EEE;text-decoration: none;' href="<?=$row['gen_link']?>" target="_blank">Link gốc</a></td>
      <td width="60px" align="center">
         <? echo'<a title="Chuyển" style="padding: 3px 15px;border: solid 1px;background: #EEE;text-decoration: none;" class="" href="add_post.php?url='. base64_encode(getURL()) . '&record_id=' . $row["gen_id"] .'.&TB_iframe=true&amp;height=600&amp;width=1000&" /><b>Chuyển</b></a>';?>
      </td>
      <td width="80px" align="center">
         <? echo'<a title="Chuyển" style="padding: 3px 15px;border: solid 1px;background: #EEE;text-decoration: none;" class="" href="add_commu.php?url='. base64_encode(getURL()) . '&record_id=' . $row["gen_id"] .'.&TB_iframe=true&amp;height=600&amp;width=1000&" /><b>Chuyển</b></a>';?>
      </td>
      <?=$list->showDelete($row['gen_id'])?>
      <?=$list->end_tr()?>
   <?
     }
   ?>
   <?=$list->showFooter($total_row)?>
</div>
<? /*---------Body------------*/ ?>
</body>
</html>
<style>
#TB_window{
   top:400px;
}
</style>
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