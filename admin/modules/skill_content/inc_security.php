<?
//include file security
require_once("../../resource/security/security.php");
error_reporting(E_ALL);
ini_set('display_errors', '1');
//id của module- đc khai báo tại trang quản lý admin. Bắt buộc khai báo phải giống module_id đc cấp tại trang tạo mới module
$module_id	= 32;
$module_name= "Quản lý Main lesson";
//Check user login...
checkLogged();
//Check access module...
if(checkAccessModule($module_id) != 1) redirect($fs_denypath);

//Declare prameter when insert data
//khai báo tên bảng tương tác. tương ứng với module. 
$fs_table		= "skill_content";
//các trường : primary keys.
$id_field		= "skl_cont_id";
$name_field		= "skl_cont_name";
//đường dẫn folder chứa ảnh upload.
$imgpath   	= "../../../pictures/skill_content/";
$mediapath  = "../../../data/skill_content/";
//định dạng file ảnh dc chấp nhận
$fs_extension	=	"gif,jpg,jpe,jpeg,png,mp3,mp4,avi,mkv,wmv,mpg,mpeg,flv,swf";

//k-báo mảng để thay đổi kich cỡ - dung lượng ảnh.
$arr_resize    = array( "small_" => array("quality" => 90, "width" => 150, "height" => 120)
                        ,"medium_" => array("quality" => 90, "width" => 450, "height" => 300)
					           );
//khai báo kích cỡ tối đa file ảnh upload
$fs_filesize	=	200000;
?>