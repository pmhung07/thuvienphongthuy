<?php
require_once("config.php");

$email            = getValue("e","str","GET","");
$use_security     = getValue("sec","str","GET","");

$sql = "UPDATE users SET use_active = 1 WHERE use_email = '".$email."' AND use_security = '".$use_security."'";
$db_update = new db_execute($sql);
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title>Học Tiếng Anh Online, Tiếng Anh giao tiếp, thi TOEIC, IELTS, TOEFL</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<meta name="description" content="Học tiếng Anh Online, Tiếng Anh giao tiếp, luyện thi TOEFL, IELTS, TOEIC, kỹ năng Tiếng Anh, Tiếng Anh phổ thông, tiếng anh văn phòng, tiếng Anh trẻ em" />
<meta name="keywords" content="Học tiếng Anh online, khóa học tiếng Anh, luyện thi TOEIC, IELTS, TOEFL, Ngữ pháp tiếng Anh, Từ vựng tiếng Anh, CLB tiếng Anh" />
<meta property="og:url" content="http://<?=$base_url?>/"/>
<meta property="og:title" content="Tienganh2020.com - Học Tiếng Anh Online, học Tiếng Anh chất lượng cao"/>
<meta property="og:description" content="Học Tiếng Anh trực tuyến, học ngoại ngữ online, luyện giao tiếp Tiếng Anh, luyện thi TOEFL,IELTS,TOEIC, luyện kỹ năng Tiếng Anh"/>
<meta property="og:type" content="website"/>
<meta property="og:image" content="http://<?=$base_url?>/themes_v2/images/logo_fav.jpg"/>
<meta property="og:site_name" content="tienganh2020.com"/>

<link rel="icon" type="image/x-icon" href="http://<?=$base_url?><?=$var_path_img?>favicon.ico" />
<link rel="shortcut icon" href="http://<?=$base_url?><?=$var_path_img?>favicon.ico" />

<?=$var_general_css?>
<?=$var_general_js?>
<?php
if($db_update){      
    $notice1 = "<div><span>Bạn vừa kích hoạt tài khoản thành công!</span></br>";
    $notice2 = "<span>Bấm vào <a href='http://".$base_url."'>đây</a> để trở lại Website.</div>";
}else{  
    $notice1 = "<div><span>Đã có lỗi xảy ra trong quá trình thực thi!</span></br>";
    $notice2 = "<span>Bấm vào <a href='http://".$base_url."'>đây</a> để trở lại Website.</div>";
}

echo $notice1;
echo $notice2;

?>
<style type="text/css">
div{
	border: dashed 1px #666;
	float: left;
	width: 50%;
	padding: 10px 20px 20px 20px;
	margin: 10px;
}
span{
	color: rgb(169, 0, 0);
	margin-top: 10px;
	float: left;
	width: 100%;
	font-size: 13px;
	margin-left: 20px;
}
span a{
	font-weight: 600;
}
</style>
