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
$transId = $_GET['transId'];
$cv_id = $_GET['cv_id'];

$execute = getvalue('execute','int','POST',0);
$etotp = getValue('etotp','int','POST',0);

 // gui du lieu den file result de xu ly

if($execute == 1 && $etotp != ''){

    $access_key = $_POST['access_key'];   // request_transaction
    $amount = $_POST['amount'];    // >10000
    $content = $_POST['content'];    // mã hóa đơn <50 ký tự
    $requestId = $_POST['requestId'];     
    $transId = $_POST['transId']; 
    $cv_id = $_POST['cv_id']; 

    $data = "&access_key=".$access_key."&amount=".$amount."&requestId=".$requestId."&transId=".$transId."&otp=".$etotp."&cv_id=".$cv_id;
    //echo $data;
    //$hearder = execPostRequest('./result_otp.php', $data);
    //$decode_header = json_decode($hearder,true);  // decode json
    //var_dump($decode_header);

    //thu nghiem
    $pay_url= "./result_otp.php?".$data;
    header("Location: $pay_url");  //URL address implement submit request (redirect)
}else{
    //echo 'Xử lý không thành công!'
}


//var_dump($hearder);

?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title>Thư viện phong thuỷ :: Kiến thức phong thủy · Thiết kế Phong thủy · Câu chuyện Phong thủy · Kiến thức Tử vi · Phần mềm Phong thủy · Nhân Tướng Học · Tổng hợp · Sách...</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="Kiến thức phong thủy · Thiết kế Phong thủy · Câu chuyện Phong thủy · Kiến thức Tử vi · Phần mềm Phong thủy · Nhân Tướng Học · Tổng hợp · Sách...">
<meta name="keywords" content="Kiến thức phong thủy · Thiết kế Phong thủy · Câu chuyện Phong thủy · Kiến thức Tử vi · Phần mềm Phong thủy · Nhân Tướng Học · Tổng hợp · Sách...">
<meta property="og:url" content="http://<?=$base_url?>/">
<meta property="og:title" content="Thư viện phong thuỷ - Kiến thức phong thủy · Thiết kế Phong thủy · Câu chuyện Phong thủy · Kiến thức Tử vi · Phần mềm Phong thủy · Nhân Tướng Học · Tổng hợp · Sách...">
<meta property="og:description" content="Kiến thức phong thủy · Thiết kế Phong thủy · Câu chuyện Phong thủy · Kiến thức Tử vi · Phần mềm Phong thủy · Nhân Tướng Học · Tổng hợp · Sách...">
<meta property="og:type" content="website">
<meta property="og:image" content="http://<?=$base_url?>/themes_v2/images/logo_fav.jpg">
<meta property="og:site_name" content="thuvienphongthuy.vn">

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
            <div class="otp" style="background-color: rgb(50, 50, 50);height: 110px;"><div>
                <form action="http://<?=$base_url?>/home/confirm.php" id="payment-otp" class="" enctype="multipart/form-data" method="POST">
                    <input style="  margin: 35px 0px 35px 60px;border: none;padding: 10px;width: 400px;" class="etotp" name="etotp" value="" placeholder="Nhập chính xác mã số OTP chúng tôi gửi về điện thoại của bạn">
                    <input type="hidden" name="execute" value="1"/>
                    <input type="hidden" name="access_key" value="<?=$access_key?>"/>
                    <input type="hidden" name="amount" value="<?=$amount?>"/>
                    <input type="hidden" name="content" value="<?=$content?>"/>
                    <input type="hidden" name="requestId" value="<?=$requestId?>"/>
                    <input type="hidden" name="transId" value="<?=$transId?>"/>
                    <input type="hidden" name="cv_id" value="<?=$cv_id?>"/>
                    <span style="  padding: 10px;background-color: #F26E24;cursor: pointer;color: white;" class="request_otp">XÁC NHẬN</span>
                </form>
            </div></div>
            <?php include_once('../includes/inc_footer.php');?>
        </div>
    </div>
</div>
</body>
</html>

<script type="text/javascript">
$( ".request_otp" ).click(function() {
    $('form#payment-otp').submit();
    return false;  
});
</script>