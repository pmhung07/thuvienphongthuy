<?
require_once("inc_security.php");
//check quyền them sua xoa
checkAddEdit("delete");
$fs_redirect	= base64_decode(getValue("returnurl","str","GET",base64_encode("listing.php")));
$record_id		= getValue("record_id","int","GET");
$field_id		= "main_id";
//kiểm tra quyền sửa xóa của user xem có được quyền ko
//checkRowUser($fs_table,$field_id,$record_id,$fs_redirect);

//Delete data with ID
delete_file("main_lesson","main_id",$record_id,"main_media_url1",$imgpath);
delete_file("main_lesson","main_id",$record_id,"main_media_url2",$imgpath);
delete_file("main_lesson","main_id",$record_id,"main_media_url3",$imgpath);
delete_file("main_lesson","main_id",$record_id,"main_media_url4",$imgpath);
delete_file("main_lesson","main_id",$record_id,"main_media_url5",$imgpath);
//delete_file("main_lesson","main_id",$record_id,"main_audio_url",$imgpath);

$db_del = new db_execute("DELETE FROM main_lesson WHERE main_id =" . $record_id);
unset($db_del);

redirect($fs_redirect);

?>