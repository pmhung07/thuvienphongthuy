<?
include("inc_security.php");
//check quyền them sua xoa
checkAddEdit("delete");
$returnurl 		= base64_decode(getValue("returnurl","str","GET",base64_encode("listing.php")));
$record_id		= getValue("record_id","str","POST","0");
//Delete data with ID
delete_file("library_game","lib_game_id",$record_id,"lib_game_image",$imgpath);
delete_file("library_game","lib_game_id",$record_id,"lib_game_url",$imgpath);
$db_del = new db_execute("DELETE FROM ". $fs_table ." WHERE " . $id_field . " IN(" . $record_id . ")");
unset($db_del);
//Delete tags
delete_tags($record_id,4,1);
echo translate_text("Lệnh xóa đã được thực thi");
?>