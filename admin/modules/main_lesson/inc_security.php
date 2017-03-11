<?
ob_start();
//include file security
require_once("../../../functions/rewrite_functions.php");
require_once("../../resource/security/security.php");
ob_clean();
error_reporting(E_ALL);
ini_set('display_errors', '1');
//id của module- đc khai báo tại trang quản lý admin. Bắt buộc khai báo phải giống module_id đc cấp tại trang tạo mới module
$module_id	= 6;
$module_name= "Quản lý Main lesson";
//Check user login...
checkLogged();
//Check access module...
//if(checkAccessModule($module_id) != 1) redirect($fs_denypath);

//Declare prameter when insert data
//khai báo tên bảng tương tác. tương ứng với module. 
$fs_table		= "lesson_details";
//các trường : primary keys.
$id_field		= "les_det_id";
$name_field		= "les_det_name";
//đường dẫn folder chứa ảnh upload.
$imgpath		=	"../../../data/main_content/"; 
//định dạng file ảnh dc chấp nhận
$fs_extension	=	"gif,jpg,jpe,jpeg,png,mp3,mp4,avi,mkv,wmv,mpg,mpeg,flv,swf,f4v";
$test 			= "../main_lesson/";
//k-báo mảng để thay đổi kich cỡ - dung lượng ảnh.
$arr_resize    = array( "small_" => array("quality" => 90, "width" => 150, "height" => 120)
                        ,"medium_" => array("quality" => 90, "width" => 450, "height" => 300)
					           );
//khai báo kích cỡ tối đa file ảnh upload
$fs_filesize	=	200000;
?>