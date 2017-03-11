<?
ob_start();
require_once("../../../functions/rewrite_functions.php");
require_once("../../resource/security/security.php");
ob_clean();
error_reporting(E_ALL);
ini_set('display_errors', '1');

$module_id	= 8;
$module_name= "Bài tập";
//Check user login...
checkLogged();
//Check access module...
//if(checkAccessModule($module_id) != 1) redirect($fs_denypath);

//Declare prameter when insert data
$fs_table		      = "exercises";
$id_field		      = "exe_id";
$name_field		      = "exe_name";
$break_page		      = "{---break---}";
$fs_fieldupload	   = "use_avatar";
$fs_filesize   		= 10000;
$width_small_image	= 120;
$fs_filepath_data   	= "../../../data/exercises_unit/";
$fs_extension        = "mp3,mp4,flv,acc,swf,jpg,gif,png";
$arr_resize          = array( "small_" => array("quality" => 90, "width" => 150, "height" => 120)
                        ,"medium_" => array("quality" => 90, "width" => 450, "height" => 300));
$height_small_image	= 120;
$width_normal_image	= 270;
$height_normal_image = 270;
$fs_insert_logo		= 0;
?>