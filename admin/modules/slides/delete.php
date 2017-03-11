<?
include("inc_security.php");
ob_start();
//check quyền them sua xoa
checkAddEdit("delete");
$returnurl 		= base64_decode(getValue("returnurl","str","GET",base64_encode("listing.php")));
$record_id		= getValue("record_id","int","GET","0");
//Delete data with ID
delete_file($fs_table,$id_field,$record_id,"slide_img",$imgpath);

$db_del = new db_execute("DELETE FROM ". $fs_table ." WHERE " . $id_field . " IN(" . $record_id . ")");
// Dell bảng package
unset($db_del);
header($returnurl);
ob_clean();
?>