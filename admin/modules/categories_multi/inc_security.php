<?
$module_id 			= 1;
$module_name		= "Quản lý danh mục";

$fs_table			= "categories_multi";
$id_field			= "cat_id";
$name_field			= "cat_name";
$fs_errorMsg		= "";
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

$add					= "add.php";
$listing				= "listing.php";
//check security...
require_once("../../resource/security/security.php");
//Check user login...
//checkLogged();
//Check access module...
//if(checkAccessModule($module_id) != 1) redirect($fs_denypath);

$array_value 		= array(1 => translate_text("Khóa học")
                           ,2 => translate_text("Cover Letters")
                           ,3 => translate_text("Tin tức"));
$array_config		= array("image" => 0,"upper" => 1,"order" => 1,"description" => 1);								
?>