<?
include("inc_security.php");
//check quyền them sua xoa
checkAddEdit("delete");
$fs_redirect	= base64_decode(getValue("returnurl","str","GET",base64_encode("listing.php")));
$record_id		= getValue("record_id","str","POST","0");

//Delete data with ID
delete_file($fs_table,$id_field,$record_id,"uni_test_image",$imgpath);
$db_del = new db_execute("DELETE FROM ". $fs_table ." WHERE " . $id_field . " IN(" . $record_id . ")");
unset($db_del);
//Delete tags
delete_tags($record_id,3,4);
echo translate_text("Lệnh xóa đã được thực thi");
?>