<?
include ("inc_security.php");
checkAddEdit("add");

$fs_action			= getURL();
//$fs_redirect		= $after_save_data;
$fs_errorMsg		= "";

$fs_redirect      = getValue("url","str","GET",base64_encode("listing.php"));
$record_id        = getValue("record_id","int","GET","");

//=====Question type=====/
/*
   QUETYPE: 1. Multi choice
            2. Fillword
            3. Drag and Drop
*/

$arr_type_question = array(-1 => "- Chọn dạng câu hỏi -" , 1 => "|-- Multi choice" , 2 => "|-- Fill word (Điền từ)" , 3 => "|-- Drag and drop (Kéo thả)");

//=====Media type=====/
//=====Question type=====/
/*
   QUEMEDIA: 1. Video
             2. Audio
             3. Flash    
   
*/
$arr_type_media = array(1 => "Video" , 2 => "Audio" , 3 => "Flash" , 5 => "Images");

//=====Get information 
$sql_course = "";
if($record_id >0){
   $sql_course = "SELECT * FROM " . $fs_table . " 
                  INNER JOIN skill_content ON exe_skl_cont_id = skl_cont_id
                  INNER JOIN skill_lesson ON skl_cont_les_id = skl_les_id 
                  WHERE exe_id = ".$record_id;
   $db_course_select = new db_query($sql_course);
}

//=====Get list question=====/
$total			   = new db_count("SELECT 	count(*) AS count FROM questions WHERE que_exe_id = ".$record_id);
$db_ques_select   = new db_query("SELECT * FROM questions WHERE que_type = 1 AND que_exe_id = ".$record_id ." ORDER BY que_order ASC");
$total_row        = mysql_num_rows($db_ques_select->result);

//=====Get media=====/
$db_media_select = new db_query("SELECT * FROM media_exercies WHERE media_exe_id = " . $record_id);  
while($row_media = mysql_fetch_assoc($db_media_select->result)){
   $arr_list_media[$row_media['media_id']] = $row_media['media_des'];
}unset($db_media_select);

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
         <?//======================================INFO====================================================?>
         
         <div id="wr_detail_info">
            <?if($row =	mysql_fetch_assoc($db_course_select->result)){?>
            <p class="p_info">
               <b>Bài học : </b><b class="b_info"><?=$row["skl_les_name"]?></b>
               <b> -  Content : </b><b class="b_info"><?=$row["skl_cont_title"]?></b>
               <? echo'<a style="text-decoration:none" title="Hướng dẫn" class="thickbox noborder" href="tutorial.php?url='. base64_encode(getURL()) . '&TB_iframe=true&amp;height=300&amp;width=300" /><b> - Hướng dẫn</b></a>';?>
            </p>     
            <?}unset($db_course_select)?>
         </div>
          
         <?//======================================ANSWER==================================================?>
        
         <div id="wr_detail_answer">
            <div id="detail_title">
               <select class="form_control" style="width: 450px;" name="unit_select" id="unit_select">
                  <?foreach($arr_type_question as $id=>$name){?>
   						<option value="<?=$id?>"><?=$name?></option>
   					<?}?>
               </select>
            </div>
            
            <?//=================================MULTI CHOICE==============================================?>
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
            
            <?//===================================Drag & Fillword==========================================?>
            
            <div id="fill_word" style="display: none;">
               <? echo'<a style="padding:5px 0px 5px 6px;text-decoration:underline;float:left;" title="Nhập đoạn văn" class="thickbox noborder" href="fill_word.php?&record_id='. $record_id .'&que_type	= 2&url='. base64_encode(getURL()) . '&TB_iframe=true&amp;height=350&amp;width=950" /><b style="padding-left:6px;">Nhập đoạn văn</b></a>';?>
               <?/*
               $form = new form();
            	$form->create_form("add", $fs_action, "post", "multipart/form-data",'onsubmit="validateForm(); return false;"');
            	$form->create_table();
               ?>
               <tr>
                  <td class="form_name">Nhập câu hỏi (Phần đầu):</td>
                  <td><input type="text" name="question" id="ques_drag_head" class="form_control" style="width:230px;" value=""/></td>
               </tr>
               <tr>
                  <td class="form_name">Nhập câu trả lời :</td>
                  <td>
                     <input type="text" name="ans_drag" id="ans_drag" class="form_control" style="width:230px;" value=""/>
                  </td>
               </tr>
               <tr>
                  <td class="form_name">Nhập câu hỏi (Phần cuối):</td>
                  <td><input type="text" name="question" id="ques_drag_end" class="form_control" style="width:230px;" value=""/></td>
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
                  <td><textarea name="question_v" id="ques_drag_v" class="form_control" style="width: 230px;height: 70px;"></textarea></td>
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
               <? echo'<a style="padding:5px 0px 5px 6px;text-decoration:underline;float:left;" title="Nhập đoạn văn" class="thickbox noborder" href="fill_word.php?&record_id='. $record_id .'&que_type	= 3&url='. base64_encode(getURL()) . '&TB_iframe=true&amp;height=350&amp;width=950" /><b style="padding-left:6px;">Nhập đoạn văn</b></a>';?>
            </div>
            
            <!--<div id="im_note">
               <p>• Mỗi bài tập chỉ được nhập một dạng câu hỏi .</p>
               <p>• Không sửa "_____" khi sửa nội dung câu hỏi .</p>
            </div>-->
         </div>
         
         <?//=========================================Media====================================================?>
         
         <?
         $type_id	   = getValue("med_select","int","POST",0);
         $type_des	= getValue("med_des","str","POST","");         
         
         $myform_med = new generate_form();
         $myform_med->add("media_exe_id" , "record_id" , 1 , 1 , 0 , 1,"" , 0 , "");
         $myform_med->add("media_type" , "type_id" , 1 , 1 , 0 , 1,"Bạn chưa chọn kiểu media" , 0 , "");
         $myform_med->add("media_des" , "type_des" , 0 , 1 , "" , 1,"Bạn chưa nhập mô tả" , 0 , "");
         $myform_med->addTable("media_exercies");
         $action  = getValue("action", "str", "POST", ""); 
         if($action == "execute_media"){
            $fs_errorMsg .= $myform_med->checkdata();
            if($fs_errorMsg == ""){
               $upload		= new upload("media_name",$fs_filepath_data,$fs_extension, $fs_filesize);
               $filename	= $upload->file_name;
            	if($filename != ""){
            		$myform_med->add("media_name","filename", 0, 1, "", 0, "", 0, "");
                  foreach($arr_resize as $type => $arr){
               	resize_image($fs_filepath_data, $filename, $arr["width"], $arr["height"], $arr["quality"], $type);
                  }
            	}
            	$fs_errorMsg .= $upload->show_warning_error();       
            	if($fs_errorMsg == ""){
            		//Insert to database
            		$myform_med->removeHTML(0);
            		$db_insert 	= new db_execute_return();
            		$last_id		= $db_insert->db_execute($myform_med->generate_insert_SQL());
            		echo("<script>alert('Thêm dữ liệu thành công');window.location.reload();</script>");
            	}
            }
         }     
         $myform_med ->addFormname("add_new");
         $myform_med ->evaluate();
         $myform_med ->checkjavascript(); 
         $fs_errorMsg .= $myform_med->strErrorField;
         ?>   
         <div id="wr_detail_media">
            <div id="detail_title">
               <p class="p_dt_title">Upload Media cho câu hỏi</p>
               <a onclick="inout()" id="break" class="a_close hide">Open</a>
            </div>
            <div id="media" style="display: none;">
               <?
               $form_med = new form();
               $form_med->create_form("add", $fs_action, "post", "multipart/form-data",'onsubmit="validateForm(); return false;"');
            	$form_med->create_table();
               ?>    
               	<?=$form_med->errorMsg($fs_errorMsg)?>
                  <?=$form_med->select("Chọn kiểu media ","med_select","med_select",$arr_type_media,"","Chọn dạng câu hỏi",0,"","");?> 
                  <?=$form_med->text("Nhập mô tả","med_des","med_des","","Tên Video",0,204,"",255,"","","")?>
                  <?=$form_med->getFile("Chọn file upload","media_name","media_name","Chọn file upload",0,30,"multiple='multiple'", "")?>
                  <?=$form_med->button("submit" . $form_med->ec . "reset", "submit" . $form_med->ec . "reset", "submit" . $form_med->ec . "reset", "Cập nhật" . $form_med->ec . "Làm lại", "Cập nhật" . $form_med->ec . "Làm lại", 'style="background:url(' . $fs_imagepath . 'button_1.gif) no-repeat"' . $form_med->ec . 'style="background:url(' . $fs_imagepath . 'button_2.gif)"', "");?>
         	      <?=$form_med->hidden("action", "action", "execute_media", "");?>
            	<?
            	$form_med->close_table();
               $form_med->close_form();
               unset($form_med);
            	?>
               <? echo'<a style="padding:5px 0px 5px 6px;text-decoration:underline;float:left;" title="Nhập đoạn văn" class="thickbox noborder" href="fill_word_media.php?&record_id='. $record_id .'&url='. base64_encode(getURL()) . '&TB_iframe=true&amp;height=350&amp;width=950" /><b style="padding-left:6px;">Nhập đoạn văn</b></a>';?>
            </div>
         </div>
         
         <?//=======================================List Media===============================================?>
         <div id="wr_list_answer"> 
            <div id="list_title">Danh sách Media</div>
            <table class="table_info_exe">
               <tr style="background-color: #eee;">
                  <th width="30">STT</th>
                  <th width="30">ID</th>
                  <th width="460">Media</th>
                  <th width="200">Dạng Media</th>
                  <th width="400">File</th>
                  <th width="30">Xóa</th>
               </tr>
               <?
               $db_media_select = new db_query("SELECT * FROM media_exercies WHERE media_exe_id = " . $record_id);  
               $i = 0;
               while($row_media = mysql_fetch_assoc($db_media_select->result)){
               $i++;
               ?>
               <tr>
                  <td style="background: #A9BAD0;" align="center"><?=$i?></td>     
                  <td style="background: #A9BAD0;" align="center"><b style="color: red;"><?=$row_media['media_id']?></b></td>    
                  <td style="background: #A9BAD0;" align="center"><?=$row_media['media_des']?></td> 
                  <td style="background: #A9BAD0;" align="center">
                     <?if($row_media['media_type'] == 1){echo "Video";}?>
                     <?if($row_media['media_type'] == 2){echo "Audio";}?>
                     <?if($row_media['media_type'] == 3){echo "Flash";}?>
                     <?if($row_media['media_type'] == 4){echo "Paragraph";}?>
                     <?if($row_media['media_type'] == 5){echo "Images";}?>
                  </td>   
                  <td style="background: #A9BAD0;" align="center">
                     <?/*
                        if($row_media['media_type'] == 1 || $row_media['media_type'] == 2){
                        $url = $fs_filepath_data.$row_media['media_name'];
                        loadmedia($url,100,100);
                        }else{
                           echo '<a title="View Flash" class="thickbox noborder a_detail" href="view_flash.php?url='. base64_encode(getURL()) . '&game_url=' . $row_media['media_name'] . '&TB_iframe=true&amp;height=450&amp;width=750" /><b>View Flash</b></a>';
                        }
                     */?>
                     <?
                     $url = $fs_filepath_data.$row_media['media_name'];
                     checkmedia_exe_para($row_media['media_type'],$url,$row_media['media_id']);
                     ?>
                  </td>   
                  <td style="background: #A9BAD0;" align="center"><a class="media_deny" onclick="deny_media(<?=$row_media['media_id']?>)">Xóa</a></td>       
               </tr>
               <?}unset($db_media_select)?>
         </table>    
         </div>
         
         <?//===============================================List Question=====================================?>
         
         <div id="wr_list_answer">       
            <div id="list_title">Danh sách câu hỏi</div>
            <table class="table_info_exe">
               <tr style="background-color: #eee;">
                  <th width="30">STT</th>
                  <th width="500">Nội dung câu hỏi</th>
                  <th width="500">Nội dung câu trả lời</th>
               </tr>            
               <?
               $i = 0;
               while($row_ques = mysql_fetch_assoc($db_ques_select->result)){
               $i++;
               $media_id = $row_ques['que_media_id'];
               ?>
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
                     <!---->
                     <div class="chk_media_box_<?=$row_ques['que_id']?>" style="padding-left: 1px;height: 45px;">
                     <input type="text" id="choose_media_<?=$row_ques['que_id']?>" value="<?=$row_ques['que_media_id']?>" />
                     <a onclick="choose_med_1(<?=$row_ques['que_id']?>)" class="a_score" style="margin-left: 5px;cursor: pointer;background: green;color: white;font-size: 11px;padding: 3px;">Choose media</a>  		
                     <?/*
                     $i = 0;
                     foreach($arr_list_media as $id=>$name){
                     $i++;   
                     ?>
                        <input class="count_check" type="checkbox" id="true_mul_<?=$row_ques['que_id']?>_<?=$i?>" name="radio_ans_<?=$row_ques['que_id']?>_<?=$i?>" value="<?=$id?>"/> <?=cut_string($name,8)?>
                        <input id="hd_media_<?=$i?>" type="hidden" value="<?=$id?>" />
                     <?}*/?>
                     </div>
                     <!----->
                     <input id="order_ques_<?=$row_ques['que_id']?>" style="margin-left: 4px;text-align: center;width: 20px;background: #eee;height: 13px;color: red;font-weight: bold;" type="text" value="<?=$row_ques['que_order']?>" />
                     <a onclick="order_ques(<?=$row_ques['que_id']?>)" class="a_score" style=";cursor: pointer;background: green;color: white;font-size: 11px;padding: 3px;">Order</a>  		
                  </td>
                  <td style="background: #A9BAD0;">
                     <?
                     $db_ans_select = new db_query("SELECT * FROM answers 
                                                    INNER JOIN questions ON ans_ques_id = que_id 
                                                    WHERE ans_ques_id  = ". $row_ques["que_id"]);  
                     while($row_ans = mysql_fetch_assoc($db_ans_select->result)){
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
               $db_ans_select = new db_query("SELECT * FROM questions WHERE que_type = 2 AND que_exe_id  = ". $record_id ." ORDER BY que_order ASC");  
               $i = 0;
               while($row_ans = mysql_fetch_assoc($db_ans_select->result)){
               $i++;
               ?>
               <tr>
                  <td colspan="4">
                  <input type="text" id="choose_media_<?=$row_ans['que_id']?>" value="<?=$row_ans['que_media_id']?>" />
                  <a onclick="choose_med_1(<?=$row_ans['que_id']?>)" class="a_score" style="margin-left: 5px;cursor: pointer;background: green;color: white;font-size: 11px;padding: 3px;">Choose media</a>  		
                  <a class="med_deny" onclick="deny_med(<?=$row_ans['que_id']?>)">Hủy</a>
                  <input id="order_ques_<?=$row_ans['que_id']?>" style="text-align: center;width: 20px;height: 15px;margin: 0px 5px;background: #eee;height: 13px;color: red;font-weight: bold;" type="text" value="<?=$row_ans['que_order']?>" />
                  <a onclick="order_ques(<?=$row_ans['que_id']?>)" class="a_score" style=";cursor: pointer;background: green;color: white;font-size: 11px;padding: 3px;">Order</a>  		
                  </td>
               </tr>
               <tr>
                  <td style="background: #A9BAD0;" align="center"><?=$i?></td> 
                  <td bgcolor="white" style="background:white;">
                     <?=str_replace("|","___",$row_ans["que_content"])?>
                  </td>
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
               $db_ans_select = new db_query("SELECT * FROM questions WHERE que_type = 3 AND que_exe_id  = ". $record_id ." ORDER BY que_order ASC");  
               $i = 0;
               while($row_ans = mysql_fetch_assoc($db_ans_select->result)){
               $i++;
               ?>
               <tr>
                  <td colspan="4">
                  <input type="text" id="choose_media_<?=$row_ans['que_id']?>" value="<?=$row_ans['que_media_id']?>" />
                  <a onclick="choose_med_1(<?=$row_ans['que_id']?>)" class="a_score" style="margin-left: 5px;cursor: pointer;background: green;color: white;font-size: 11px;padding: 3px;">Choose media</a>  		
                  <input id="order_ques_<?=$row_ans['que_id']?>" style="text-align: center;width: 20px;background: #eee;height: 15px;margin: 0px 5px;color: red;font-weight: bold;" type="text" value="<?=$row_ans['que_order']?>" />
                  <a onclick="order_ques(<?=$row_ans['que_id']?>)" class="a_score" style=";cursor: pointer;background: green;color: white;font-size: 11px;padding: 3px;">Order</a>  		
                  </td>
               </tr>
               <tr>
                  <td style="background: #A9BAD0;" align="center"><?=$i?></td> 
                  <td bgcolor="white" style="background: white;">
                     <?=str_replace("|","___",$row_ans["que_content"])?>
                  </td>
                  <td style="background: #A9BAD0;" align="center"><a class="text" href="edit_fill_word.php?que_id=<?=$row_ans["que_id"]?>&record_id=<?=$record_id?>&returnurl=<?=base64_encode(getURL())?>"><img src="<?=$fs_imagepath?>edit.png" alt="EDIT" border="0"/></a></td>
                  <td style="background: #A9BAD0;" align="center"><img src="<?=$fs_imagepath?>delete.gif" alt="DELETE" border="0" onClick="if (confirm('Are you sure to delete?')){ window.location.href='del_fill_word.php?record_id=<?=$record_id?>&que_id=<?=$row_ans["que_id"]?>&returnurl=<?=base64_encode(getURL())?>'}" style="cursor:pointer"/></td>
               </tr>
               <?}?>
            </table>
         </div>
         
      </div>
   </div>
</body>

<style>
#wr_list_answer{float: left;margin:10px 0px 30px 11px;border-right: solid 1px #eee;border: solid 1px #eee;width: 940px;}
#list_title{width: 933px;float: left;background: #E0EBF6;padding: 4px 0px 4px 7px;color: #616D76;font-weight: bold;text-align: center;height: 15px;line-height: 15px;}
#wr_detail{width: 100%;height: 100%;}
#detail_title{width: 460px;float: left;background: #eee;color: #616D76;font-weight: bold;height: 23px;line-height: 23px;}
#wr_detail_info{float: left;width: 100%;border-bottom: solid 1px #eee;}
#wr_detail_answer{float: left;margin:10px 0px 0px 11px;border-right: solid 1px #eee;border: solid 1px #eee;width: 460px;}
#wr_detail_media{float: left;margin:10px 0px 0px 11px;border-right: solid 1px #eee;border: solid 1px #eee;width: 460px;}
#wr_detail_left{float: left;width: 420px;}
#detail_content{float: left;width: 406px;padding:5px 0px 5px 4px;border-bottom: dotted 1px #eee;}
#multi_choice{float: left;width: 406px;padding:5px 0px 5px 4px;}
#media{float: left;width: 406px;padding:5px 0px 5px 4px;height: 193px;}
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
.table_info_exe th{border: 1px solid #DDD;line-height: 10px;padding: 7px;vertical-align: top;}
.table_info_exe td{border: 1px solid #DDD;line-height: 23px;padding: 2px;vertical-align: top;}
.ans_content{width: 290px;padding: 4px 4px;border: solid #616D76 1px;border-radius: 1px;color: #616D76;margin: 2px 5px;}
.ans_edit{padding: 4px 10px;background: #EEE;border: solid 1px;border-radius: 1px;cursor: pointer;}
.ans_del{padding: 4px 6px;background: #EEE;border: solid 1px;border-radius: 1px;cursor: pointer;}
.ans_add{padding: 5px 10px;background: #EEE;border: solid 1px;border-radius: 5px;cursor: pointer;margin-left: 24px;}
.med_deny{padding: 3px 12px;background: #EEE;border: solid 1px;cursor: pointer;}
.ans_close{padding: 5px 9px;background: #EEE;border: solid 1px;border-radius: 5px;cursor: pointer;}
.media_deny{padding: 4px 9px;background: #EEE;border: solid 1px;border-radius: 5px;cursor: pointer;}
.add_action{float: left;padding: 0px 18px;cursor: pointer;background: #EEE;border: solid 1px;border-radius: 0px;height: 18px;line-height: 18px;margin-top: 5px;margin-left: 6px;}
.p_dt_title{float: left;padding-left: 10px;margin: 0px;}
.sl_list_media{border: solid 1px #616D76;padding: 2px 2px;width: 300px;margin: 5px 5px;}
.a_detail{padding: 3px 15px;border:solid 1px;background:#EEE;text-decoration:none;color: #8C99A5;}
</style>

<script>
//=============================================================
/*function choose_med(ques_id,med_id){
   var size_media = $('.chk_media_box_'+ques_id+' .count_check').size();
   for(i = 1;i <=size_media;i++){
      var media_+i : $('.chk_media_box_'+ques_id+' input[name=radio_ans_'+ques_id+'_'+i']:checked').val();
   }
   $.ajax({
   type:'POST',
   	dataType:'json',
   	data:{
   	   que_id:que_id
      },
   	url:'add_media_ques.php',
   	success:function(data){
   		if(data.err == ''){
   			alert(data.msg);	
   			window.location.reload();
   		}else{
   			alert(data.err);
   		}
      }
   }); 
   alert(size_media);
}*/
function choose_med_1(ques_id){
   var str_media = $('#choose_media_'+ques_id).val();
   $.ajax({
   type:'POST',
   	dataType:'json',
   	data:{
   	   que_id:ques_id,
         str_media:str_media
      },
   	url:'add_media_ques.php',
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

//=============================================================

function inout(){
   if($("#break").hasClass("hide")){
      $("#media").show();
      $("#break").removeClass("hide");
      $(".a_close").html("Close");
   }else{
      $("#media").hide();
      $("#break").addClass("hide");
      $(".a_close").html("Open");
   }
}   

//======================MULTI CHOICE===========================

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
   var ans_true = $('#ans_true').val();
   var type_ques = $('#unit_select').val();
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

//=========================DRAG AND DROP=======================

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

//=============================================================
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

function deny_media(media_id){
   if(confirm("Bạn có chắc muốn xóa Media này không?")){
	$.ajax({
		type:'POST',
		dataType:'json',
		data:{
		   media_id:media_id,
      },
		url:'delete_media.php',
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
   	}}
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

function deny_med(med_id){
   if(confirm("Bạn có chắc muốn hủy media của câu hỏi này không?")){
	$.ajax({
		type:'POST',
		dataType:'json',
		data:{med_id:med_id},
		url:'denymed.php',
		success:function(data){
			if(data.err == ''){
				alert(data.msg);	
				window.location.reload();
			}else{
				alert(data.err);
			}
      }
   });
}return false;}deny_med

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

//=============================================================

function add_media(que_id){
   var que_media_id = $('#media_select_'+que_id).val();
   if(que_media_id > 0){
   	$.ajax({
   		type:'POST',
   		dataType:'json',
   		data:{
   		   que_id:que_id,
            que_media_id:que_media_id,
         },
   		url:'add_media_ques.php',
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
}

function check_rdo_true(numtrue){
   for(var i=0;i < 5;i++){
      $('#rdo_'+i).attr("value","0");
   }
   $('#rdo_'+numtrue).attr("value","1");
}

function order_ques(record_id){
   var order_ques = $('#order_ques_'+record_id).val();
	$.ajax({
		type:'POST',
		dataType:'json',
		data:{
		   order_ques:order_ques,
         ques_id:record_id,
      },
		url:'order_ques.php',
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
