<?
require_once("inc_security.php");
//check quyền them sua xoa
checkAddEdit("delete");
$fs_redirect	= base64_decode(getValue("returnurl","str","GET",base64_encode("listing.php")));
$record_id		= getValue("record_id","int","GET");
$field_id		= "lib_song_id";
//kiểm tra quyền sửa xóa của user xem có được quyền ko
//checkRowUser($fs_table,$field_id,$record_id,$fs_redirect);

//Delete data with ID
delete_file($fs_table,"lib_song_id",$record_id,"lib_song_image",$imgpath);
delete_file($fs_table,"lib_song_id",$record_id,"lib_song_url",$songpath);
$db_del = new db_execute("DELETE FROM ". $fs_table ." WHERE lib_song_id =" . $record_id);
unset($db_del);
//Delete tags
delete_tags($record_id,4,3);
redirect($fs_redirect);

?>