<?
require_once("inc_security.php");
$list          = new fsDataGird("ielr_id","",translate_text("Countries Listing"));
$fs_redirect 	= base64_decode(getValue("url","str","GET",base64_encode("cou_detail.php")));

//Lay ra danh muc con
$array_teach_success = array( 0 => "Chưa chấm" , 1 => "Đã chấm" );
$iSuccess   = getValue("ielt_teach_success","int","GET",0);
$sql_filter = " AND ielt_teach_success = ".$iSuccess;

//Tim kiem theo Danh muc va theo Level
$list->addSearch(translate_text("Chọn bài thi chưa chấm"),"ielt_teach_success","array",$array_teach_success,$iSuccess);
//$list->addSearch(translate_text("Level"),"iLev","array",$arr_lev,$iLev);
/*
1: Ten truong trong bang
2: Tieu de header
3: kieu du lieu
4: co sap xep hay khong, co thi de la 1, khong thi de la 0
5: co tim kiem hay khong, co thi de la 1, khong thi de la 0
*/
$list->add("ielr_user_id","User Code","string",0,1);
$list->add("test_name","Test Name","string", 0, 1);
$list->add("ielt_user_listening","Reading Score","string",0,0);
$list->add("ielt_user_reading","Listening Score","string",0,0);
$list->add("ielt_speaking","Speaking Score","string",0,0);
$list->add("ielt_writing","Writing Score","int", 0, 0);
$list->add("ielt_teach_success","Complete","int", 0, 1);

//$list->quickEdit = false;
$list->ajaxedit($fs_table);
//tính tổng các rows trong csdl để phục vụ phân trang
$total			= new db_count("SELECT 	count(*) AS count 
										 FROM ielts_result 
                               INNER JOIN ielts ON (ielr_ielt_id = ielt_id)
                               WHERE 1".$list->sqlSearch()." AND ielr_user_success = 1 ".$sql_filter);
//câu lệnh select dữ liêu										 
$db_listing 	= new db_query("SELECT * FROM  ielts_result 
                               INNER JOIN ielts ON (ielr_ielt_id = ielt_id)
								 		 WHERE 1".$list->sqlSearch().$sql_filter ." AND ielr_user_success = 1"
									   . " ORDER BY " . $list->sqlSort() . "ielr_user_success DESC "
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
      <td width="50" align="center">
		   <? echo'<a title="Thông tin chi tiết" class="thickbox noborder a_detail" href="confirmation.php?url='. base64_encode(getURL()) . '&record_id=' . $row["ielr_id"] .'&TB_iframe=true&amp;height=450&amp;width=1000" /><b>'.$row['ielr_id'].'</b></a>';?>
		</td>
      <td width="100" class="bold" align="center">
         <input type="text" style="width: 100px;color: red;" value="<?=$row['ielt_name']?>" />
      </td>
      <td width="30" align="center">
         <input style="width: 30px;background: #eee;" type="text" readonly="" value="<?=$row["ielr_point_reading"]?>" />
         <? echo'<a title="Thông tin chi tiết" class="thickbox noborder a_detail" href="reading_score.php?url='. base64_encode(getURL()) . '&record_id=' . $row["ielr_id"] .'&score=' . $row["ielr_point_reading"] . '&TB_iframe=true&amp;height=450&amp;width=1000" /><b>Scores</b></a>'; ?>        
      </td>
      </td>      
      <td width="30" align="center">
         <input style="width: 30px;background: #eee;" type="text" readonly="" value="<?=$row["ielr_point_listening"]?>" />
         <? echo'<a title="Thông tin chi tiết" class="thickbox noborder a_detail" href="listening_score.php?url='. base64_encode(getURL()) . '&record_id=' . $row["ielr_id"] .'&score=' . $row["ielr_point_listening"] . '&TB_iframe=true&amp;height=450&amp;width=1000" /><b>Scores</b></a>'; ?>        
      </td>
      <td width="70" align="center">
         <input style="width: 30px;background: #eee;" type="text" readonly="" value="<?=$row["ielr_point_speaking"]?>" />  
         <? echo'<a title="Thông tin chi tiết" class="thickbox noborder a_detail" href="speaking_score.php?url='. base64_encode(getURL()) . '&record_id=' . $row["ielr_id"] .'&score=' . $row["ielr_point_speaking"] . '&TB_iframe=true&amp;height=450&amp;width=1000" /><b>Scores</b></a>'; ?>        
      </td> 
      <td width="70" align="center">
         <input style="width: 30px;background: #eee;" type="text" readonly="" value="<?=$row["ielr_point_writing"]?>" />
         <? echo'<a title="Thông tin chi tiết" class="thickbox noborder a_detail" href="writing_score.php?url='. base64_encode(getURL()) . '&record_id=' . $row["ielr_id"] .'&score=' . $row["ielr_point_writing"] . '&TB_iframe=true&amp;height=450&amp;width=1000" /><b>Scores</b></a>'; ?>
      </td> 
      <td width="50" align="center">
         <?if($row['ielt_teach_success'] == 0){?>
            <input id="bt_send_mail" style="width: 76px;background: #EEE;text-align: center;font-weight: bold;color: red;cursor: pointer;" type="text" readonly="" value="Send" onclick="send_mail_multi(<?=$row['ielr_id']?>)" />
         <?}else{?>
            <input style="width: 76px;background: #EEE;text-align: center;font-weight: bold;color: red;" type="text" readonly="" value="Complete" />
         <?}?>
      </td>
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
   function send_mail_multi(record_id){   
      $("#bt_send_mail").hide();
   	$.ajax({
   		type:'POST',
   		dataType:'json',
   		data:{
            record_id:record_id,
         },
   		url:'ajax_send_mail_score.php',
   		success:function(data){
   		   $("#bt_send_mail").show();
   			if(data.err == ''){
   				alert(data.msg);	
               window.location.reload();
   			}else{
   				alert(data.err);
   			}
         }
      });
   }
   //--------------------------------------------------------
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
<style>
.a_detail{padding: 1px 15px;padding-top: 2px;border: solid 1px;background: #EEE;text-decoration: none;color: #E17009;}
</style>