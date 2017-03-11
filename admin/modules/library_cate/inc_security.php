<?
$module_id 			= 26;
$module_name		= "Quản lý danh mục thư viện";

$fs_table			= "library_cate";
$id_field			= "lib_cat_id";
$name_field			= "lib_cat_name";
$fs_errorMsg		= "";
//đường dẫn folder chứa ảnh upload.
$imgpath		=	"../../../pictures/library_cat/"; 
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
checkLogged();
//Check access module...
if(checkAccessModule($module_id) != 1) redirect($fs_denypath);

$array_value 		= array(0 => translate_text("--Chọn loại danh mục--")
                         ,1 => translate_text("Game")
                         ,2 => translate_text("Truyện")
                         ,3 => translate_text("Bài hát")
                         ,4 => translate_text("Video"));
$array_config		= array("image" => 0,"upper" => 1,"order" => 1,"description" => 1);								
?>