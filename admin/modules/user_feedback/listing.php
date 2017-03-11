<?
require_once("inc_security.php");
$list          = new fsDataGird("usefb_id","",translate_text("Countries Listing"));
$array_status = array( 0 => "Chưa xử lý" , 1 => "Đã xử lý" );
$status   = getValue("status_value","int","GET",0);
$sql_filter = " AND usefb_status = ".$status;
/*
1: Ten truong trong bang
2: Tieu de header
3: kieu du lieu
4: co sap xep hay khong, co thi de la 1, khong thi de la 0
5: co tim kiem hay khong, co thi de la 1, khong thi de la 0
*/
$list->addSearch(translate_text("Chọn trạng thái"),"status_value","array",$array_status,$status);

$list->add("usefb_email","Email","string",1,1);
$list->add("usefb_time","Thời gian gửi","int",1,0);
$list->add("usefb_title","Tiêu đề","string",1,0);
$list->add("usefb_status","Trạng thái","int",0,0);
$list->add("",translate_text("View  "),"edit");
$list->add("",translate_text("Delete"),"delete");

$list->ajaxedit($fs_table);
//tính tổng các rows trong csdl để phục vụ phân trang
$total			= new db_count("SELECT count(*) AS count FROM user_feedback
                               WHERE 1".$list->sqlSearch().$sql_filter);
//câu lệnh select dữ liêu										 
$db_listing 	= new db_query("SELECT * FROM user_feedback
                               WHERE 1".$list->sqlSearch(). $sql_filter
                               ." ORDER BY ". $list->sqlSort()  . " usefb_id DESC "
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
      <td align="center" width="220">
         <input style="text-align: center;color: red;font-weight: bold;font-size: 11px;width: 220px;" value="<?=$row['usefb_email']?>" type="text" readonly="true" />
      </td>
      <td align="center" width="100">
         <input style="text-align: center;color: red;font-weight: bold;font-size: 11px;width: 180px;" value="<?=date('d/m/Y - h:i:s',$row['usefb_time'])?>" type="text" readonly="true"/>
      </td>
      <td align="center" width="180">
         <input style="text-align: center;color: red;font-weight: bold;font-size: 11px;width: 180px;" value="<?=$row['usefb_title']?>" type="text" readonly="true"/>
      </td>
      <td align="center" width="100">
         <input style="text-align: center;color: red;font-weight: bold;font-size: 11px;width: 100px;" value="<?if($row['usefb_status'] == 0) echo 'Chưa xử lý';else echo 'Đã xử lý';?>" type="text" readonly="true"/>
      </td>
      <td align="center" width="100">
         <a title="Xem chi tiết" class="a_detail" href="edit.php?record_id=<?=$row['usefb_id']?>&url=<?=base64_encode($_SERVER['REQUEST_URI'])?>"><b>Xem chi tiết</b></a>
      </td>      
      <?=$list->showDelete($row['usefb_id'])?>
      <?=$list->end_tr()?>
   <?}?>    
   <?=$list->showFooter($total_row)?>
</div>
<? /*---------Body------------*/ ?>
</body>
</html>
<style>
.a_detail{padding: 3px 15px;border:solid 1px;background:#EEE;text-decoration:none;}
</style>