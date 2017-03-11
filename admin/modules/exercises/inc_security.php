<?
require_once("../../resource/security/security.php");

$module_id	= 37;
$module_name= "Bài tập";
//Check user login...
checkLogged();
//Check access module...
if(checkAccessModule($module_id) != 1) redirect($fs_denypath);

//Declare prameter when insert data
$fs_table		      = "exercises";
$id_field		      = "exe_id";
$name_field		      = "exe_name";
$break_page		      = "{---break---}";
$fs_fieldupload	   = "use_avatar";
$fs_filepath_data   	= "../../../pictures/data/";
$fs_extension        = "gif,jpg,jpe,jpeg,png,rar,mp3,mp4,pdf,avi";
$fs_filesize   		= 1000;
$width_small_image	= 120;
$height_small_image	= 120;
$width_normal_image	= 270;
$height_normal_image = 270;
$fs_insert_logo		= 0;
?>