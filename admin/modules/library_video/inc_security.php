<?
$module_id 			= 13;
$module_name		= "Quản lý thư viện video";

$fs_table			= "library_video";
$id_field			= "lib_video_id";
$name_field			= "lib_video_title";
$imgpath   	        = "../../../pictures/video/";
$videopath   	    = "../../../data/video/";
$extension_list	    = "jpg,gif,png";
$add				= "add.php";
$listing			= "listing.php";
//check security...
require_once("../../resource/security/security.php");
//Check user login...
checkLogged();
//Check access module...
//if(checkAccessModule($module_id) != 1) redirect($fs_denypath);

//định dạng file ảnh dc chấp nhận
$fs_extension	   = "jpg,png,gif,flv,avi,mp4,mkv";
//k-báo mảng để thay đổi kich cỡ - dung lượng ảnh.
$arr_resize        = array( "small_" => array("quality" => 90, "width" => 150, "height" => 120)
                        ,"medium_" => array("quality" => 90, "width" => 450, "height" => 300)
					           );
//khai báo kích cỡ tối đa file ảnh upload
$fs_filesize	   = 204800;								
?>