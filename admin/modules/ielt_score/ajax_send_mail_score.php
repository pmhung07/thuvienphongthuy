<?
require_once("inc_security.php");
require_once("class.phpmailer.php");
require_once("class.smtp.php");
require_once("send_mail.php");
?>
<?
$tesr_id = getValue("record_id","int","POST",0);
$time = time();
$time_cv =  date("d/m/Y",$time);

//========== variable json=========//
$msg   = "";
$err 	 = "";
$json  = array();
$fs_errorMsg = "";
//====== get variable answers=====//
$db_ex = new db_execute("UPDATE ielts_result SET ielt_teach_success = 1 WHERE ielr_id = " . $tesr_id);
if($isSuccess == true){
   $msg = "Đã chấm xong";   
}else{
   $err = "Có lỗi xảy ra trong quá trình gửi mail!";
}
//==================
$json['msg'] = $msg;
$json['err'] = $err;
echo json_encode($json);
?>