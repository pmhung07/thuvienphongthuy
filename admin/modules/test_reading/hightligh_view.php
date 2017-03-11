<?
include ("inc_security.php");
$fs_title = $module_name . " | Thêm mới";
checkAddEdit("add");

$iPara            = getValue("iPara","int","GET","");
$iQues            = getValue("iQues","int","GET","");
$record_id 		   = getValue("record_id");
$fs_action			= getURL();
$fs_errorMsg		= "";
$after_save_data  = getValue("after_save_data", "str", "POST", "add_exercises.php");
$fs_redirect      = $after_save_data;

?>

<div id="wr_list_answer">       
   <div id="list_title">Hightlight</div>
   <table class="table_info_exe">
      <tr style="font-size: 14px;">
         <th width="30">STT</th>
         <th width="800">Paragraph</th>
         <th width="20">Edit</th>
         <th width="20">Delete</th>
      </tr>
      <? 
      $db_ans_select = new db_query("SELECT * FROM test_highlight 
                                     WHERE high_teque_id  = ". $iQues);  
      $i = 0;
      while($row_ans = mysql_fetch_assoc($db_ans_select->result)){
      $i++;
      ?>
      <tr style="background:#A9BAD0;">
         <td align="center"><?=$i?></td> 
         <td bgcolor="white"><?=$row_ans["high_paragraph"]?></td>
         <td align="center"><a class="text" href="edit_hightligh.php?high_id=<?=$row_ans["high_id"]?>&iPara=<?=$iPara?>&record_id=<?=$record_id?>&returnurl=<?=base64_encode(getURL())?>"><img src="<?=$fs_imagepath?>edit.png" alt="EDIT" border="0"/></a></td>
         <td align="center"><img src="<?=$fs_imagepath?>delete.gif" alt="DELETE" border="0" onClick="if (confirm('Are you sure to delete?')){ window.location.href='hightligh_del.php?record_id=<?=$record_id?>&high_id=<?=$row_ans["high_id"]?>&iPara=<?=$iPara?>&returnurl=<?=base64_encode(getURL())?>'}" style="cursor:pointer"/></td>
      </tr>
      <?}?>
   </table>
</div>            

<style>
#wr_list_answer{float: left;margin:10px 0px 30px 11px;border-right: solid 1px #eee;border: solid 1px #eee;width: 940px;}
#list_title{width: 933px;float: left;background: #E0EBF6;padding: 4px 0px 4px 7px;color: #616D76;font-weight: bold;text-align: center;height: 15px;line-height: 15px;}
#wr_detail{width: 100%;height: 100%;}
#detail_title{width: 490px;float: left;background: #eee;color: #616D76;font-weight: bold;height: 23px;line-height: 23px;}
#wr_detail_info{float: left;width: 100%;border-bottom: solid 1px #eee;}
#wr_detail_answer{float: left;margin:10px 0px 0px 12px;border-right: solid 1px #eee;border: solid 1px #eee;width: 490px;}
#wr_detail_media{float: left;margin:10px 0px 0px 11px;border-right: solid 1px #eee;border: solid 1px #eee;width: 495px;}
#wr_detail_left{float: left;width: 420px;}
#detail_content{float: left;width: 406px;padding:5px 0px 5px 4px;border-bottom: dotted 1px #eee;}
#multi_choice{float: left;width: 406px;padding:5px 0px 5px 4px;}
#drag{float: left;width: 406px;padding: 5px 0px 5px 4px;}
#media{float: left;width: 406px;padding:5px 0px 5px 4px;}
#drag{float: left;width: 406px;padding:5px 0px 5px 4px;}
#content_multi_choice{float: left;width: 406px;padding-left: 4px;}
#dv_add_action{float: left;width: 100%;}
#im_note{float: left;width: 406px;padding:5px 0px 5px 4px;}
#im_note p{float: left;width: 406px;padding: 5px 0px 0px 4px;color: red;margin: 0px;}
#para_detail{float: left;padding-left: 15px;width: 470px;}
.dv_add_action_invi{display: none;}
.p_info{padding:10px 12px;float: left;width: 100%;margin: 0px;}
.b_info{color: red;}
.a_submit{border: solid 1px #5E6C77;padding: 3px 15px;background: #EEE;color: #E27A13;font-weight: bold;margin: 0px 4px;float: left;cursor: pointer;}
.a_close{float:right;color: #64707B;padding-right: 5px;text-decoration: underline;cursor: pointer;}
.btn_add{background-color: #F2F2F2;border: 1px #CCC solid;font-size: 11px;margin-left: 23px;cursor: pointer;}
.btn_add_drag{background-color: #F2F2F2;border: 1px #CCC solid;font-size: 11px;margin-left: 5px;cursor: pointer;}
.table_info_exe{color: #616D76;font-size: 11px;margin-top: 0px;}
.table_info_exe th{border: 1px solid #DDD;line-height: 10px;padding: 7px;vertical-align: top;}
.table_info_exe td{border: 1px solid #DDD;line-height: 23px;padding: 7px;vertical-align: top;}
.ans_content{width: 300px;padding: 5px 5px;border: solid #616D76 1px;border-radius: 3px;color: #616D76;margin:2px 0px;}
.ans_edit{padding: 5px 7px;background: #EEE;border: solid 1px;border-radius: 5px;cursor: pointer;}
.ans_del{padding: 5px 6px;background: #EEE;border: solid 1px;border-radius: 5px;cursor: pointer;}
.ans_add{padding: 5px 10px;background: #EEE;border: solid 1px;border-radius: 5px;cursor: pointer;margin-left:0;}
.med_deny{padding: 2px 5px;background: #EEE;border: solid 1px;border-radius: 5px;cursor: pointer;}
.ans_close{padding: 5px 9px;background: #EEE;border: solid 1px;border-radius: 5px;cursor: pointer;}
.media_deny{padding: 4px 9px;background: #EEE;border: solid 1px;border-radius: 5px;cursor: pointer;}
.add_action{margin-left:20px;float: left;padding: 0px 18px;cursor: pointer;background: #EEE;border: solid 1px;border-radius: 5px;height: 21px;line-height: 21px;margin-top: 5px;}
.p_dt_title{float: left;padding-left: 10px;margin: 0px;}
.sl_list_media{border: solid 1px #616D76;padding: 2px 2px;border-radius: 4px;margin: 5px 0px;}
</style>
