<?
include("inc_security.php");
checkAddEdit("edit");

$fs_title			= $module_name . " | Sửa đổi";
$fs_action			= getURL();
$fs_errorMsg		= "";
$base_url         =  $_SERVER['HTTP_HOST'];

$fs_redirect 	= base64_decode(getValue("url","str","GET",base64_encode("listing.php")));
$record_id 		= getValue("record_id");
$les_name      = getValue("les_name","str","GET","");
$les_url       = getValue("les_url","str","GET","");
$user_id       = getValue("user_id");
$lwr_status = 1;
//Call class menu - lay ra danh sach Category

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
   //$datetime =  date("Y-m-d g:i:s");
   $myform = new generate_form(); 
   $myform->add("lwr_content", "lwr_content", 0, 0, "", 0, "", 0, "");
   $myform->add("lwr_point", "lwr_point", 0, 0, "", 0, "", 0, "");
   $myform->add("lwr_comment", "lwr_comment", 0, 0, "", 0, "", 0, "");
   $myform->add("lwr_status", "lwr_status", 1, 1, 0, 0, "", 0, "");
	
	//Add table insert data
	$myform->addTable($fs_table);
   //Get action variable for add new data
   $action				= getValue("action", "str", "POST", "");
   //Check $action for insert new data
   if($action == "execute"){
   	//Check form data
   	$fs_errorMsg .= $myform->checkdata();      
		//Insert to database
		$myform->removeHTML(0);
		$db_ex = new db_execute($myform->generate_update_SQL($id_field, $record_id));
      //Notify
      user_notification($user_id,'Giáo viên đã chấm điểm bài làm của bạn tại bài học <a href="'.$les_url.'">'.$les_name.'</a>');
      
		redirect($fs_redirect); 
      unset($db_ex);		
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
//chuyển các trường thành biến để lấy giá trị thay cho dùng kiểu getValue
$myform->evaluate();
$fs_errorMsg .= $myform->strErrorField;
//lay du lieu cua record can sua doi
$db_data 	= new db_query("SELECT * FROM learn_writing_result
                            INNER JOIN skill_lesson ON learn_writing_result.lwr_skl_les_id=skill_lesson.skl_les_id
                            INNER JOIN skill_content ON skill_lesson.skl_les_id = skill_content.skl_cont_les_id
                            INNER JOIN learn_writing ON skill_content.skl_cont_id = learn_writing.learn_skl_cont_id
                            WHERE " . $id_field . " = " . $record_id);
if($row 		= mysql_fetch_assoc($db_data->result)){
   foreach($row as $key=>$value){
   	if($key!='lang_id' && $key!='admin_id') $$key = $value;
   }
}else{
		exit();
}

?>
</head>
<body topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0">
<? /*------------------------------------------------------------------------------------------------*/ ?>
<?=template_top($fs_title)?>
<? /*------------------------------------------------------------------------------------------------*/ ?>
   <p align="center" style="padding-left:10px;">
   <?
   $form = new form();
   $form->create_form("add", $fs_action, "post", "multipart/form-data",'onsubmit="validateForm(); return false;"');
   $form->create_table();
   ?>
   <?=$form->text_note('<strong style="text-align:center;">----------Sửa đổi Đề thi-----------</strong>')?>
   <?=$form->text_note('Những ô có dấu sao (<font class="form_asterisk">*</font>) là bắt buộc phải nhập.')?>
   <?=$form->errorMsg($fs_errorMsg)?>
   <?=$form->textarea("Câu hỏi", "learn_wr_ques", "learn_wr_ques", removeHTML($learn_wr_ques), "Nội dung", 1, 400, 80, 255, "", "", "")?>
   <?=$form->textarea("Nội dung trả lời thành viên", "lwr_content", "lwr_content", $lwr_content, "Nội dung", 1, 400, 200, 255, "", "", "")?>
   <?=$form->text("Chấm điểm", "lwr_point", "lwr_point", $lwr_point, "Chấm điểm", 1, 250, "", 255, "", "", "")?>
   <?=$form->textarea("Nhận xét giáo viên", "lwr_comment", "lwr_comment", $lwr_comment, "Nội dung", 1, 400, 200, 255, "", "", "")?>
   <?=$form->button("submit" . $form->ec . "reset", "submit" . $form->ec . "reset", "submit" . $form->ec . "reset", "Cập nhật" . $form->ec . "Làm lại", "Cập nhật" . $form->ec . "Làm lại", 'style="background:url(' . $fs_imagepath . 'button_1.gif) no-repeat"' . $form->ec . 'style="background:url(' . $fs_imagepath . 'button_2.gif)"', "");?>
   <?=$form->hidden("action", "action", "execute", "");?>
   <?
   $form->close_table();
   $form->close_form();
   unset($form);
   ?>
   </p>
<? /*------------------------------------------------------------------------------------------------*/ ?>
<?=template_bottom() ?>
<? /*------------------------------------------------------------------------------------------------*/ ?>
</body>
</html>