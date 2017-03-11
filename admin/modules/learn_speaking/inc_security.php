<?
$module_id 			= 24;
$module_name		= "Quản lý phần học Speaking";

$fs_table			= "learn_speaking";
$id_field			= "learn_sp_id";
$id_name			= "learn_sp_content";
$mediapath  = "../../../data/learn_sp/";
$add					= "add.php";
$listing				= "listing.php";
//check security...
ob_start();
require_once("../../../functions/rewrite_functions.php");
require_once("../../resource/security/security.php");
ob_clean();
//Check user login...
//checkLogged();
//Check access module...
//if(checkAccessModule($module_id) != 1) redirect($fs_denypath);

//định dạng file ảnh dc chấp nhận
$fs_extension	=	"jpg,png,gif,flv,mp3,mp4";
//k-báo mảng để thay đổi kich cỡ - dung lượng ảnh.
$arr_resize    = array( "small_" => array("quality" => 90, "width" => 150, "height" => 120)
                        ,"medium_" => array("quality" => 90, "width" => 450, "height" => 300)
					           );
//khai báo kích cỡ tối đa file ảnh upload
$fs_filesize	=	200240;								
?>