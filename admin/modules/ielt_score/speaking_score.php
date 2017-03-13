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
<script language="javascript" type="text/javascript" src="../../../themes/js/jquery.media.js"></script>
<?=$load_header?>
</head>
<body>
	<div style="padding-left:3px; padding-right:3px;">
   	<table cellpadding="5" cellspacing="0" width="100%" style="border-collapse:collapse;" bordercolor="#CCCCCC" border="1">
         <tr>
            <th colspan="" width="600">Part 1</th>
            <th colspan="" width="600">Part 2</th>
            <th colspan="" width="600">Part 2</th>
   		</tr>
   		<?
   		$db_picture = new db_query("SELECT ielt_user_speaking_first,ielt_user_speaking_second,ielt_user_speaking_third,ielr_point_speaking,ielr_cmt_speaking FROM ielts_result WHERE  ielr_id=" . $record_id);
   		?>
   		<?
   		$i=0;
   		while($row = mysqli_fetch_assoc($db_picture->result)){
   			$i++;
   		?>
   			<tr <?=$fs_change_bg?>>
               <td align="" width="">
                  <div style="float: left;color: #164989;font-size: 11px;text-align: justify;padding-left: 10px;font-weight: bold;">
                  <?
                  $para = $row['ielt_user_speaking_first'];
                  $para_split = explode(" ",$para);
                  $para_count = count($para_split);
                  for($i = 0;$i < $para_count;$i++){
                     if($i % 2 != 0){
                        echo "<br/>";
                     }else{
                        if($para_split[$i] != ""){
                           $url = $data_path.$para_split[$i];
                           echo'<a style="text-decoration:none" title="Audio" class="thickbox noborder a_detail" href="view_media.php?url='. base64_encode(getURL()) . '&url_media=' . $url . '&TB_iframe=true&amp;height=115&amp;width=420" /><b> View Audio</b></a>';
                        }else{
                           echo "Not Audio";
                        }
                     }
                  }
                  ?>
                  </div><br />
               </td>
               <td align="" width="">
                  <div style="float: left;color: #164989;font-size: 11px;text-align: justify;padding-left: 10px;font-weight: bold;">
                  <?
                     if($row['ielt_user_speaking_second'] != ""){
                        $url = $data_path.$row['ielt_user_speaking_second'];
                        echo'<a style="text-decoration:none" title="Audio" class="thickbox noborder a_detail" href="view_media.php?url='. base64_encode(getURL()) . '&url_media=' . $url . '&TB_iframe=true&amp;height=115&amp;width=420" /><b> View Audio</b></a>';
                     }else{
                        echo "Not Audio";
                     }
                  ?>
                  </div>
               </td>
               <td align="" width="">
                  <div style="float: left;color: #164989;font-size: 11px;text-align: justify;padding-left: 10px;font-weight: bold;">
                  <?
                  $para = $row['ielt_user_speaking_third'];
                  $para_split = explode(" ",$para);
                  $para_count = count($para_split);
                  for($i = 0;$i < $para_count;$i++){
                     if($i % 2 != 0){
                        echo "<br/>";
                     }else{
                        if($para_split[$i] != ""){
                           $url = $data_path.$para_split[$i];
                           echo'<a style="text-decoration:none" title="Audio" class="thickbox noborder a_detail" href="view_media.php?url='. base64_encode(getURL()) . '&url_media=' . $url . '&TB_iframe=true&amp;height=115&amp;width=420" /><b> View Audio</b></a>';
                        }else{
                           echo "Not Audio";
                        }
                     }
                  }
                  ?>
                  </div><br />
               </td>
            </tr>
            <tr>
               <td colspan="3">
               <div style="float: left;margin-top: 10px;margin-bottom: 10px;">
                  <input id="score_speaking_<?=$record_id?>" style="margin: 0px 0px;;width: 30px;background: #eee;color: red;font-weight: bold;" type="text" value="<?=$row["ielr_point_speaking"]?>" />
               </div>
               <textarea style="width: 98%;height:300px;margin-bottom: 10px;" id="cmt_speaking_<?=$record_id?>"><?=$row["ielr_cmt_speaking"]?></textarea>
               <div><a onclick="score_speaking(<?=$record_id?>)" class="a_detail">Scores</a></div>
               </td>
            </tr>
   		<?
   		}
   		?>
   	</table>
	</div>
<? /*------------------------------------------------------------------------------------------------*/ ?>
<style>
.a_detail{padding: 2px 15px;border: solid 1px;background: #EEE;text-decoration: none;color: #164989;float: left;cursor: pointer;margin-bottom: 10px;}
</style>
<script>
function score_speaking(record_id){
   var score = $('#score_speaking_'+record_id).val();
   var comment = $('#cmt_speaking_'+record_id).val();
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
		url:'ajax_score_speaking.php',
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