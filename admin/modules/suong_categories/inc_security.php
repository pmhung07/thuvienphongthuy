<?
//include file security
require_once("../../resource/security/security.php");
error_reporting(E_ALL);
ini_set('display_errors', '1');
//id của module- đc khai báo tại trang quản lý admin. Bắt buộc khai báo phải giống module_id đc cấp tại trang tạo mới module

$module_id	= 56;
$module_name= "Quản lý danh mục thư viện cộng đồng";
//Check user login...
checkLogged();
//Check access module...
if(checkAccessModule($module_id) != 1) redirect($fs_denypath);

//Declare prameter when insert data
//khai báo tên bảng tương tác. tương ứng với module. 
$fs_table		= "suong_categories";
//các trường : primary keys.
$id_field		= "cat_id";
$name_field		= "cat_name";
//đường dẫn folder chứa ảnh upload.
$imgpath		=	"../../../pictures/categories/"; 
//định dạng file ảnh dc chấp nhận
$fs_extension	=	"jpg,png,gif";
//$test 			= "../courses/";
//k-báo mảng để thay đổi kich cỡ - dung lượng ảnh.
$arr_resize    = array( "small_" => array("quality" => 90, "width" => 150, "height" => 120)
                        ,"medium_" => array("quality" => 90, "width" => 450, "height" => 300)
					           );
//khai báo kích cỡ tối đa file ảnh upload
$fs_filesize	=	1024;
?>