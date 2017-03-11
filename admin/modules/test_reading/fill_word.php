<?
include ("inc_security.php");
$fs_title = $module_name . " | Thêm mới";
checkAddEdit("add");

$iPara            = getValue("iPara","int","GET","");
$record_id 		   = getValue("record_id");
$fs_action			= getURL();
$fs_errorMsg		= "";
$after_save_data  = getValue("after_save_data", "str", "POST", "add_exercises.php");
$fs_redirect      = $after_save_data;
$teque_content    = "Where would the sentence best fit?"; 
$action				= getValue("action", "str", "POST", "");
//----------------------------------

if($action == "execute"){
   $myform_ques = new generate_form();
   $myform_ques->add("teque_tec_id	" , "iPara" , 1 , 1 , 0 , 1,"" , 0 , "");
   $myform_ques->add("teque_content" , "teque_content" , 0 , 1 , "Where would the sentence best fit" , 1,"Bạn chưa nhập câu hỏi" , 0 , "");
   $myform_ques->add("teque_type" , "teque_type" , 1 , 1 , 3 , 1,"Bạn chưa nhập câu hỏi" , 0 , "");   
   if($fs_errorMsg == ""){
      $myform_ques->addTable("test_questions");
      $myform_ques->removeHTML(0);
      $db_insert 	= new db_execute_return();
      $last_exe_id = $db_insert->db_execute($myform_ques->generate_insert_SQL());
      if($last_exe_id>0){
         $exe_id = $last_exe_id;
         $myform = new generate_form();  
         $myform->add("fil_phrases", "fil_phrases", 0, 0, "", 1, "Bạn chưa nhập câu", 1, "");
         $myform->add("fil_paragraph", "fil_paragraph", 0, 0, "",1, "Bạn chưa nhập đoạn văn", 0, "");
         $myform->add("fil_position","fil_position",1,0,0,1,"Bạn chưa nhập vị trí",0,"");
         $myform->add("fil_tec_id", "iPara", 1, 1, 0, 0, "", 0, "");
         $myform->add("fil_teque_id" , "exe_id" , 1 , 1 , 0 , 1,"" , 0 , "");
         $myform->addTable("test_fillwords");
         $myform->removeHTML(0);
         $db_insert_ans 	= new db_execute_return();
         $last_exe_id = $db_insert_ans->db_execute($myform->generate_insert_SQL());
         $msg = "Thêm câu hỏi thành công";
         unset($db_insert_ans);
		   redirect("add_exercises.php?iPara=".$iPara."&record_id=".$record_id);
         $myform->addFormname("add_new");
         $myform->evaluate();
         $myform->checkjavascript();
         $fs_errorMsg .= $myform->strErrorField;
      }
   }else{
      $err = "Xảy ra lỗi trong quá trình thêm dữ liệu";
   }
}
//==========================================================
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<?=$load_header?>
</head>
<body>
<?=template_top($fs_title)?>
   <p align="center" style="padding-left:10px;">
      <?
      $form = new form();
      $form->create_form("add", $fs_action, "post", "multipart/form-data",'onsubmit="validateForm(); return false;"');
      $form->create_table();
      ?>
      <tr>
         <td width="" class="form_name">Nhập câu :</td>
         <td><input type="text" name="fil_phrases" id="fil_phrases" class="form_control" style="width:385px;" value=""/></td>
      </tr>
      <tr>
         <td width="" class="form_name">Tách đoạn :</td>
         <td width="800">
            <?
            $db_para_select = new db_query("SELECT * FROM test_content WHERE tec_id = " . $iPara);  
            if($row_para = mysql_fetch_assoc($db_para_select->result)){
            $para = $row_para["tec_content"];
            ?>
            <?=$form->wysiwyg("<font class='form_asterisk'>*</font> Thông tin đề thi", "fil_paragraph", $para , "../../resource/wysiwyg_editor/", 800, 450)?>
            <?
            }unset($db_para_select);
            ?>
         </td>
      <tr>
         <td width="" class="form_name">Nhập vị trí :</td>
         <td><input type="text" name="fil_position" id="fil_position" class="form_control" style="width:385px;" value=""/></td>
      </tr>
      <?=$form->button("submit" . $form->ec . "reset", "submit" . $form->ec . "reset", "submit" . $form->ec . "reset", "Cập nhật" . $form->ec . "Làm lại", "Cập nhật" . $form->ec . "Làm lại", 'style="background:url(' . $fs_imagepath . 'button_1.gif) no-repeat"' . $form->ec . 'style="background:url(' . $fs_imagepath . 'button_2.gif)"', "");?>
      <?=$form->hidden("action", "action", "execute", "");?>
      <?
      $form->close_table();
      $form->close_form();
      unset($form);
      ?>
   </p>   
   <?=template_bottom() ?>
</body>
</html>
