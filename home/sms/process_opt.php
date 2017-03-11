<?php
  
function execPostRequest($url, $data)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}

$access_key = "9bss21ok10ncransrvgd";           // access_key được cấp bởi 1pay, thay bằng access_key của bạn
$secret = "s8j6qu3fhvj11gnqdq6f4o7gylzuacmc";               // secret key được cấp bởi 1pay, thay bằng secret_key của bạn
                                                                              // bạn thay bằng return_url của bạn
$msisdn = $_POST['msisdn'];   // request_transaction
$amount = $_POST['amount'];    // >10000
$content = $_POST['content'];    // mã hóa đơn <50 ký tự
$requestId = $_POST['requestId'];  // Mô tả hóa đơn

$data = "access_key=".$access_key."&amount=".$amount."&content=".$content."&msisdn=".$msisdn."&requestId=".$requestId;


$signature = hash_hmac("sha256", $data, $secret);
$data.= "&signature=" . $signature;

//echo $data;die();

$json_bankCharging = execPostRequest('http://api.1pay.vn/direct-charging/charge/request', $data);
$decode_bankCharging=json_decode($json_bankCharging,true);  // decode json
$errorMessage = $decode_bankCharging["errorMessage"];
$requestId_back = $decode_bankCharging["requestId"];
$transId = $decode_bankCharging["transId"];
$errorCode = $decode_bankCharging["errorCode"];

//echo 'here:';
//var_dump($errorCode);die();

$url = "&access_key=".$access_key."&amount=".$amount."&requestId=".$requestId."&transId=".$transId."&content=".$content;

$pay_url= "./confirm.php?".$url;

header("Location: $pay_url");  //URL address implement submit request (redirect)
  
 
?>