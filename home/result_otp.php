<?php
require_once('config.php');
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
// lấy dữ liệu truyền vào 

$requestId = isset($_GET["requestId"]) ? $_REQUEST["requestId"] : NULL;
$transId = isset($_GET["transId"]) ? $_REQUEST["transId"] : NULL;
$otp = isset($_GET["otp"]) ? $_GET["otp"] : NULL;
$access_key = isset($_GET["access_key"]) ? $_REQUEST["access_key"] : NULL;
$amount = isset($_GET["amount"]) ? $_REQUEST["amount"] : NULL;
$cv_id = isset($_GET["cv_id"]) ? $_REQUEST["cv_id"] : NULL;
  //$access_key = "yaz93veaf8qmwahshoo5";           // access_key được cấp bởi 1pay, thay bằng access_key của bạn
$secret = "s8j6qu3fhvj11gnqdq6f4o7gylzuacmc";               // secret key được cấp bởi 1pay, thay bằng secret_key của bạn

$data = "access_key=".$access_key."&otp=".$otp."&requestId=".$requestId."&transId=".$transId;

$signature = hash_hmac("sha256", $data, $secret);
$data.= "&signature=" . $signature;
$json_bankCharging = execPostRequest('http://api.1pay.vn/direct-charging/charge/confirm', $data);
//decode json
$decode_bankCharging=json_decode($json_bankCharging,true);
$errorMessage = $decode_bankCharging["errorMessage"];
$requestId_back = $decode_bankCharging["requestId"];
$transId = $decode_bankCharging["transId"];
$errorCode = $decode_bankCharging["errorCode"];
//$add_log = "insert into 1pay_log_otp (id, amount, trans_id, request_id, error_code, error_message) values ('','".$amount."', '".$transId."','".$requestId_back."','".$errorCode."','".$errorMessage."')"; 
//mysql_query($add_log) or die (mysql_error());


?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title>Học Tiếng Anh Online, Tiếng Anh giao tiếp, thi TOEIC, IELTS, TOEFL</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="Học tiếng Anh Online, Tiếng Anh giao tiếp, luyện thi TOEFL, IELTS, TOEIC, kỹ năng Tiếng Anh, Tiếng Anh phổ thông, tiếng anh văn phòng, tiếng Anh trẻ em">
<meta name="keywords" content="Học tiếng Anh online, khóa học tiếng Anh, luyện thi TOEIC, IELTS, TOEFL, Ngữ pháp tiếng Anh, Từ vựng tiếng Anh, CLB tiếng Anh">
<meta property="og:url" content="http://<?=$base_url?>/">
<meta property="og:title" content="Tienganh2020.com - Học Tiếng Anh Online, học Tiếng Anh chất lượng cao">
<meta property="og:description" content="Học Tiếng Anh trực tuyến, học ngoại ngữ online, luyện giao tiếp Tiếng Anh, luyện thi TOEFL,IELTS,TOEIC, luyện kỹ năng Tiếng Anh">
<meta property="og:type" content="website">
<meta property="og:image" content="http://<?=$base_url?>/themes_v2/images/logo_fav.jpg">
<meta property="og:site_name" content="tienganh2020.com">

<link rel="icon" type="image/x-icon" href="http://<?=$base_url?><?=$var_path_img?>favicon.ico" />
<link rel="shortcut icon" href="http://<?=$base_url?><?=$var_path_img?>favicon.ico" />

<?=$var_general_css?>
<?=$var_general_js?>

</head>

<body>
<div class="wrap">
    <div class="content">
        <div class="content-main">
            <?php include_once('../includes/inc_header.php');?>
            <div class="otp" style="background-color: rgb(50, 50, 50);">
                <div style="color: white;padding: 10px;line-height: 20px;">
                <?php
                echo 'Trạng Thái:'.$errorMessage.'</br>';//die(); 
                echo 'CODE :'.$requestId_back.'</br>';//die(); 
                echo 'Giao dịch :'.$transId.'</br>';//die(); 
                //echo 'errorCode:'.$errorCode.'</br>';//die(); 
                $db_select = new db_query("SELECT * FROM cover_letters WHERE cv_id=".$cv_id);
                $arrCv = $db_select->resultArray();
                if($errorCode == '00'){
                ?>
                    <div class="cv_buy">
                        <a target="_blank" href="http://<?=$base_url?>/data/cover_letters/<?=$arrCv[0]['cv_data']?>">
                            <span>DOWNLOAD</span>
                        </a>
                    </div>

                    <?php  
                    $update     =   "UPDATE cover_letters SET cv_downloads = cv_downloads + 1 WHERE cv_id = ".$cv_id;
                    $db_update  =   new db_execute($update);
                    unset($db_update);  
                    ?>

                <?php }else{ ?>
                    echo $errorMessage;
                <?php } ?>

                </div>
            </div>
            <?php include_once('../includes/inc_footer.php');?>
        </div>
    </div>
</div>
</body>
</html>
