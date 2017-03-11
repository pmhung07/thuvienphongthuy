<?
include("inc_security.php");
//check quyền them sua xoa
checkAddEdit("delete");
$returnurl 		= base64_decode(getValue("returnurl","str","GET",base64_encode("listing.php")));
$record_id		= getValue("record_id","str","POST","0");
//Delete data with ID
$db_del = new db_execute("DELETE FROM ". $fs_table ." WHERE " . $id_field . " IN(" . $record_id . ")");
$msg = "Có 1 bản ghi đã được xóa !";
unset($db_del);
?>