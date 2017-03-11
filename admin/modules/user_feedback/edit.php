<?
include("inc_security.php");
checkAddEdit("edit");

$fs_title			= $module_name . " | Sửa đổi";
$fs_action			= getURL();
$fs_errorMsg		= "";

$fs_redirect 	= base64_decode(getValue("url","str","GET",base64_encode("listing.php")));
$record_id 		= getValue("record_id");
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
   $myform = new generate_form();

   $myform->add("usefb_status","usefb_status",1,0,0,0,"",0,"");
	$myform->addTable($fs_table);
   
   $action = getValue("action", "str", "POST", "");
   if($action == "execute"){
   	$fs_errorMsg .= $myform->checkdata();
   	if($fs_errorMsg == ""){	   	
         $myform->removeHTML(0);
         $db_ex = new db_execute($myform->generate_update_SQL($id_field, $record_id));
         redirect($fs_redirect);	
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
//chuyển các trường thành biến để lấy giá trị thay cho dùng kiểu getValue
$myform->evaluate();
$fs_errorMsg .= $myform->strErrorField;
//lay du lieu cua record can sua doi
$db_data 	= new db_query("SELECT * FROM user_feedback
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
   <body>
   <? /*------------------------------------------------------------------------------------------------*/ ?>
   <?=template_top($fs_title)?>
   <? /*------------------------------------------------------------------------------------------------*/ ?>
      <p align="center" style="padding-left:10px;">
      <?
      $form = new form();
      $form->create_form("add", $fs_action, "post", "multipart/form-data",'onsubmit="validateForm(); return false;"');
      $form->create_table();
      ?>
      <?=$form->text_note('<strong style="text-align:center;">---------- Góp ý của người dùng -----------</strong>')?>
      <?=$form->errorMsg($fs_errorMsg)?>
      <tr>
         <td class="label">Email:</td>
         <td class="cont"><input type="text" value="<?=$row['usefb_email']?>" readonly="true" /></td>
      </tr>
      <tr>
         <td class="label">Thời gian gửi:</td>
         <td class="cont"><input type="text" value="<?=date('d/m/Y - h:i:s',$row['usefb_time'])?>" readonly="true"/></td>
      </tr>
      <tr>
         <td class="label">Tiêu đề</td>
         <td class="cont"><input type="text" value="<?=$row['usefb_title']?>" /></td>
      </tr>
      <tr>
         <td class="label">Nội dung:</td>
         <td class="cont"><textarea style="width: 400px; height: 150px" readonly="true"><?=$row['usefb_content']?></textarea></td>
      </tr>
      <?=$form->checkbox("Đã xử lý", "usefb_status", "usefb_status", 1 ,$usefb_status, "",0, "style:font-weight: bold;", "")?>  
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
<style type="text/css">
.label{font-size: 12px;font-weight: bold;text-align: right;}
.cont{font-size: 12px;}
.cont input{width: 250px;}
.form_name{font-size: 12px;font-weight: bold;}
textarea{font-size: 12px;}
</style>