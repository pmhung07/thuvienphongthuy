<?
include ("inc_security.php");
checkAddEdit("add");

$fs_redirect = getValue("url","str","GET",base64_encode("listing.php"));
$record_id = getValue("record_id","int","GET","");
$fs_action = getURL();
//=====Question type=====/

/*
   QUETYPE: 1. Multi choice
            2. Fillword
            3. Drag and Drop
*/
$arr_type_question = array(1 => "|-- Multi choice" , 2 => "|-- Fill word (Điền từ)" , 3 => "|-- Drag and drop (Kéo thả)");

//=====Get information=====/
$sql_course = "";
if($record_id >0){
   $sql_course = "SELECT * FROM " . $fs_table . " INNER JOIN courses_multi ON exe_com_id = com_id
                                                  INNER JOIN courses ON com_cou_id = cou_id
                                                  WHERE exe_id = ".$record_id;
   $db_course_select = new db_query($sql_course);
   $db_course = mysqli_fetch_assoc($db_course_select->result);
}
$db_cate       = new db_query('SELECT cat_name,cat_id
                                 FROM categories_multi
                                 WHERE cat_id='.$db_course['cou_cat_id']);
$dbcate        = mysqli_fetch_assoc($db_cate->result);
unset($db_cate);
$db_level      = new db_query('SELECT lev_name
                                 FROM levels
                                 WHERE lev_id='.$db_course['cou_lev_id']);
$dblevel       = mysqli_fetch_assoc($db_level->result);
unset($db_level);
$link = generate_preview_link($dbcate['cat_name'],$dblevel['lev_name'],$db_course['com_name'],$db_course['cou_id'],$db_course['com_id'],'quiz');
//========Array for checkout type questions============//
$arr_get_typeques = array();
//Get Type questions
$db_select_type = new db_query("SELECT * FROM questions STRAIGHT_JOIN exercises ON que_exe_id = exe_id WHERE exe_id = ".$record_id." GROUP BY que_type");
$i = 0;
while($row_a = mysqli_fetch_assoc($db_select_type->result)){
   $arr_get_typeques[$i] = $row_a["que_type"];
   $i++;
}
unset($db_select_type);
//=====Get list question=====/
$total			   = new db_count("SELECT 	count(*) AS count FROM questions WHERE que_exe_id = ".$record_id);
$db_ques_select   = new db_query("SELECT * FROM questions WHERE que_exe_id = ".$record_id ." AND que_type = 1 GROUP BY que_id DESC");
$total_row        = mysqli_num_rows($db_ques_select->result);

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
         <?//==============================INFO===================================?>

         <div id="wr_detail_info">
            <?if($row =	mysqli_fetch_assoc($db_course_select->result)){?>
            <p class="p_info">
               <b>Khóa học : </b><b class="b_info"><?=$row["cou_name"]?></b>
               <b> -  Unit : </b><b class="b_info"><?=$row["com_name"]?></b>
            </p>
            <?}unset($db_course_select)?>
         </div>

         <?//=========================CHOOSE QUESTION TYPE=========================?>
         <div id="wr_detail_answer">

            <?//==========================TITLE========================?>

            <div id="detail_title">
               <select class="form_control" style="width: 402px;" name="unit_select" id="unit_select">
                  <option value="-1"> - Chọn dạng câu hỏi - </option>
                  <?foreach($arr_type_question as $id=>$name){
                     if(!in_array($id,$arr_get_typeques) && $arr_get_typeques != Null) continue;
                  ?>
   						<option value="<?=$id?>"><?=$name?></option>
   					<?}?>
               </select>
            </div>

            <?//====================MULTI CHOICE TYPE ==================?>

            <div id="multi_choice" style="display: none;">
               <?
               $form = new form();
            	$form->create_form("add", $fs_action, "post", "multipart/form-data",'onsubmit="validateForm(); return false;"');
            	$form->create_table();
               ?>
               <tr>
                  <td width="120px" class="form_name">Nhập câu hỏi :</td>
                  <td><input type="text" name="question" id="question" class="form_control" style="width:250px;" value=""/></td>
               </tr>
               <tr>
                  <td width="120px" class="form_name">Nhập câu trả lời :</td>
                  <td>
                     <ul style="list-style: none;padding: 0px 6px;">
                        <li style="margin: 5px 0px;"><b>A. </b>
                           <input type="text" name="ans_1" id="ans_1" class="form_control" style="width:205px;" value=""/>
                           <input type="radio" name="rdo" id="rdo_1" class="form_control" value="0" onclick="check_rdo_true(1)" />
                        </li>
                        <li style="margin: 5px 0px;"><b>B. </b>
                           <input type="text" name="ans_2" id="ans_2" class="form_control" style="width:205px;" value=""/>
                           <input type="radio" name="rdo" id="rdo_2" class="form_control" value="0" onclick="check_rdo_true(2)" />
                        </li>
                        <li style="margin: 5px 0px;"><b>C. </b>
                           <input type="text" name="ans_3" id="ans_3" class="form_control" style="width:205px;" value=""/>
                           <input type="radio" name="rdo" id="rdo_3" class="form_control" value="0" onclick="check_rdo_true(3)" />
                        </li>
                        <li style="margin: 5px 0px;"><b>D. </b>
                           <input type="text" name="ans_4" id="ans_4" class="form_control" style="width:205px;" value=""/>
                           <input type="radio" name="rdo" id="rdo_4" class="form_control" value="0" onclick="check_rdo_true(4)" />
                        </li>
                     </ul>
                  </td>
               </tr>
               <tr>
                  <td width="120px" class="form_name"></td>
                  <td><input type="button" onclick="add_multi_choice(<?=$record_id?>)" name="btn_add" id="btn_add" class="btn_add" value="Thêm mới"/></td>
               </tr>
               <?
            	$form->close_table();
            	$form->close_form();
            	unset($form);
            	?>
            </div>

            <?//================== FILLWORD TYPE=================?>

            <div id="fill_word" style="display: none;">
               <? echo'<a style="padding:5px 0px 5px 6px;text-decoration:underline;float:left;" title="Nhập đoạn văn" class="thickbox noborder a_detail" href="fill_word.php?&record_id='. $record_id .'&que_type	= 2&url='. base64_encode(getURL()) . '&TB_iframe=true&amp;height=350&amp;width=950" /><b style="padding-left:6px;">Nhập đoạn văn</b></a>';?>
               <?/*
               $form = new form();
            	$form->create_form("add", $fs_action, "post", "multipart/form-data",'onsubmit="validateForm(); return false;"');
            	$form->create_table();
               ?>
               <tr>
                  <td class="form_name">Nhập câu hỏi(Phần đầu):</td>
                  <td><input type="text" name="question" id="ques_drag_head" class="form_control" style="width:235px;" value=""/></td>
               </tr>
               <tr>
                  <td class="form_name">Nhập câu trả lời :</td>
                  <td>
                     <input type="text" name="ans_drag" id="ans_drag" class="form_control" style="width:235px;" value=""/>
                  </td>
               </tr>
               <tr>
                  <td class="form_name">Nhập câu hỏi(Phần cuối):</td>
                  <td><input type="text" name="question" id="ques_drag_end" class="form_control" style="width:235px;" value=""/></td>
               </tr>
               <tr>
                  <td class="form_name"></td>
                  <td><input type="button" onclick="add_drag(<?=$record_id?>)" name="btn_add_drag" id="btn_add_drag" class="btn_add_drag" value="Thêm mới"/></td>
               </tr>
               <?
            	$form->close_table();
            	$form->close_form();
            	unset($form);
            	?>

               <hr />
               <?/*  Nhập theo đoạn văn
               <?
               $form = new form();
            	$form->create_form("add_v", $fs_action, "post", "multipart/form-data",'onsubmit="validateForm(); return false;"');
            	$form->create_table();
               ?>
               <tr>
                  <td class="form_name">Nhập câu hỏi (Đoạn văn) :</td>
                  <td><textarea name="question_v" id="ques_drag_v" class="form_control" style="width: 230px;height: 70px;"><?=$pha_con_1?></textarea></td>
               </tr>
               <tr>
                  <td class="form_name">Nhập câu trả lời :</td>
                  <td>
                     <input type="text" name="ans_drag_v" id="ans_drag_v" class="form_control" style="width:230px;" value=""/>
                  </td>
               </tr>
               <tr>
                  <td class="form_name"></td>
                  <td><input type="button" onclick="add_drag_v(<?=$record_id?>)" name="btn_add_drag_v" id="btn_add_drag_v" class="btn_add_drag" value="Thêm mới"/></td>
               </tr>
               <?
            	$form->close_table();
            	$form->close_form();
            	unset($form);
            	?>
               */?>
            </div>

            <?/*//Drag and Drop*/?>
            <div id="drag" style="display: none;">
               <? echo'<a style="padding:5px 0px 5px 6px;text-decoration:underline;float:left;" title="Nhập đoạn văn" class="thickbox noborder a_detail" href="fill_word.php?&record_id='. $record_id .'&que_type	= 3&url='. base64_encode(getURL()) . '&TB_iframe=true&amp;height=350&amp;width=950" /><b style="padding-left:6px;">Nhập đoạn văn</b></a>';?>
            </div>
            <?//====================Note=========================?>
            <!--<div id="im_note">
               <p>• Mỗi bài tập chỉ được nhập một dạng câu hỏi .</p>
               <p>• Không sửa "_____" khi sửa nội dung câu hỏi .</p>
            </div>-->
         </div>

         <?//=========================QUESTION LIST==========================?>

         <div id="wr_list_answer">
            <div id="list_title">Danh sách câu hỏi - Dạng multi choice</div>
            <table class="table_info_exe">
               <tr style="background-color: #eee;">
                  <th width="30">STT</th>
                  <th width="500">Nội dung câu hỏi</th>
                  <th width="500">Nội dung câu trả lời</th>
               </tr>
               <?
               $i = 0;
               while($row_ques = mysqli_fetch_assoc($db_ques_select->result)){$i++;?>
               <tr style="">
                  <td style="background: #A9BAD0;" align="center"><?=$i?></td>
                  <td style="background: #A9BAD0;">
                     <input size="30" class="ans_content" id="ques_content_<?=$row_ques['que_id']?>" name="ans_content" value="<?=$row_ques['que_content']?>"/>
                     <a class="ans_edit" onclick="save_question(<?=$row_ques['que_id']?>)">Save</a>
                     <a class="ans_del" onclick="del_question(<?=$row_ques['que_id']?>)">Delete</a>
                      <!---->
                     <?/*<p style="margin: 0px;"><b style="margin: 0px;">Giải thích:</b></p>
                     <input type="text" class="ans_content" id="ques_exp_<?=$row_ques['que_id']?>" name="exp_content" value="<?=$row_ques['que_explain']?>" />
                     <a class="ans_edit" onclick="save_explain(<?=$row_ques['que_id']?>)">Save</a>
                     */?>
                  </td>
                  <td style="background: #A9BAD0;">
                     <?
                     $db_ans_select = new db_query("SELECT * FROM answers INNER JOIN questions ON ans_ques_id = que_id
                                                    WHERE ans_ques_id  = ". $row_ques["que_id"]);
                     while($row_ans = mysqli_fetch_assoc($db_ans_select->result)){
                     ?>
                        <input size="30" id="ans_content_<?=$row_ans['ans_id']?>" class="ans_content" name="ans_content" value="<?=$row_ans['ans_content']?>"/>
                        <input type="radio" <?=($row_ans['ans_true'] == 1)? "checked=''":""?> class="rdo_check_true" onclick="set_true(<?=$row_ans['ans_id']?>,<?=$row_ques['que_id']?>)" id="ans_ques_<?=$row_ans['ans_id']?>" name="ans_<?=$row_ques['que_id']?>" value=""/>
                        <a class="ans_edit" onclick="save_answers(<?=$row_ans['ans_id']?>)">Save</a>
                        <a class="ans_del" onclick="del_answers(<?=$row_ans['ans_id']?>)">Delete</a>
                     <?}unset($db_ans_select);?>
                     <?if($row_ques['que_type'] == 1){?>
                        <div id="dv_add_action">
                           <div id="dv_add_action_invi_<?=$row_ques['que_id']?>" class="dv_add_action_invi">
                              <input size="30" id="add_ans_content_<?=$row_ques['que_id']?>" class="ans_content" name="ans_content" value="<?=$row_ans['ans_content']?>"/>
                              <a class="ans_add" onclick="add_ans_multi(<?=$row_ques['que_id']?>)">Add</a>
                              <a class="ans_close" onclick="">Close</a>
                           </div>
                           <a onclick="add_show(<?=$row_ques['que_id']?>)" class="add_action">+</a>
                        </div>
                     <?}?>
                  </td>
               </tr>
               <?}unset($db_ques_select);?>
            </table>
         </div>

         <?//Question list Fillword?>
         <div id="wr_list_answer">
            <div id="list_title">Danh sách câu hỏi - Dạng Fill word</div>
            <table class="table_info_exe">
               <tr style="background-color: #eee;">
                  <th width="30">STT</th>
                  <th width="800">Paragraph</th>
                  <th width="20">Edit</th>
                  <th width="20">Delete</th>
               </tr>
               <?
               $db_ans_select = new db_query("SELECT * FROM questions WHERE que_type = 2 AND que_exe_id  = ". $record_id);
               $i = 0;
               while($row_ans = mysqli_fetch_assoc($db_ans_select->result)){
               $i++;
               ?>
               <tr>
                  <td style="background: #A9BAD0;" align="center"><?=$i?></td>
                  <td style="background: white;"><?=str_replace("|","___",$row_ans["que_content"])?></td>
                  <td style="background: #A9BAD0;" align="center"><a class="text" href="edit_fill_word.php?que_id=<?=$row_ans["que_id"]?>&record_id=<?=$record_id?>&returnurl=<?=base64_encode(getURL())?>"><img src="<?=$fs_imagepath?>edit.png" alt="EDIT" border="0"/></a></td>
                  <td style="background: #A9BAD0;" align="center"><img src="<?=$fs_imagepath?>delete.gif" alt="DELETE" border="0" onClick="if (confirm('Are you sure to delete?')){ window.location.href='del_fill_word.php?record_id=<?=$record_id?>&que_id=<?=$row_ans["que_id"]?>&returnurl=<?=base64_encode(getURL())?>'}" style="cursor:pointer"/></td>
               </tr>
               <?}unset($db_ans_select)?>
            </table>
         </div>

         <?//Question list Fillword?>
         <div id="wr_list_answer">
            <div id="list_title">Danh sách câu hỏi - Dạng Drag and drop</div>
            <table class="table_info_exe">
               <tr style="background-color: #eee;">
                  <th width="30">STT</th>
                  <th width="800">Paragraph</th>
                  <th width="20">Edit</th>
                  <th width="20">Delete</th>
               </tr>
               <?
               $db_ans_select = new db_query("SELECT * FROM questions WHERE que_type = 3 AND que_exe_id  = ". $record_id);
               $i = 0;
               while($row_ans = mysqli_fetch_assoc($db_ans_select->result)){
               $i++;
               ?>
               <tr>
                  <td align="center"><?=$i?></td>
                  <td><?=str_replace("|","___",$row_ans["que_content"])?></td>
                  <td align="center"><a class="text" href="edit_fill_word.php?que_id=<?=$row_ans["que_id"]?>&record_id=<?=$record_id?>&returnurl=<?=base64_encode(getURL())?>"><img src="<?=$fs_imagepath?>edit.png" alt="EDIT" border="0"/></a></td>
                  <td align="center"><img src="<?=$fs_imagepath?>delete.gif" alt="DELETE" border="0" onClick="if (confirm('Are you sure to delete?')){ window.location.href='del_fill_word.php?record_id=<?=$record_id?>&que_id=<?=$row_ans["que_id"]?>&returnurl=<?=base64_encode(getURL())?>'}" style="cursor:pointer"/></td>
               </tr>
               <?}unset($db_ans_select)?>
            </table>
         </div>
         <div id="wr_list_answer" style="margin: none; border: none; margin-left: 11px; margin-top: 12px;text-align: center; "><a target="_black" href="<?=$link?>" style="padding: 5px; background: #ddd; border-radius: 2px; text-decoration: none;">Preview</a></div>

      </div>
   </div>
</body>

<style>
#wr_list_answer{float: left;margin:10px 0px 0px 11px;border-right: solid 1px #eee;border: solid 1px #eee;width: 940px;}
#list_title{width: 933px;float: left;background: #E0EBF6;padding: 4px 0px 4px 7px;color: #616D76;font-weight: bold;text-align: center;height: 15px;line-height: 15px;}
#wr_detail{width: 100%;height: 100%;}
#detail_title{width: 411px;float: left;background: #eee;color: white;font-weight: bold;}
#wr_detail_info{float: left;width: 100%;border-bottom: solid 1px #eee;}
#wr_detail_answer{float: left;margin:10px 0px 0px 11px;border-right: solid 1px #eee;border: solid 1px #eee;width: 411px;}
#wr_detail_left{float: left;width: 420px;}
#detail_content{float: left;width: 406px;padding:5px 0px 5px 4px;border-bottom: dotted 1px #eee;}
#multi_choice{float: left;width: 406px;padding:5px 0px 5px 4px;}
#drag{float: left;width: 406px;padding:5px 0px 5px 4px;}
#fill_word{float: left;width: 406px;padding:5px 0px 5px 4px;}
#content_multi_choice{float: left;width: 406px;padding-left: 4px;}
#dv_add_action{float: left;width: 100%;}
#im_note{float: left;width: 406px;padding:5px 0px 5px 4px;}
#im_note p{float: left;width: 406px;padding: 5px 0px 0px 4px;color: red;margin: 0px;}
.dv_add_action_invi{display: none;}
.p_info{padding:10px 12px;float: left;width: 100%;margin: 0px;}
.b_info{color: red;}
.a_submit{border: solid 1px #5E6C77;padding: 3px 15px;background: #EEE;color: #E27A13;font-weight: bold;margin: 0px 4px;float: left;cursor: pointer;}
.a_close{float:right;color: #64707B;padding-right: 5px;text-decoration: underline;cursor: pointer;}
.btn_add{background-color: #F2F2F2;border: 1px #CCC solid;font-size: 11px;margin-left: 23px;cursor: pointer;}
.btn_add_drag{background-color: #F2F2F2;border: 1px #CCC solid;font-size: 11px;margin-left: 5px;cursor: pointer;}
.table_info_exe{color: #616D76;font-size: 11px;margin-top: 0px;}
.table_info_exe th{border: 1px solid #eee;line-height: 10px;padding: 7px;vertical-align: top;}
.table_info_exe td{border: 1px solid #DDD;line-height: 23px;padding: 7px;vertical-align: top;}
.ans_content{width: 285px;padding: 4px 4px;border: solid #616D76 1px;border-radius: 1px;color: #616D76;margin: 2px 5px;}
.ans_edit{padding: 4px 10px;background: #EEE;border: solid 1px;border-radius: 1px;cursor: pointer;}
.ans_del{padding: 4px 6px;background: #EEE;border: solid 1px;border-radius: 1px;cursor: pointer;}
.ans_add{padding: 5px 10px;background: #EEE;border: solid 1px;border-radius: 5px;cursor: pointer;margin-left: 24px;}
.ans_close{padding: 5px 9px;background: #EEE;border: solid 1px;border-radius: 5px;cursor: pointer;}
.add_action{float: left;padding: 0px 18px;cursor: pointer;background: #EEE;border: solid 1px;border-radius: 0px;height: 20px;line-height: 20px;margin: 5px 5px;}
</style>

<script>
//=============================================================
$('.ans_close').click(function (){
   $('.dv_add_action_invi').hide();
});

//=============================================================
$('#unit_select').change(function (){
   var iUnit =	$("#unit_select").val();
   if(iUnit == 1){$('#multi_choice').show();$('#drag').hide();$('#fill_word').hide();}
   if(iUnit == 2){$('#fill_word').show();$('#multi_choice').hide();$('#drag').hide();}
   if(iUnit == 3){$('#drag').show();$('#multi_choice').hide();$('#fill_word').hide();}
});

//=============================================================
function add_show(ans_id){
   $('#dv_add_action_invi_'+ans_id).show();
}

//=================ADD MULTI CHOICE TYPE=======================

function add_multi_choice(exe_id){
   if($('#question').val() == ""){
      alert("Bạn chưa nhập câu hỏi");
      return false;
   }
   if($('#ans_1').val() == ""){
      alert("Bạn chưa nhập câu trả lời : A");
      return false;
   }
   if($('#ans_2').val() == ""){
      alert("Bạn chưa nhập câu trả lời : B");
      return false;
   }
   if($('#ans_3').val() == ""){
      alert("Bạn chưa nhập câu trả lời : C");
      return false;
   }
   if($('#ans_4').val() == ""){
      alert("Bạn chưa nhập câu trả lời : D");
      return false;
   }

   var ans_1 = $('#ans_1').val();
   var ans_2 = $('#ans_2').val();
   var ans_3 = $('#ans_3').val();
   var ans_4 = $('#ans_4').val();
   var true_ans_1 = $('#rdo_1').val();
   var true_ans_2 = $('#rdo_2').val();
   var true_ans_3 = $('#rdo_3').val();
   var true_ans_4 = $('#rdo_4').val();
   var question = $('#question').val();
   var type_ques = $('#unit_select').val();
   var ans_true = $('#ans_true').val();
   $.ajax({
      type:'POST',
      dataType:'json',
      data:{
         exe_id:exe_id,
         ans_1:ans_1,
         ans_2:ans_2,
         ans_3:ans_3,
         ans_4:ans_4,
         true_ans_1:true_ans_1,
         true_ans_2:true_ans_2,
         true_ans_3:true_ans_3,
         true_ans_4:true_ans_4,
         question:question,
         ans_true:ans_true,
         type_ques:type_ques
      },
      url:'multi_choice.php',
      success:function(data){
      	if(data.err == ''){
      		alert(data.msg);
      		window.location.reload();
      	}else{
      		alert(data.err);
      	}}
   });
}

//==========================FILL WORD==========================
function add_drag(exe_id){
   if($('#ques_drag_head').val() == ""){
      alert("Bạn chưa nhập câu hỏi");
      return false;
   }
   if($('#ans_drag').val() == ""){
      alert("Bạn chưa nhập câu trả lời");
      return false;
   }

   var ans_drag = $('#ans_drag').val();
   var ques_head = $('#ques_drag_head').val();
   var ques_end = $('#ques_drag_end').val();
   var type_ques = $('#unit_select').val();
   $.ajax({
      type:'POST',
      dataType:'json',
      data:{
         exe_id:exe_id,
         ans_drag:ans_drag,
         ques_head:ques_head,
         ques_end:ques_end,
         type_ques:type_ques
      },
      url:'drag.php',
      success:function(data){
      	if(data.err == ''){
      		alert(data.msg);
      		window.location.reload();
      	}else{
      		alert(data.err);
      	}}
   });
}

//=============================================================

function add_drag_v(exe_id){
   if($('#ques_drag_v').val() == ""){
      alert("Bạn chưa nhập câu hỏi");
      return false;
   }
   if($('#ans_drag_v').val() == ""){
      alert("Bạn chưa nhập câu trả lời");
      return false;
   }

   var ans_drag = $('#ans_drag_v').val();
   var ques_drag = $('#ques_drag_v').val();
   var type_ques = $('#unit_select').val();
   $.ajax({
      type:'POST',
      dataType:'json',
      data:{
         exe_id:exe_id,
         ans_drag:ans_drag,
         ques_drag:ques_drag,
         type_ques:type_ques
      },
      url:'drag_v.php',
      success:function(data){
      	if(data.err == ''){
      		alert(data.msg);
      		window.location.reload();
      	}else{
      		alert(data.err);
      	}}
   });
}

//=============================================================
function save_question(que_id){
   if(confirm("Bạn có chắc muốn sửa câu hỏi này không?")){
   var que_content = $('#ques_content_'+que_id).val();
	$.ajax({
		type:'POST',
		dataType:'json',
		data:{
		   que_id:que_id,
         que_content:que_content,
      },
		url:'edit_ans_ques.php',
		success:function(data){
			if(data.err == ''){
				alert(data.msg);
				window.location.reload();
			}else{
				alert(data.err);
			}
      }
   });
}return false;}

//-------------------------------------------------

function save_explain(que_id){
   var que_exp = $('#ques_exp_'+que_id).val();
	$.ajax({
		type:'POST',
		dataType:'json',
		data:{
		   que_id:que_id,
         que_exp:que_exp,
      },
		url:'edit_explain.php',
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

//=============================================================
function del_question(que_id){
   if(confirm("Bạn có chắc muốn xóa câu hỏi này không?")){
	$.ajax({
		type:'POST',
		dataType:'json',
		data:{que_id:que_id},
		url:'del_ans_ques.php',
		success:function(data){
			if(data.err == ''){
				alert(data.msg);
				window.location.reload();
			}else{
				alert(data.err);
			}
      }
   });
}return false;}

//=============================================================
function save_answers(ans_id){
   if(confirm("Bạn có chắc muốn sửa câu hỏi này không?")){
   var ans_content = $('#ans_content_'+ans_id).val();
	$.ajax({
		type:'POST',
		dataType:'json',
		data:{
		   ans_id:ans_id,
         ans_content:ans_content,
      },
		url:'edit_ans_ques.php',
		success:function(data){
			if(data.err == ''){
				alert(data.msg);
				window.location.reload();
			}else{
				alert(data.err);
			}
      }
   });
}return false;}

//=============================================================
function del_answers(ans_id){
   if(confirm("Bạn có chắc muốn xóa câu trả lời này không?")){
	$.ajax({
		type:'POST',
		dataType:'json',
		data:{ans_id:ans_id},
		url:'del_ans_ques.php',
		success:function(data){
			if(data.err == ''){
				alert(data.msg);
				window.location.reload();
			}else{
				alert(data.err);
			}
      }
   });
}return false;}

//=============================================================
function set_true(ans_id,ans_ques_id){
   $.ajax({
      type:'POST',
      dataType:'json',
      data:{
      ans_id:ans_id,
      ans_ques_id:ans_ques_id
      },
      url:'set_true.php',
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

//=============================================================
function add_ans_multi(que_id){
var add_ans_content = $('#add_ans_content_'+que_id).val();
$.ajax({
   type:'POST',
   dataType:'json',
   data:{que_id:que_id,
         add_ans_content:add_ans_content},
   url:'add_ans_ques.php',
   success:function(data){
   	if(data.err == ''){
   		alert(data.msg);
   		window.location.reload();
   	}else{
   		alert(data.err);
   	}}
   });
}

function check_rdo_true(numtrue){
   for(var i=0;i < 5;i++){
      $('#rdo_'+i).attr("value","0");
   }
   $('#rdo_'+numtrue).attr("value","1");
}
</script>
