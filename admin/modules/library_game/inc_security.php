<?
//include file security
require_once("../../resource/security/security.php");
//id của module- đc khai báo tại trang quản lý admin. Bắt buộc khai báo phải giống module_id đc cấp tại trang tạo mới module
$module_id	= 10;
$module_name= "Quản lý thư viện Games";
//Check user login...
checkLogged();
//Check access module...
if(checkAccessModule($module_id) != 1) redirect($fs_denypath);

//Declare prameter when insert data
//khai báo tên bảng tương tác. tương ứng với module. 
$fs_table		= "library_game";
//các trường : primary keys.
$id_field		= "lib_game_id";
$name_field		= "lib_game_title";
//đường dẫn folder chứa ảnh upload.
$imgpath		=	"../../../pictures/library_game/"; 
//định dạng file ảnh dc chấp nhận
$fs_extension	=	"gif,jpg,jpe,jpeg,png,swf";
$mediapath  = "../../../data/library_game/";
$test 			= "../main_lesson/";
//k-báo mảng để thay đổi kich cỡ - dung lượng ảnh.
$arr_resize    = array( "small_" => array("quality" => 90, "width" => 150, "height" => 120)
                        ,"medium_" => array("quality" => 90, "width" => 450, "height" => 300)
					           );
//khai báo kích cỡ tối đa file ảnh upload
$fs_filesize	=	20240;
?>