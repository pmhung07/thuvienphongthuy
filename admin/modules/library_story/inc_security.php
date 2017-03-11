<?
//include file security
require_once("../../resource/security/security.php");
//id của module- đc khai báo tại trang quản lý admin. Bắt buộc khai báo phải giống module_id đc cấp tại trang tạo mới module
$module_id	= 11;
$module_name= "Quản lý thư viện Story";
//Check user login...
//checkLogged();
//Check access module...
//if(checkAccessModule($module_id) != 1) redirect($fs_denypath);

//Declare prameter when insert data
//khai báo tên bảng tương tác. tương ứng với module. 
$fs_table		= "library_story";
//các trường : primary keys.
$id_field		= "lib_story_id";
$name_field		= "lib_story_title";
//đường dẫn folder chứa ảnh upload.
$imgpath		=	"../../../pictures/library_story/"; 
$imgpath_more_pic		=	"../../../data/library_story/"; 
//định dạng file ảnh dc chấp nhận
$fs_extension	=	"gif,jpg,jpe,jpeg,png,swf";
$mediapath  = "../../../data/vocabulary/";
//k-báo mảng để thay đổi kich cỡ - dung lượng ảnh.
$arr_resize    = array( "small_" => array("quality" => 90, "width" => 150, "height" => 120)
                        ,"medium_" => array("quality" => 90, "width" => 450, "height" => 300)
					           );
//khai báo kích cỡ tối đa file ảnh upload
$fs_filesize	=	20240;
?>