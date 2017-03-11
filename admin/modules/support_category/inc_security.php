<?
$module_id 			= 61;
$module_name		= "Quản lý Post Category";

$fs_table			= "support_category";
$id_field			= "scat_id";
$name_field			= "scat_name";
$fs_errorMsg		= "";
$fs_filepath   	= "../../../pictures/support_category/";
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

$array_value 		= array(0 => translate_text("Chia sẻ ý kiến")
                         ,1 => translate_text("Câu hỏi thường gặp"));
$array_config		= array("image" => 0,"upper" => 1,"order" => 1,"description" => 1);								
?>