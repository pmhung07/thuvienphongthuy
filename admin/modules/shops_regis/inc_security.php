<?
require_once("../../resource/security/security.php");

$module_id	= 69;
$module_name= "shops_regis";
//Check user login...
checkLogged();
//Check access module...
if(checkAccessModule($module_id) != 1) redirect($fs_denypath);

//Declare prameter when insert data
$fs_table		= "shop_signup";
$id_field		= "sig_id";
$name_field		= "sig_name";
$break_page		= "{---break---}";
$fs_fieldupload	= "use_avatar";
$fs_filepath	= "../../../pictures/avatar/";
$fs_extension	= "gif,jpg,jpe,jpeg,png";
$fs_filesize	= 400;
$width_small_image	= 120;
$height_small_image	= 120;
$width_normal_image	= 270;
$height_normal_image= 270;
$fs_insert_logo		= 0;
?>