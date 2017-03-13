<?
include("inc_security.php");
checkAddEdit("edit");

$fs_title			= $module_name . " | Sửa đổi";
$fs_action			= getURL();
$fs_errorMsg		= "";

$fs_redirect 	= base64_decode(getValue("url","str","GET",base64_encode("listing.php")));
$record_id 		= getValue("record_id");
$les_name      = getValue("les_name","str","GET","");
$les_url       = getValue("les_url","str","GET","");
$user_id       = getValue("user_id");
$lsr_status = 1;
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
   $myform->add("lsr_point", "lsr_point", 0, 0, "", 0, "", 0, "");
   $myform->add("lsr_user_script", "lsr_user_script", 0, 0, "", 0, "", 0, "");
   $myform->add("lsr_comment", "lsr_comment", 0, 0, "", 0, "", 0, "");
   $myform->add("lsr_status", "lsr_status", 1, 1, 1, 0, "", 0, "");

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
$db_data 	= new db_query("SELECT * FROM learn_speak_result
                            INNER JOIN skill_lesson ON learn_speak_result.lsr_skl_les_id = skill_lesson.skl_les_id
                            INNER JOIN skill_content ON skill_lesson.skl_les_id = skill_content.skl_cont_les_id
                            WHERE " . $id_field . " = " . $record_id . " AND skl_cont_mark = 1 LIMIT 1");
if($row 		= mysqli_fetch_assoc($db_data->result)){
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
   <?=$form->errorMsg($fs_errorMsg)?>
   <tr>
      <td></td>
      <td style="font-size: 14px; font-weight: bold">Đề bài</td>
   </tr>
   <?
   if($row['skl_cont_title'] != ""){
   ?>
   <?=$form->text("","skl_cont_title","skl_cont_title",$skl_cont_title,"",0,255,"",255)?>
   <?
   }
   if($row['skl_content'] != ""){
   ?>
   <?=$form->textarea("","skl_content","skl_content",$skl_content,"",0,400,100)?>
   <?
   }
   //==============================================================//
   if($row['skl_cont_type'] == 1){
      $db_main = new db_query("SELECT * FROM main_lesson WHERE main_skl_cont_id = ".$row['skl_cont_id']." LIMIT 1");
      $row_main = mysqli_fetch_assoc($db_main->result);
      unset($db_main);
      $urlmedia = "../../../data/skill_content/".$row_main['main_media_url1'];
      if($row_main['main_media_type'] == 3){
         echo '<tr><td></td><td>';
         echo '<object width="500" height="282"><embed src="'.$urlmedia.'" width="790" height="282" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" menu="false" wmode="transparent"></embed></object>';
         echo '</td></tr>';
      }elseif($row_main['main_media_type'] == 1){
         echo '<tr><td></td><td>';
         echo '<img width="300px" height="220px" src="'.$urlmedia.'" />';
         echo '</td></tr>';
      }elseif($row_main['main_media_type'] == 2){
         echo '<tr><td></td><td>';
         loadmedia($urlmedia,400,300);
         echo '</td></tr>';
      }
   }elseif($row['skl_cont_type'] == 2){
      $db_gram = new db_query("SELECT * FROM grammar_lesson WHERE gram_skl_cont_id = ".$row['skl_cont_id']." LIMIT 1");
      $row_gram = mysqli_fetch_assoc($db_gram->result);
      unset($db_gram);
      $urlmedia = "../../../data/skill_content/".$row_gram['gram_media_url'];
      $urlaudio = "../../../data/skill_content/".$row_gram['gram_audio_url'];
      echo '<tr><td></td><td><p>'.$row_gram['gram_title'].'</p>';
      if($row_gram['gram_audio_url'] != ''){
         echo '<a class="media" href="'.$urlaudio.'"></a>';
      }elseif($row_gram['gram_media_url'] != ''){
         if($row_gram['gram_media_type'] == 1){
            echo '<img width="300px" height="220px" src="'.$urlmedia.'"/>';
         }elseif($row_gram['gram_media_type'] == 3){
            echo '<object width="500" height="282"><embed src="'.$urlmedia.'" width="790" height="282" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" menu="false" wmode="transparent"></embed></object>';
         }elseif($row_gram['gram_media_type'] == 2){
            loadmedia($urlmedia,400,300);
         }
      }
      echo '<p>'.$row_gram['gram_content_vi'].'</p>';
      echo '<p>'.$row_gram['gram_exam'].'</p>';
      echo '</td></tr>';
   }
   ?>

   <tr>
      <td class="form_name">
         Trả lời:
      </td>
      <td align="" width="">
         <div style="float: left;color: #164989;font-size: 11px;text-align: justify;padding-left: 10px;font-weight: bold;">
         <?
         $para = $row['lsr_audio'];
         if($para != ""){
            $url = $data_path.$para;
            echo'<a style="text-decoration:none" title="Audio" class="thickbox noborder a_detail" href="view_media.php?url='. base64_encode(getURL()) . '&url_media=' . $url . '&TB_iframe=true&amp;height=115&amp;width=420" /><b> View Audio</b></a>';
         }else{
            echo "Not Audio";
         }
         ?>
         </div><br />
      </td>
   </tr>
   <?=$form->textarea("Script bài nói","lsr_user_script","lsr_user_script",$lsr_user_script,"Nội dung",0,400,150,255,"","","")?>
   <?=$form->text("Chấm điểm", "lsr_point", "lsr_point", $lsr_point, "Chấm điểm", 0, 250, "", 255, "", "", "")?>
   <?=$form->textarea("Nhận xét giáo viên", "lsr_comment", "lsr_comment", $lsr_comment, "Nội dung", 0, 400, 150, 255, "", "", "")?>
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
<style>
.a_detail{padding: 2px 15px;border: solid 1px;background: #EEE;text-decoration: none;color: #164989;float: left;cursor: pointer;margin-bottom: 10px;}
</style>