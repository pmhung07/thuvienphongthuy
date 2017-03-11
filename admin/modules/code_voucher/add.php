<?
include("inc_security.php");
checkAddEdit("add");

$fs_title			= $module_name . " | Thêm mới";
$fs_action			= getURL();
$fs_errorMsg		= "";
$add					= "add.php";
$listing				= "listing.php";
$after_save_data	= getValue("after_save_data", "str", "POST", "listing.php");
$fs_redirect		= $after_save_data;
$ielt_date        = time();
$sql = '1';

$action		 	 = getValue("action", "str", "POST", ""); 
$code_vou_uni	 = getValue("code_vou_uni", "str", "POST", ""); 
$code_vou_time	 = getValue("code_vou_time", "int", "POST", ""); 
$sum_voucher	 = getValue("sum_voucher", "int", "POST", ""); 
$cur_tume       = time();

//Check $action for insert new data
if($action == "execute"){
   if($code_vou_uni != "" && $code_vou_time != "" && $sum_voucher != ""){
      for($i = 1; $i <= $sum_voucher; $i++){
         $seri =  strtoupper($code_vou_uni.substr(md5(microtime()),rand(0,26),12));
         $db_listing 	= new db_query("SELECT code_vou_id FROM code_voucher WHERE code_vou_seri ='$seri'");
         if(!$row =	mysql_fetch_assoc($db_listing->result)){
            $sql  =  "INSERT INTO `code_voucher` (`code_vou_seri`, `code_vou_time`, `code_vou_uni` , `code_vou_creat`) VALUES ( '$seri', '$code_vou_time', '$code_vou_uni', $cur_tume);";
            $db_insert  =  new db_execute($sql);
            unset($db_insert);
         }
      } 
      redirect($fs_redirect);
   }else{
      $fs_errorMsg .= "Yêu cầu nhập đầy đủ thông tin!";
   }
}
   
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<?=$load_header?>
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
   <?=$form->errorMsg($fs_errorMsg)?>
   <?=$form->text("Nhập mã trường", "code_vou_uni", "code_vou_uni", $code_vou_uni, "Nhập mã trường", 1, 272, "", 255, "", "", "")?>
   <?=$form->text("Thời gian học", "code_vou_time", "code_vou_time", $code_vou_time, "Thời gian học", 1, 272, "", 255, "", "", "")?>
   <?=$form->text("Số lượng Voucher", "sum_voucher", "sum_voucher", $sum_voucher, "Số lượng Voucher", 1, 272, "", 255, "", "", "")?>
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