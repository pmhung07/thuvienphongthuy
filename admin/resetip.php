<?php
require_once("session.php");
require_once("../functions/checkpostserver.php");

require_once("../functions/functions.php");
require_once("../classes/database.php");
require_once("../classes/denyconnect.php");

ob_start("callback");
//Chống bot truy cập
$denyconnect = new denyconnect();

$ip	= $_SERVER['REMOTE_ADDR'];
if(!file_exists("ipstore/" . ip2long($ip) . ".cfn")){
	$filename = "ipstore/" . ip2long($ip) . ".cfn";
	$handle = @fopen($filename, 'a');
	if (!$handle) exit();
	fwrite($handle, $ip);
	fclose($handle);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Reset IP | Cucre.Vn</title>
<style type="text/css">
a{
	color:#003399;
	text-decoration:none;
}
a:hover{
	color:#e97d13;
	text-decoration:underline;
}
body{
	background:#F2F2F2;
	font-family:Arial, Verdana;
	font-size:12px;
}
form{
	margin:0px;
	padding:0px;
}
#body{
	margin-top:150px;
}
.content{
	background:#FFFFFF;
	border:1px #999999 solid;
	border-radius:0.5em;
	-moz-border-radius:0.5em;
	margin:0px auto;
	padding:10px;
	width:350px;
}
.form_button{
	font-size:12px;
}
.form_control{
	border:1px #CCCCCC solid;
	font-size:12px;
	font-weight:normal;
	padding:1px;
}
.form_errorMsg{
	color:#FF0000;
}
.form_name{
	font-weight:bold;
	text-align:right;
}
.message{
	text-align:center;
	margin-bottom:10px;
}
.table_reset{
	width:100%;
}
.your_ip{
	color:#003399;
	font-size:18px;
	font-weight:bold;
	margin-bottom:10px;
	text-align:center;
}
</style>
</head>
<body>
<div id="body">
	<div class="content">
		<div class="your_ip">Your IP is: <span><?=$_SERVER['REMOTE_ADDR']?></span></div>
		<div class="message">Your IP has been added to system</div>
		<div class="message">You can access <a href="http://<?=$_SERVER["HTTP_HOST"]?>/images_cr/">The Management Page</a> now</div>
		<div align="center">&copy; <?=date("Y")?> <a href="http://www.cucre.vn/">Cucre.Vn</a></div>
	</div>
</div>
</body>
</html>