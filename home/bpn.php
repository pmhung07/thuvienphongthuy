<?php
require_once("config.php");
//Baokim Payment Notification (BPN) Sample
//Lay thong tin tu Baokim POST sang
$req = '';
foreach ( $_POST as $key => $value ) {
	$value = urlencode ( stripslashes ( $value ) );
	$req .= "&$key=$value";
}
//thuc hien  ghi log cac tin nhan BPN
$myFile = $_SERVER['DOCUMENT_ROOT'] . '/logs/bpn.log';
$fh = fopen($myFile, 'a') or die("can't open file");
fwrite($fh, $req);
//die();


$ch = curl_init();

//Dia chi chay BPN test
curl_setopt($ch, CURLOPT_URL,'https://www.baokim.vn/bpn/verify');

curl_setopt($ch, CURLOPT_VERBOSE, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
$result = curl_exec($ch);
$status = curl_getinfo($ch, CURLINFO_HTTP_CODE); 
$error = curl_error($ch);

$myFile = $_SERVER['DOCUMENT_ROOT'] . '/logs/bpn.log';
$fh = fopen($myFile, 'a') or die("can't open file");
fwrite($fh, $str);

if($result != '' && strstr($result,'VERIFIED') && $status==200){
	$order_id            = $_POST['order_id'];
	$transaction_id      = $_POST['transaction_id'];
	$transaction_status  = $_POST['transaction_status'];
	$comment             = "Nạp tiền vào tài khoản Hamhoc.edu.vn";
	$maa_status          = 1;
	$total_amount        = intval($_POST['total_amount']);

	//Mot so thong tin khach hang khac
	$customer_name   	= $_POST['customer_name'];
	$customer_email  	= urldecode($_POST['customer_email']);
	$customer_address 	= $_POST['customer_address']; 

	if ($transaction_status == 4||$transaction_status == 13){ 
		switch($total_amount){
			case 50000   : $moneyadd = 50000  ; break;
			case 100000  : $moneyadd = 100000  ; break;
			case 200000  : $moneyadd = 200000  ; break;
			case 300000  : $moneyadd = 300000  ; break;
			case 500000  : $moneyadd = 500000  ; break;
		}
		$curTime = time();
		$uId 	= 	$myuser->u_id;

		$dbCheckUser 	= 	new db_query('SELECT * FROM users WHERE use_id = "'.$uId.'"');
    	$arrUser		= 	$dbCheckUser->resultArray();
    
		$endMoney 	=	$arrUser[0]['user_wallet'] + $moneyadd;
		$update 	= 	"UPDATE users SET user_wallet = ".$endMoney." WHERE use_id = ".$uId;
	    $db_update 	= 	new db_execute($update);
	    unset($db_update);  
    	$description 	=	"Họ và tên : ".$cusName.", Nạp qua tài khoản ngân hàng [Vui lòng vào tài khoản bảo kim để xem thông tin chi tiết], Menh gia: ".$moneyadd.", Thoi gian: ".$curTime;
    	$sqlLog			=	"INSERT INTO `user_payment_log` (`upaylog_ui`, `upaylog_user_id`, `upaylog_date`, `upaylog_money`, `upaylog_method`, `upaylog_info_description`) VALUES (NULL, '$uId', '$curTime', '$amount', 'Tài khoản ngân hàng', '$description');";
    	$dbInsertLog  	=  	new db_execute($sqlLog);
		redirect("http://hamhoc.edu.vn");
	}
}else{
	fwrite($fh, ' => INVALID');
}
if ($error){
	fwrite($fh, " | ERROR: $error");
}
fclose($fh);