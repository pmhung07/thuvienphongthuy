<?php
require_once('config.php');
//function POST request
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

$access_key = $_GET['access_key'];   // request_transaction
$amount = $_GET['amount'];    // >10000
$content = $_GET['content'];    // mã hóa đơn <50 ký tự
$requestId = $_GET['requestId'];      

$execute = getvalue('execute','int','POST',0);
$etotp = getValue('etotp','int','POST',0);

 // gui du lieu den file result de xu ly

if($execute == 1 && $etotp != ''){
    $data = "&access_key=".$access_key."&amount=".$amount."&requestId=".$requestId."&transId=".$transId."&otp=".$etotp;
    echo $data;die();
    $hearder = execPostRequest('./result_otp.php', $data);
    //var_dump($data);
}else{
    //echo 'Xử lý không thành công!'
}

//var_dump($hearder);

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
    <?php include_once('../includes/inc_header.php');?>
    <div class="otp"><div>
        <form action="http://<?=$base_url?>/home/confirm.php" id="payment-otp" class="" enctype="multipart/form-data" method="POST">
            <input class="etotp" name="etotp" value="" placeholder="Nhập chính xác mã số OT màP gửi về điện thoại của bạn">
            <input type="hidden" name="execute" value="1"/>
            <span class="request_otp">XÁC NHẬN</span>
        </form>
    </div></div>
    <?php include_once('../includes/inc_footer.php');?>
</div>
</body>
</html>

<script type="text/javascript">
$( ".request_otp" ).click(function() {
    $('form#payment-otp').submit();
    return false;  
});
</script>