<?
require_once("../../resource/security/security.php");
//id host module_id = 71
$module_id	= 71;
$module_name= "Email Amazon";
//Check user login...
checkLogged();
//Check access module...
if(checkAccessModule($module_id) != 1) redirect($fs_denypath);

//Declare prameter when insert data
$fs_table					= "email_amazon";
$id_field					= "ema_id";
$name_field					= "ema_title";
$break_page					= "{---break---}";
//$fs_fieldupload  			= "use_avatar";
//$fs_filepath   			= "../../../pictures/avatar/";
$fs_extension   			= "gif,jpg,jpe,jpeg,png";
$fs_filesize   			= 1000;
$fs_insert_logo  			= 0;
											
?>