<?
require_once("inc_security.php");
$list          = new fsDataGird($id_field,$name_field,translate_text("Countries Listing"));
$fs_redirect 	= base64_decode(getValue("url","str","GET",base64_encode("cou_detail.php")));
/*
1: Ten truong trong bang
2: Tieu de header
3: kieu du lieu
4: co sap xep hay khong, co thi de la 1, khong thi de la 0
5: co tim kiem hay khong, co thi de la 1, khong thi de la 0
*/
$list->add("vou_user_id","Email","string",0,0);
$list->add("vou_user_phone","Phone","string",0,1);
$list->add("vou_type","Nơi nhận","string",0,0);
$list->add("vou_type_content","Địa điểm","string",0,0);
$list->add("vou_code","Mã Voucher","string",0,0);
$list->add("vou_date","Ngày gửi","string",0,0);
$list->add("vou_active","Active","int", 0, 0);
$list->add("",translate_text("Delete"),"delete");
//$list->quickEdit = false;
$list->ajaxedit($fs_table);
//tính tổng các rows trong csdl để phục vụ phân trang
$total			= new db_count("SELECT 	count(*) AS count
                                FROM ".$fs_table." 
                                LEFT JOIN users 
                                ON( vou_user_id = use_id) 
                                WHERE 1".$list->sqlSearch());
//câu lệnh select dữ liêu										 
$db_listing 	= new db_query("SELECT * 
                                FROM ".$fs_table."  
                                LEFT JOIN users 
                                ON( vou_user_id = use_id) 
					 		    WHERE 1".$list->sqlSearch()
                                 . " ORDER BY " . $list->sqlSort() . "vou_id DESC "
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
      <td width="150" class="bold" align="center"><?=$row["use_email"]?></td>   
      <td width="75" align="center"><?=$row['vou_user_phone']?></td>
      <td width="150" align="center">
      <?
        foreach($arr_type as $key=>$value){
            if($key == $row['vou_type']){
                echo $value;
            }
        }
      ?>
      </td>
      <td align="center"><?=$row['vou_type_content']?></td>
      <td align="center"><?=$row['vou_code']?></td>
      <td align="center"><?=date("d/m/Y",$row['vou_date'])?></td>
      <?=$list->showCheckbox("vou_active", $row["vou_active"], $row[$id_field])?>
      <?=$list->showDelete($row['vou_id'])?>
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