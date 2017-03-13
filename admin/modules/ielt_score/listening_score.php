<?
include ("inc_security.php");
checkAddEdit("add");

$fs_action			= getURL();
$fs_errorMsg		= "";
$fs_title			= $module_name . " | Sửa đổi";
$fs_redirect      = getValue("url","str","GET",base64_encode("listing.php"));
$record_id        = getValue("record_id","int","GET","");
$score            = getValue("score","int","GET",0);
//---------------
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<?=$load_header?>
</head>
<body>
	<div style="padding-left:3px; padding-right:3px;">
   	<table cellpadding="5" cellspacing="0" width="100%" style="border-collapse:collapse;" bordercolor="#CCCCCC" border="1">
   		<tr>
            <th width="600">Bài làm</th>
   		</tr>
   		<?
   		$db_picture = new db_query("SELECT ielt_user_listening,ielr_point_listening,ielr_cmt_listening FROM ielts_result WHERE  ielr_id=" . $record_id);
   		?>
   		<?
   		$i=0;
   		while($row = mysqli_fetch_assoc($db_picture->result)){
   			$i++;
   		?>
   			<tr <?=$fs_change_bg?>>
               <td align="" width="">
                  <div style="color: #164989;font-size: 11px;border-bottom: dotted 1px;text-align: justify;padding-left: 10px;font-weight: bold;"><?=str_replace("|","<br/><br/>",$row["ielt_user_listening"]);?></div><br />
                  <div style="float: left;margin-top: 10px;margin-bottom: 10px;">
                     <input id="score_listening_<?=$record_id?>" style="margin: 0px 0px;;width: 30px;background: #eee;color: red;font-weight: bold;" type="text" value="<?=$row["ielr_point_listening"]?>" />
                  </div>
                  <textarea id="cmt_listening_<?=$record_id?>" style="width: 98%;height:300px;margin-bottom: 10px;"><?=$row["ielr_cmt_listening"]?></textarea>
                  <div><a onclick="score_listening(<?=$record_id?>)" class="a_detail">Scores</a></div>
               </td>
            </tr>
   		<?}?>
   	</table>
	</div>
<? /*------------------------------------------------------------------------------------------------*/ ?>
<style>
.a_detail{padding: 2px 15px;border: solid 1px;background: #EEE;text-decoration: none;color: #164989;cursor: pointer;}
</style>
<script>
function score_listening(record_id){
   var score = $('#score_listening_'+record_id).val();
   var comment = $('#cmt_listening_'+record_id).val();
   var type = 1;
	$.ajax({
		type:'POST',
		dataType:'json',
		data:{
		   score:score,
         comment:comment,
         tesr_id:record_id,
      },
		url:'ajax_score_listening.php',
		success:function(data){
			if(data.err == ''){
				alert(data.msg);
				window.location.reload();
			}else{
				alert(data.err);
			}
      }
   });
}
</script>