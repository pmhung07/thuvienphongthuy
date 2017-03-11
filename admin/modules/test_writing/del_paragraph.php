<?
require_once("inc_security.php");
//check quy?n them sua xoa
checkAddEdit("delete");
$fs_redirect	= base64_decode(getValue("returnurl","str","GET",base64_encode("listing.php")));
$record_id		= getValue("record_id","int","GET");
$field_id     = "tec_id";
//ki?m tra quy?n s?a xóa c?a user xem có du?c quy?n ko
//checkRowUser($fs_table,$field_id,$record_id,$fs_redirect);

//delete_file("main_lesson","main_id",$record_id,"main_audio_url",$imgpath);

$db_del = new db_execute("DELETE FROM test_content WHERE tec_id =" . $record_id);
unset($db_del);

redirect($fs_redirect);

?>