<?
$module_id 			= 4;
$module_name		= "Quản lý Unit";

$fs_table			= "courses_multi";
$id_field			= "com_id";
$name_field			= "com_name";
$imgpath   	= "../../../pictures/unit/";
$extension_list	= "jpg,gif,png";
$add					= "add.php";
$listing				= "listing.php";
//check security...
require_once("../../resource/security/security.php");
//Check user login...
//checkLogged();
//Check access module...
//if(checkAccessModule($module_id) != 1) redirect($fs_denypath);

//định dạng file ảnh dc chấp nhận
$fs_extension	=	"jpg,png,gif";
//k-báo mảng để thay đổi kich cỡ - dung lượng ảnh.
$arr_resize    = array( "small_" => array("quality" => 90, "width" => 150, "height" => 120)
                        ,"medium_" => array("quality" => 90, "width" => 450, "height" => 300)
					           );
//khai báo kích cỡ tối đa file ảnh upload
$fs_filesize	=	1024;								
?>