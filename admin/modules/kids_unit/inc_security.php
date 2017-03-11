<?
//include file security
require_once("../../resource/security/security.php");
error_reporting(E_ALL);
ini_set('display_errors', '1');
//id của module- đc khai báo tại trang quản lý admin. Bắt buộc khai báo phải giống module_id đc cấp tại trang tạo mới module

$module_id	= 39;
$module_name= "Quản lý Unit trẻ em";
//Check user login...
//checkLogged();
//Check access module...
//if(checkAccessModule($module_id) != 1) redirect($fs_denypath);

//Declare prameter when insert data
//khai báo tên bảng tương tác. tương ứng với module. 
$fs_table		= "kids_units";
//các trường : primary keys.
$id_field		= "kunit_id";
$name_field		= "kunit_title";

?>