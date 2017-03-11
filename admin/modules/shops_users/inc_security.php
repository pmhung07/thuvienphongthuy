<?
require_once("../../resource/security/security.php");

$module_id	= 54;
$module_name= "Shops Users";
//Check user login...
checkLogged();
//Check access module...
if(checkAccessModule($module_id) != 1) redirect($fs_denypath);

//Declare prameter when insert data
$fs_table					= "shop_users";
$id_field					= "use_id";
$name_field					= "use_name";
$break_page					= "{---break---}";
//$fs_fieldupload  			= "use_avatar";
//$fs_filepath   			= "../../../pictures/avatar/";
$fs_extension   			= "gif,jpg,jpe,jpeg,png";
$fs_filesize   			= 1000;
$fs_insert_logo  			= 0;
											
?>