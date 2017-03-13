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
<script language="javascript" type="text/javascript" src="../themes/js/jquery.media.js"></script>
<?=$load_header?>
</head>
<body>
	<div style="padding-left:3px; padding-right:3px;">
   	<table cellpadding="5" cellspacing="0" width="100%" style="border-collapse:collapse;" bordercolor="#CCCCCC" border="1">
   		<tr>
            <th colspan="2" width="600">Bài làm</th>
   		</tr>
   		<?
   		$db_picture = new db_query("SELECT ielt_user_writing_first,ielt_user_writing_second,ielr_cmt_writing,ielr_point_writing FROM ielts_result WHERE  ielr_id=" . $record_id);
   		?>
   		<?
   		$i=0;
   		while($row = mysqli_fetch_assoc($db_picture->result)){
   			$i++;
   		?>
   			<tr <?=$fs_change_bg?>>
               <td align="" width="">
                  <div style="color: #164989;font-size: 11px;text-align: justify;padding-left: 10px;font-weight: bold;"><?=$row["ielt_user_writing_first"];?></div><br />
               </td>
               <td align="" width="">
                  <div style="color: #164989;font-size: 11px;text-align: justify;padding-left: 10px;font-weight: bold;"><?=$row["ielt_user_writing_first"];?></div><br />
               </td>
            </tr>
            <tr>
               <td colspan="2">
               <div style="float: left;margin-top: 10px;margin-bottom: 10px;">
                  <input id="score_writing_<?=$record_id?>" style="margin: 0px 0px;;width: 30px;background: #eee;color: red;font-weight: bold;" type="text" value="<?=$row["ielr_point_writing"]?>" />
               </div>
               <textarea style="width: 98%;height:300px;margin-bottom: 10px;" id="cmt_writing_<?=$record_id?>"><?=$row["ielr_cmt_writing"]?></textarea>
               <div><a onclick="score_writing(<?=$record_id?>)" class="a_detail">Scores</a></div>
               </td>
            </tr>
   		<?
   		}
   		?>
   	</table>
	</div>
<? /*------------------------------------------------------------------------------------------------*/ ?>
<style>
.a_detail{padding: 2px 15px;border: solid 1px;background: #EEE;text-decoration: none;color: #164989;cursor: pointer;}
</style>
<script>
function score_writing(record_id){
   var score = $('#score_writing_'+record_id).val();
   var comment = $('#cmt_writing_'+record_id).val();
   var type = 3;
	$.ajax({
		type:'POST',
		dataType:'json',
		data:{
		   score:score,
         comment:comment,
         tesr_id:record_id,
         type:type,
      },
		url:'ajax_score_writing.php',
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