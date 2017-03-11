<?
//include file security
ob_start();
require_once("../../resource/security/security.php");
require_once("php-export-data.class.php");
//error_reporting(E_ALL);
ini_set('display_errors', '1');
//id của module- đc khai báo tại trang quản lý admin. Bắt buộc khai báo phải giống module_id đc cấp tại trang tạo mới module

$module_id	= 73;
$module_name= "Quản lý Thi thử";
//Check user login...
checkLogged();
//Check access module...
//if(checkAccessModule($module_id) != 1) redirect($fs_denypath);

//Declare prameter when insert data
//khai báo tên bảng tương tác. tương ứng với module. 
$fs_table		= "code_voucher";
//các trường : primary keys.
$id_field		= "code_vou_id";
//đường dẫn folder chứa ảnh upload.
//định dạng file ảnh dc chấp nhận
$fs_extension	=	"jpg,png,gif";
//$test 			= "../courses/";
//k-báo mảng để thay đổi kich cỡ - dung lượng ảnh.
$arr_resize    = array( "small_" => array("quality" => 90, "width" => 150, "height" => 120)
                        ,"medium_" => array("quality" => 90, "width" => 450, "height" => 300)
					           );
$arr_toeic_type = array("0" =>"Full Test",
						"1"=>"Mini Test"
						);
//khai báo kích cỡ tối đa file ảnh upload
$fs_filesize	=	1024;
?>