<?php
require_once("../home/config.php");
header('Content-Type: text/html; charset=utf-8');
define('CORE_API_HTTP_USR', 'merchant_18155');
define('CORE_API_HTTP_PWD', '181551Wm35GQEKVCe5fwSN1hAtUI8FiTMl3');

$json           = array();
$success        = 0;
$message        = '';
$result_pay     = '';

$bk 			= 'https://www.baokim.vn/the-cao/restFul/send';
$money			= getValue('money','str','POST','');
$card          	= getValue('card','str','POST','');
$seri          	= getValue('seri','str','POST','');
$code          	= getValue('code','str','POST','');

$cusName    	= getValue('cusName','str','POST','');
$cusPhone   	= getValue('cusPhone','str','POST','');
$cusEmail   	= getValue('cusEmail','str','POST','');
$cusAddress 	= getValue('cusAddress','str','POST','');

if($card != '' && $seri != '' && $code !='' && $money != '' || $money == 50000 || $money == 300000){
    if($card=='MOBI'){ $namecard = "Mobifone"; }
	else if($card=='VIETEL'){ $namecard = "Vietel"; }
	else if($card=='GATE'){ $namecard = "Gate"; }
	else if($card=='VTC'){ $namecard = "VTC"; }
	else if($card=='Vietnamobile'){ $namecard = "vnm"; }
	else $namecard ="Vinaphone";

	//Mã MerchantID dang kí trên Bảo Kim
	$merchant_id = '18155';
	//Api username 
	$api_username = 'hamhoceduvn';
	//Api Pwd d
	$api_password = 'hamhoceduvnSg234sgagw';
	//Mã TransactionId 
	$transaction_id = time();
	//mat khau di kem ma website dang kí trên Bao Kim
	$secure_code = '2043a15fb2e46472';

	$arrayPost = array(
		'merchant_id'	=>	$merchant_id,
		'api_username'	=>	$api_username,
		'api_password'	=>	$api_password,
		'transaction_id'=>	$transaction_id,
		'card_id'		=>	$card,
		'pin_field'		=>	$code,
		'seri_field'	=>	$seri,
		'algo_mode'		=>	'hmac'
	);

	ksort($arrayPost);

	$data_sign = hash_hmac('SHA1',implode('',$arrayPost),$secure_code);
	$arrayPost['data_sign'] = $data_sign;
	$curl = curl_init($bk);

	curl_setopt_array($curl, array(
		CURLOPT_POST=>true,
		CURLOPT_HEADER=>false,
		CURLINFO_HEADER_OUT=>true,
		CURLOPT_TIMEOUT=>30,
		CURLOPT_RETURNTRANSFER=>true,
		CURLOPT_SSL_VERIFYPEER => false,
		CURLOPT_HTTPAUTH=>CURLAUTH_DIGEST|CURLAUTH_BASIC,
		CURLOPT_USERPWD=>CORE_API_HTTP_USR.':'.CORE_API_HTTP_PWD,
		CURLOPT_POSTFIELDS=>http_build_query($arrayPost)
	));

	$data 	= curl_exec($curl);
	$status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
	$result = json_decode($data,true);
	date_default_timezone_set('Asia/Ho_Chi_Minh');
	$time = time();
	
	if($status==200){
	    $amount = $result['amount'];
	    if($amount == 50000 || $amount == 100000 || $amount == 200000 || $amount == 300000 || $amount == 500000){

			$uId 			= 	$myuser->u_id;
			$dbCheckUser 	= 	new db_query('SELECT * FROM users WHERE use_id = "'.$uId.'"');
        	$arrUser		= 	$dbCheckUser->resultArray();
        
    		$endMoney 	=	$arrUser[0]['user_wallet'] + $amount;
    		$update 	= 	"UPDATE users SET user_wallet = ".$endMoney." WHERE use_id = ".$uId;
		    $db_update 	= 	new db_execute($update);
		    unset($db_update);  
		    $info 			=	"Họ và tên : ".$cusName.", Email: ".$cusEmail.", Phone: ".$cusPhone.", Address: ".$cusAddress;
        	$description 	=	"Họ và tên : ".$cusName.", Loai the: ".$card.", Menh gia: ".$amount.", Thoi gian: ".$curTime;
        	$sqlLog			=	"INSERT INTO `user_payment_log` (`upaylog_ui`, `upaylog_user_id`, `upaylog_date`, `upaylog_money`, `upaylog_method`, `upaylog_pin`, `upaylog_seri`, `upaylog_info`, `upaylog_info_description`) VALUES (NULL, '$uId', '$curTime', '$amount', '$card', '$code', '$seri', '$info', '$description');";
        	$dbInsertLog  	=  	new db_execute($sqlLog);
		   	$result_pay		.=   "Bạn đã thanh toán thành công thẻ ".$namecard." mệnh giá ".$amount." VNĐ.Tài khoản của quý khách sẽ được cộng thêm ".$amount." vnđ vào ví trên hệ thống hamhoc.edu.vn";
            	

			
	    }else{
	    	$result_pay .= 'BẠN ĐÃ NẠP THÀNH CÔNG NHƯNG HIỆN TẠI GIÁ TRỊ THẺ NẠP CỦA BẠN KHÔNG ĐÚNG VỚI MỆNH GIÁ BẠN ĐÃ CHỌN.HÃY LIÊN HỆ LẠI VỚI BAN QUẢN TRỊ ĐỂ KHẮC PHỤC.';
	    }
		
	    $file	=   $_SERVER["DOCUMENT_ROOT"] . "/logs/payment_card_success.cfn";
		$fh 	= 	fopen($file,'a') or die("cant open file");
		fwrite($fh,"Tai khoan: ".$myuser->use_email.", Loai the: ".$namecard.", Menh gia: ".$amount.", Thoi gian: ".$time);
		fwrite($fh,"\r\n");
		fclose($fh);

	}else{ 
		$result_pay .= 'THÔNG TIN THẺ CÀO KHÔNG ĐÚNG , KHÔNG THỰC HIỆN ĐƯỢC VIỆC THANH TOÁN';
		$file	=   $_SERVER["DOCUMENT_ROOT"] . "/logs/payment_card_error.cfn";
		$fh 	= 	fopen($file,'a') or die("cant open file");
		fwrite($fh,"Tai khoan: ".$myuser->use_email.", Loai the: ".$namecard.", Menh gia: ".$amount.", Thoi gian: ".$time);
		fwrite($fh,"\r\n");
		fclose($fh);
	}

}else{
    $result_pay .= 'THÔNG TIN SAI , KHÔNG THỰC HIỆN ĐƯỢC VIỆC THANH TOÁN';
}

$json['result_pay'] = $result_pay;
echo json_encode($json);

?>
