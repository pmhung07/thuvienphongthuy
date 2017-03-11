<?
$module_id 			= 21;
$module_name		= "Quản lý Post Category";

$fs_table			= "post_category";
$id_field			= "pcat_id";
$name_field			= "pcat_name";
$fs_errorMsg		= "";
$fs_filepath   	= "../../../pictures/post_category/";
$limit_size			= 750;
$extension_list	= "jpg,gif,png";
$add					= "add.php";
$listing				= "listing.php";
//check security...
require_once("../../resource/security/security.php");
//Check user login...
checkLogged();
//Check access module...
if(checkAccessModule($module_id) != 1) redirect($fs_denypath);

$array_value 		= array(0 => translate_text("Trang tĩnh")
                         ,1 => translate_text("Trang động"));
$array_config		= array("image" => 0,"upper" => 1,"order" => 1,"description" => 1);								
?>