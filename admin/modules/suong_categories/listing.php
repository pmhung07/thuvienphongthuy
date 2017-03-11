<?
require_once("inc_security.php");
$list          = new fsDataGird($id_field,$name_field,translate_text("Countries Listing"));
$fs_redirect 	= base64_decode(getValue("url","str","GET",base64_encode("cou_detail.php")));
//if($iLev !="") $sql_filter  .= " AND lev_id = '" . $iLev . "'";

/*
1: Ten truong trong bang
2: Tieu de header
3: kieu du lieu
4: co sap xep hay khong, co thi de la 1, khong thi de la 0
5: co tim kiem hay khong, co thi de la 1, khong thi de la 0
*/
$list->add($name_field,"Tiêu đề","string", 1, 1);
$list->add("cat_order","Thứ tự","string",0,0);
$list->add("cat_active","Active","int", 0, 0);
$list->add("",translate_text("Edit"),"edit");
$list->add("",translate_text("Delete"),"delete");
//$list->quickEdit = false;
$list->ajaxedit($fs_table);
//tính tổng các rows trong csdl để phục vụ phân trang
$total			= new db_count("SELECT 	count(*) AS count
      										  FROM suong_categories 
                            WHERE 1".$list->sqlSearch());
//câu lệnh select dữ liêu										 
$db_listing 	= new db_query("SELECT * FROM suong_categories 
          								 		WHERE 1".$list->sqlSearch()
          									   . " ORDER BY " . $list->sqlSort() . "cat_id DESC "
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
      <td width="300" class="bold" align="center">
         <input type="text" style="width: 300px;color: #15428B;" value="<?=$row[$name_field]?>" />
      </td>   
      <td width="300" align="center">
          <input style="width:190px; color: #15428B;" type="text" value="<?=$row['cat_order']?>" />
      </td>
      <?=$list->showCheckbox("cat_active", $row["cat_active"], $row[$id_field])?>
      <?=$list->showEdit($row['cat_id'])?>
      <?=$list->showDelete($row['cat_id'])?>
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