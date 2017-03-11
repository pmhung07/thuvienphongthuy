<?
include("inc_security.php");
//check quyền them sua xoa
checkAddEdit("delete");
$returnurl 		= base64_decode(getValue("returnurl","str","GET",base64_encode("listing.php")));
$record_id		= getValue("record_id","str","POST","0");
//Delete data with ID
//delete_file($fs_table,$id_field,$record_id,"test_image",$imgpath);
$db_del = new db_execute("DELETE FROM ". $fs_table ." WHERE " . $id_field . " IN(" . $record_id . ")");
unset($db_del);
echo translate_text("Lệnh xóa đã được thực thi");
?>