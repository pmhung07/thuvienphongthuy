<?
$module_id 			= 12;
$module_name		= "Quản lý thư viện bài hát";

$fs_table			= "library_song";
$id_field			= "lib_song_id";
$name_field			= "lib_song_title";
$imgpath   	= "../../../pictures/song/";
$songpath   	= "../../../data/song/";
$extension_list	= "jpg,gif,png";
$add					= "add.php";
$listing				= "listing.php";
//check security...
require_once("../../resource/security/security.php");
//Check user login...
checkLogged();
//Check access module...


//định dạng file ảnh dc chấp nhận
$fs_extension	=	"jpg,png,gif,mp3,avi,flv,mp4,mkv";
//k-báo mảng để thay đổi kich cỡ - dung lượng ảnh.
$arr_resize    = array( "small_" => array("quality" => 90, "width" => 150, "height" => 120)
                        ,"medium_" => array("quality" => 90, "width" => 450, "height" => 300)
					           );
//khai báo kích cỡ tối đa file ảnh upload
$fs_filesize   		= 50000;							
?>