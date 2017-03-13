<?
include ("inc_security.php");
checkAddEdit("add");

$fs_action			= getURL();
//$fs_redirect		= $after_save_data;
$fs_errorMsg		= "";

$fs_redirect      = getValue("url","str","GET",base64_encode("listing.php"));
$record_id 		   = getValue("record_id");
$iPara            = getValue("iPara","int","GET","");

$arr_type_question = array(-1 => "- Chọn dạng câu hỏi -" , 1 => "Multi choice"); //, 2 => "Drag");

//=====Get media=====/
$arr_list_para[-1] = "- Chọn Audio tương ứng cho câu hỏi -";
$db_para_select = new db_query("SELECT * FROM test_content WHERE tec_typ_id = " . $record_id);
while($row_para = mysqli_fetch_assoc($db_para_select->result)){
   $arr_list_para[$row_para['tec_id']] = $row_para['tec_name'];
}unset($db_para_select);

/*--------------------------------------------------------------------------------------------------------*/

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<?=$load_header?>
</head>
<body>
   <div id="confirm_order">
      <div id="wr_detail">

         <?//=========================================Paragraph===============================================?>
         <div id="wr_detail_media">
            <div id="detail_title">
               <select class="form_control" style="width: 485px;" name="para_select" id="para_select">
                  <?foreach($arr_list_para as $id=>$name){?>
   						<option value="<?=$id?>" <?=($id == $iPara) ? "selected='selected'" : ""?>><?=$name?></option>
   					<?}?>
               </select>
            </div>
            <div id="media">
               <div id="para_detail">
               <?
               $db_para_select = new db_query("SELECT * FROM test_content WHERE tec_id = " . $iPara);
               if($row_para = mysqli_fetch_assoc($db_para_select->result)){
                  $url = $data_path.$row_para["tec_audio"];
                  loadmedia($url,200,200);
               }unset($db_para_select);
               ?>
               </div>
            </div>
         </div>

         <?//=========================================ANSWER==================================================?>
         <?if($iPara>0){?>
         <div id="wr_detail_answer">
            <div id="detail_title">
               <select class="form_control" style="width: 485px;" name="unit_select" id="unit_select">
                  <?foreach($arr_type_question as $id=>$name){?>
   						<option value="<?=$id?>"><?=$name?></option>
   					<?}?>
               </select>
            </div>
            <div id="multi_choice" style="display: none;">
               <?include("multi_choice.php")?>
            </div>
            <div id="drag" style="display: none;">
               <?include("drag.php")?>
            </div>
            <div id="fill_word" style="display: none;">
               <? echo'<a style="padding:5px 0px 5px 6px;text-decoration:underline;float:left;" title="Tách đoạn" class="thickbox noborder a_detail" href="fill_word.php?iPara='. $iPara .'& url='. base64_encode(getURL()) . '&TB_iframe=true&amp;height=350&amp;width=1000" /><b style="padding-left:6px;">Tách đoạn</b></a>';?>
            </div>
         </div>
         <?}?>
         <?//=======================================List ques===============================================?>
         <div id="wr_list_answer">
            <div id="list_title">Danh sách câu hỏi - Dạng Multichoice</div>
            <table class="table_info_exe">
               <tr style="background-color: #eee;">
                  <th width="30">STT</th>
                  <th width="500">Nội dung câu hỏi</th>
                  <th width="500">Nội dung câu trả lời</th>
               </tr>
               <?
               $db_ques_select   = new db_query("SELECT * FROM  test_questions WHERE teque_tec_id = ". $iPara ." AND teque_type = 1 ORDER BY teque_order");
               $i = 0;
               while($row_ques = mysqli_fetch_assoc($db_ques_select->result)){
               $i++;
               ?>
               <tr style="background: #A9BAD0;">
                  <td align="center"><?=$i?></td>
                  <td>
                     <input size="30" class="ans_content" id="ques_content_<?=$row_ques['teque_id']?>" name="ans_content" value="<?=$row_ques['teque_content']?>"/>
                     <a class="ans_edit" onclick="save_question(<?=$row_ques['teque_id']?>)">Save</a>
                     <a class="ans_del" onclick="del_question(<?=$row_ques['teque_id']?>)">Delete</a>
                     <a style="padding:5px 0px 5px 6px;text-decoration:none;float:left;" title="Add audio" class="thickbox noborder a_detail" href="ques_audio.php?iQues=<?=$row_ques['teque_id']?>'&iPara=<?=$iPara?>'&record_id=<?=$record_id?>'&url=<?=base64_encode(getURL())?>'&TB_iframe=true&amp;height=350&amp;width=1000">
                        <b style="background: none repeat scroll 0 0 <?=$row_ques['teque_audio'] == "" ? '#1D5691' : "blueviolet"; ?>;color: white;padding: 2px 10px;">Update Audio</b>
                     </a>
                     <a style="padding:5px 0px 5px 6px;text-decoration:none;float:left;" title="Add audio" class="thickbox noborder a_detail" href="ques_audio_part.php?iQues=<?=$row_ques['teque_id']?>'&iPara=<?=$iPara?>'&record_id=<?=$record_id?>'&url=<?=base64_encode(getURL())?>'&TB_iframe=true&amp;height=350&amp;width=1000">
                        <b style="background: none repeat scroll 0 0 <?=$row_ques['teque_part_audio'] == "" ? '#1D5691' : "blueviolet"; ?>;color: white;padding: 2px 10px;">Update Part Audio</b>
                     </a>
                     <input id="score_ques_<?=$row_ques['teque_id']?>" style="text-align: center;width: 30px;background: #eee;margin: 7px 0px 5px 6px;height: 12px;float: left;;color: red;font-weight: bold;" type="text" value="<?=$row_ques['teque_score']?>" />
                     <a onclick="score_ques(<?=$row_ques['teque_id']?>)" class="a_score" style="float: left;cursor: pointer;">Scores</a>
                     <input id="order_ques_<?=$row_ques['teque_id']?>" style="text-align: center;width: 30px;background: #eee;margin: 7px 0px 5px 6px;height: 12px;float: left;;color: red;font-weight: bold;" type="text" value="<?=$row_ques['teque_order']?>" />
                     <a onclick="order_ques(<?=$row_ques['teque_id']?>)" class="a_score" style="float: left;cursor: pointer;">Order</a>
                  </td>
                  <td>
                     <?
                     $db_ans_select = new db_query("SELECT * FROM test_answers
                                                    INNER JOIN test_questions ON tan_teques_id = teque_id
                                                    WHERE tan_teques_id  = ". $row_ques["teque_id"]);
                     while($row_ans = mysqli_fetch_assoc($db_ans_select->result)){
                     if($row_ques['teque_type_sub'] == 1){
                     ?>
                        <input style="width: 325px!important;" size="30" id="ans_content_<?=$row_ans['tan_id']?>" class="ans_content" name="ans_content" value="<?=$row_ans['tan_content']?>"/>
                        <input type="radio" <?=($row_ans['tan_true'] == 1)? "checked=''":""?> class="rdo_check_true" onclick="set_true(<?=$row_ans['tan_id']?>,<?=$row_ques['teque_id']?>)" id="ans_ques_<?=$row_ans['tan_id']?>" name="ans_<?=$row_ques['teque_id']?>" value=""/>
                        <a class="ans_edit" onclick="save_answers(<?=$row_ans['tan_id']?>)">Save</a>
                        <!--<a class="ans_del" onclick="del_answers(<?//=$row_ans['tan_id']?>)">Delete</a>-->
                     <?}else{?>
                        <input size="30" style="width: 325px !important;" id="ans_content_<?=$row_ans['tan_id']?>" class="ans_content" name="ans_content" value="<?=$row_ans['tan_content']?>"/>
                        <?/*<input type="text" style="width: 30px;text-align: center;" value="<?=($row_ans['tan_true'] == 1)? "True":"False"?>"/>*/?>
                        <input type="checkbox" id="chk_true_<?=$row_ans['tan_id']?>" <?=($row_ans['tan_true'] == 1)? "checked=''":""?> value="<?=$row_ans['tan_true']?>" onclick="chk_true(<?=$row_ans['tan_id']?>)" />
                        <a class="ans_edit" onclick="save_answers(<?=$row_ans['tan_id']?>)">Save</a>
                     <?}}unset($db_ans_select);?>
                  </td>
               </tr>
               <?}unset($db_ques_select);?>
            </table>
         </div>

         <?//=======================================List ques===============================================?>



      </div>
   </div>
</body>
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
#multi_choice{float: left;width: 485px;padding:5px 0px 5px 4px;height: 240px;overflow: scroll;}
#drag{float: left;width: 406px;padding: 5px 0px 5px 4px;}
#media{float: left;width: 406px;padding:5px 0px 5px 4px;}
#drag{float: left;width: 406px;padding:5px 0px 5px 4px;}
#content_multi_choice{float: left;width: 406px;padding-left: 4px;}
#dv_add_action{float: left;width: 100%;}
#im_note{float: left;width: 406px;padding:5px 0px 5px 4px;}
#im_note p{float: left;width: 406px;padding: 5px 0px 0px 4px;color: red;margin: 0px;}
#para_detail{float: left;padding-left: 15px;width: 470px;height: 240px;}
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
.ans_content{width: 310px;padding: 4px 4px;border: solid #616D76 1px;border-radius: 1px;color: #616D76;margin:2px 0px;}
.ans_edit{padding: 4px 10px;background: #EEE;border: solid 1px;border-radius: 1px;cursor: pointer;}
.ans_del{padding: 4px 6px;background: #EEE;border: solid 1px;border-radius: 1px;cursor: pointer;}
.ans_add{padding: 5px 10px;background: #EEE;border: solid 1px;border-radius: 5px;cursor: pointer;margin-left: 24px;}
.med_deny{padding: 2px 5px;background: #EEE;border: solid 1px;border-radius: 5px;cursor: pointer;}
.ans_close{padding: 5px 9px;background: #EEE;border: solid 1px;border-radius: 5px;cursor: pointer;}
.media_deny{padding: 4px 9px;background: #EEE;border: solid 1px;border-radius: 5px;cursor: pointer;}
.add_action{float: left;padding: 0px 18px;cursor: pointer;background: #EEE;border: solid 1px;border-radius: 5px;height: 21px;line-height: 21px;margin-top: 5px;}
.p_dt_title{float: left;padding-left: 10px;margin: 0px;}
.sl_list_media{border: solid 1px #616D76;padding: 2px 2px;border-radius: 4px;margin: 5px 0px;}
.a_score{margin: 7px 0px 5px 0px;text-decoration: no;background: green;height: 18px;color: white;line-height: 18px;padding: 0px 5px;}
</style>

<?include("ajax.php");?>