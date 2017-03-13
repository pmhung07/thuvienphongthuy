<?
require_once("session.php");
//require_once("../functions/checkpostserver.php");

// Bootstrap appliation
require_once '../bootstrap/setup.php';
require_once("../functions/app_functions.php");

require_once("../functions/translate.php");
require_once("../functions/functions.php");
require_once("../classes/database.php");
require_once("resource/security/functions.php");

$username	= getValue("username", "str", "POST", "", 1);
$password	= getValue("password", "str", "POST", "", 1);
$action		= getValue("action", "str", "POST", "");

//Kiem tra xem ip nay co duoc phep vao admin hay khong
$ip					= $_SERVER['REMOTE_ADDR'];
$check_ip_exists	= 1;
//if(file_exists("ipstore/" . ip2long($ip) . ".cfn")){
	//$check_ip_exists	= 1;
//}

if($action == "login" && $check_ip_exists == 1){
	$user_id	= 0;
	$user_id = checkLogin($username, $password);
	if($user_id != 0){
		$isAdmin		= 0;
		$db_isadmin	= new db_query("SELECT adm_isadmin, lang_id FROM admin_user WHERE adm_id = " . $user_id);
		$row			= mysqli_fetch_array($db_isadmin->result);
		if($row["adm_isadmin"] != 0) $isAdmin = 1;
		//Set SESSION
		//$_SESSION["Logged"]			= 1;
		$_SESSION["logged"]			= 1;
		$_SESSION["user_id"]			= $user_id;
		$_SESSION["userlogin"]		= $username;
		$_SESSION["password"]		= md5($password);
		$_SESSION["isAdmin"]			= $isAdmin;
		$_SESSION["lang_id"]			= $row["lang_id"];
		$_SESSION["lang_id"] 		= get_curent_language();
		$_SESSION["lang_path"] 		= get_curent_path();
		unset($db_isadmin);
	}
}

//Check logged
$logged = getValue("logged", "int", "SESSION", 0);
$db_language			= new db_query("SELECT tra_text,tra_keyword FROM admin_translate");
$langAdmin 				= array();
while($row=mysqli_fetch_assoc($db_language->result)){
	$langAdmin[$row["tra_keyword"]] = $row["tra_text"];
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?
if($logged == 1){
?>
	<script language="javascript">
   	window.parent.location.href="index.php";
   </script>
<?
}
?>
<title><?=translate_text("Management website version 1.0")?></title>
<link rel="stylesheet" type="text/css" href="resource/css/layout.css">
</head>
<body bgcolor="#DFE8F6">
	<table id="Table_01" width="361" align="center" style="margin-top:200px;" border="0" cellpadding="0" cellspacing="0">
		<tr>
			<td height="60" style="background:url('resource/images/login_01.gif') no-repeat;" class="title_login" valign="top"><?=translate_text("Account Management")?></td>
		</tr>
		<tr>
			<td style="background:url('resource/images/login_02.gif') repeat-y;" align="center">
				<form action="<?=$_SERVER['REQUEST_URI']?>" method="post" style="margin:0px; padding:0px;">
				<input name="action" type="hidden" value="login">

				<table cellpadding="9" cellspacing="0" class="forumlogin">
					<? /* ?>
					<tr>
						<td colspan="2"><?=ip2long($ip) . "|" . $check_ip_exists?></td>
					</tr>
					<? */ ?>
					<? if($check_ip_exists != 1){ ?>
					<tr>
						<td colspan="2" style="color:#F00">IP chưa được chấp nhận</td>
					</tr>
					<? } ?>
					<tr>
						<td><?=translate_text("Account")?> :</td>
						<td><input type="text" name="username" id="username" /></td>
					</tr>
					<tr>
						<td><?=translate_text("Password")?> :</td>
						<td><input type="password" name="password" id="password" /></td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td><input type="submit" class="tootlipObserved" value="<?=translate_text("Login")?>" /></td>
					</tr>
				</table>
				</form>
			</td>
		</tr>
		<tr>
			<td height="20" style="background:url('resource/images/login_05.gif') no-repeat;"></td>
		</tr>
	</table>
</body>
</html>
