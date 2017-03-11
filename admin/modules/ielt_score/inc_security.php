<?
//include file security
require_once("../../resource/security/security.php");
error_reporting(E_ALL);
ini_set('display_errors', '1');
//id của module- đc khai báo tại trang quản lý admin. Bắt buộc khai báo phải giống module_id đc cấp tại trang tạo mới module

$module_id	= 35;
$module_name= "Quản lý Điểm thi IELTS";
//Check user login...
checkLogged();
//Check access module...
if(checkAccessModule($module_id) != 1) redirect($fs_denypath);

//Declare prameter when insert data
//khai báo tên bảng tương tác. tương ứng với module. 
$fs_table		= "ielts_result";
//các trường : primary keys.
$id_field		= "ielr_id";
//đường dẫn folder chứa ảnh upload.
$imgpath		=	"../../../pictures/posts/"; 
//định dạng file ảnh dc chấp nhận
$fs_extension	=	"jpg,png,gif";
$data_path  = 	"../../../data/ielts_record_speaking/"; 
//$test 			= "../courses/";
?>