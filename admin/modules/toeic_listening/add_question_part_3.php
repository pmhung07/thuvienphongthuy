<?
include("inc_security.php");
checkAddEdit("add");
//khai báo biến
$fs_redirect 	= base64_decode(getValue("url","str","GET",base64_encode("listing.php")));
$record_id 		= getValue("record_id");
$fs_errorMsg	= '';
$fs_action			= getURL();
$add					= "add.php";
$listing				= "listing.php";
/*
Call class form:
1). Ten truong
2). Ten form
3). Kieu du lieu , 0 : string , 1 : kieu int, 2 : kieu email, 3 : kieu double, 4 : kieu hash password
4). Noi luu giu data  0 : post, 1 : variable
5). Gia tri mac dinh, neu require thi phai lon hon hoac bang default
6). Du lieu nay co can thiet hay khong
7). Loi dua ra man hinh
8). Chi co duy nhat trong database
9). Loi dua ra man hinh neu co duplicate
*/

//====== get variable =====//
$ans_1	   = getValue("ans_1","str","POST","");
$ans_2	   = getValue("ans_2","str","POST","");
$ans_3	   = getValue("ans_3","str","POST","");
$ans_4	   = getValue("ans_4","str","POST","");
$ans_true   = getValue("ans_true","int","POST",0);
$question   = getValue("question","str","POST","");
$arr_ans    = array($ans_1,$ans_2,$ans_3,$ans_4);
$toque_part = 3;
//=========================//
$myform = new generate_form();
$myform->add("toque_toty_id" , "record_id" , 1 , 1 , 0 , 1,"" , 0 , "");
$myform->add("toque_content" , "question" , 0 , 1 , "" , 0,"" , 0 , "");
$myform->add("toque_part" , "toque_part" , 1 , 1 , 3 , 0,"" , 0 , "");
$myform->add("toque_order" , "toque_order" , 1 , 0 , 0 , 0,"" , 0 , "");
$myform->addTable("toeic_questions");
   //Get action variable for add new data
   $action = getValue("action", "str", "POST", "");
   if($action == "execute"){
      $fs_errorMsg .= $myform->checkdata();
      if($fs_errorMsg == ""){
         $upload		= new upload("toque_audio", $data_path, $fs_extension, $fs_filesize);
         $filename	= $upload->file_name;
         if($filename != ""){
         	$myform->add("toque_audio","filename",0,1,0,0);
         }
         $fs_errorMsg .= $upload->show_warning_error();

         if($fs_errorMsg == ""){
         	$myform->removeHTML(0);
         	$db_insert 	= new db_execute_return();
         	$last_exe_id = $db_insert->db_execute($myform->generate_insert_SQL());
            if($last_exe_id>0){
               $exe_id = $last_exe_id;
               for($i=0;$i<4;$i++){
                  $ans_form = new generate_form();
                  $ans_form->add("totan_ques_id" , "exe_id" , 1 , 1 , 0 , 1,"" , 0 , "");
                  $ans = $arr_ans[$i];
                  $ans_form->add("totan_content" , "ans" , 0 , 1 , "" , 1,"Bạn chưa nhập câu trả lời" , 0 , "");
                  $ans_form->addTable("toeic_answers");
            		$ans_form->removeHTML(0);
            		$db_insert_ans 	= new db_execute_return();
            		$last_exe_id = $db_insert_ans->db_execute($ans_form->generate_insert_SQL());
                  unset($db_insert_ans);
               }
            }
         }
      }
   }
   $myform->addFormname("add_new");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<?=$load_header?>
<?
$myform->checkjavascript();
$myform->evaluate();
$fs_errorMsg .= $myform->strErrorField;
?>
</head>
<body>
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
            </li>
            <li style="margin: 5px 0px;"><b>B. </b>
               <input type="text" name="ans_2" id="ans_2" class="form_control" style="width:205px;" value=""/>
            </li>
            <li style="margin: 5px 0px;"><b>C. </b>
               <input type="text" name="ans_3" id="ans_3" class="form_control" style="width:205px;" value=""/>
            </li>
            <li style="margin: 5px 0px;"><b>D. </b>
               <input type="text" name="ans_4" id="ans_4" class="form_control" style="width:205px;" value=""/>
            </li>
         </ul>
      </td>
   </tr>
   <?=$form->getFile("Tải Audio", "toque_audio", "toque_audio", "Tải ảnh", 0, 30, "", "")?>
   <?=$form->text("Thứ tự", "toque_order", "toque_order", $toque_order, "Thứ tự", 0, 40, "", 255, "", "", "")?>
	<?=$form->button("submit" . $form->ec . "reset", "submit" . $form->ec . "reset", "submit" . $form->ec . "reset", "Cập nhật" . $form->ec . "Đóng cửa sổ", "Cập nhật" . $form->ec . "Đóng cửa sổ", 'style="background:url(' . $fs_imagepath . 'button_1.gif) no-repeat"' . $form->ec . 'style="background:url(' . $fs_imagepath . 'button_2.gif)" onclick="window.parent.tb_remove()"', "");?>
	<?=$form->hidden("action", "action", "execute", "");?>
   <?
   $form->close_table();
   $form->close_form();
   unset($form);
   ?>
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
         $db_ques_select   = new db_query("SELECT * FROM  toeic_questions WHERE toque_toty_id = ". $record_id ." AND toque_part = 3 ORDER BY toque_order");
         $i = 0;
         while($row_ques = mysqli_fetch_assoc($db_ques_select->result)){
         $i++;
         ?>
         <tr style="background: #A9BAD0;">
            <td align="center"><?=$i?></td>
            <td>
               <input size="30" class="ans_content" id="ques_content_<?=$row_ques['toque_id']?>" name="ans_content" value="<?=$row_ques['toque_content']?>"/>
               <a class="ans_edit" onclick="save_question(<?=$row_ques['toque_id']?>)">Save</a>
               <a class="ans_del" onclick="del_question(<?=$row_ques['toque_id']?>)">Delete</a>
               <input id="order_ques_<?=$row_ques['toque_id']?>" style="text-align: center;width: 30px;background: #eee;margin: 7px 0px 5px 6px;height: 12px;float: left;;color: red;font-weight: bold;" type="text" value="<?=$row_ques['toque_order']?>" />
               <a onclick="order_ques(<?=$row_ques['toque_id']?>)" class="a_score" style="float: left;cursor: pointer;">Order</a>
               <a style="padding:5px 0px 5px 6px;text-decoration:none;float:left;" title="Add audio" class="thickbox noborder a_detail" href="ques_audio.php?iQues=<?=$row_ques['toque_id']?>'&iPara=<?=$iPara?>'&record_id=<?=$record_id?>'&url=<?=base64_encode(getURL())?>'&TB_iframe=true&amp;height=350&amp;width=1000">
                  <b style="background: none repeat scroll 0 0 <?=$row_ques['toque_audio'] == "" ? '#1D5691' : "blueviolet"; ?>;color: white;padding: 2px 10px;">Update Audio & Image</b>
               </a>
            </td>
            <td>
               <?
               $db_ans_select = new db_query("SELECT * FROM toeic_answers
                                              INNER JOIN toeic_questions ON totan_ques_id = toque_id
                                              WHERE totan_ques_id  = ". $row_ques["toque_id"]);
               while($row_ans = mysqli_fetch_assoc($db_ans_select->result)){
               ?>
                  <input style="width: 325px!important;" size="30" id="ans_content_<?=$row_ans['totan_id']?>" class="ans_content" name="ans_content" value="<?=$row_ans['totan_content']?>"/>
                  <input type="radio" <?=($row_ans['totan_true'] == 1)? "checked=''":""?> class="rdo_check_true" onclick="set_true(<?=$row_ans['totan_id']?>,<?=$row_ques['toque_id']?>)" id="ans_ques_<?=$row_ans['totan_id']?>" name="ans_<?=$row_ques['toque_id']?>" value=""/>
                  <a class="ans_edit" onclick="save_answers(<?=$row_ans['totan_id']?>)">Save</a>
               <?}unset($db_ans_select);?>
            </td>
         </tr>
         <?}unset($db_ques_select);?>
      </table>
   </div>
</body>
</html>
<style>
.a_detail{padding: 0px 13px;border: solid 1px;background: #EEE;text-decoration: none;margin: 6px 4px;color: #8C99A5;float: left;height: 18px;line-height: 18px;}
#wr_list_answer{float: left;margin:10px 0px 30px 30px;border-right: solid 1px #eee;border: solid 1px #eee;width: 940px;}
#list_title{width: 933px;float: left;background: #E0EBF6;padding: 4px 0px 4px 7px;color: #616D76;font-weight: bold;text-align: center;height: 15px;line-height: 15px;}
#wr_detail{width: 100%;height: 100%;}
#detail_title{width: 490px;float: left;background: #eee;color: #616D76;font-weight: bold;height: 23px;line-height: 23px;}
#wr_detail_info{float: left;width: 100%;border-bottom: solid 1px #eee;}
#wr_detail_answer{float: left;margin:10px 0px 0px 12px;border-right: solid 1px #eee;border: solid 1px #eee;width: 490px;}
#wr_detail_media{float: left;margin:10px 0px 0px 11px;border-right: solid 1px #eee;border: solid 1px #eee;width: 495px;}
#wr_detail_left{float: left;width: 420px;}
#detail_content{float: left;width: 406px;padding:5px 0px 5px 4px;border-bottom: dotted 1px #eee;}
#multi_choice{float: left;width: 485px;height:243px;padding:5px 0px 5px 4px;overflow: scroll;}
#drag{float: left;width: 485px;padding: 5px 0px 5px 4px;}
#fill_word{float: left;width: 485px;padding: 5px 0px 5px 4px;height:243px;overflow: scroll;}
#media{float: left;width: 490px;padding:5px 0px 5px 4px;}
#content_multi_choice{float: left;width: 406px;padding-left: 4px;}
#dv_add_action{float: left;width: 100%;}
#im_note{float: left;width: 406px;padding:5px 0px 5px 4px;}
#im_note p{float: left;width: 406px;padding: 5px 0px 0px 4px;color: red;margin: 0px;}
#para_detail{float: left;padding-left: 10px;width: 475px;height: 250px;overflow: scroll;}
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
.ans_add{padding: 4px 12px;background: #EEE;border: solid 1px;border-radius: 1px;cursor: pointer;margin-left:0;}
.med_deny{padding: 2px 5px;background: #EEE;border: solid 1px;border-radius: 5px;cursor: pointer;}
.ans_close{padding: 4px 10px;background: #EEE;border: solid 1px;border-radius: 1px;cursor: pointer;}
.media_deny{padding: 4px 9px;background: #EEE;border: solid 1px;border-radius: 5px;cursor: pointer;}
.add_action{background: none repeat scroll 0 0 #EEEEEE;border: 1px solid;border-radius: 1px;cursor: pointer;float: left;height: 18px;line-height: 17px;margin-bottom: 3px;margin-left: 20px;margin-top: 5px;padding: 0 18px;}
.p_dt_title{float: left;padding-left: 10px;margin: 0px;}
.sl_list_media{border: solid 1px #616D76;padding: 2px 2px;border-radius: 4px;margin: 5px 0px;}
.a_score{margin: 7px 0px 5px 0px;text-decoration: no;background: green;height: 18px;color: white;line-height: 18px;padding: 0px 5px;}
</style>
<script>
function check_rdo_true(numtrue){
for(var i=0;i < 5;i++){
   $('#rdo_'+i).attr("value","0");
}
$('#rdo_'+numtrue).attr("value","1");
}
</script>
<?include("ajax.php");?>