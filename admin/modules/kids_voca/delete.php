<?
require_once("inc_security.php");
//check quyền them sua xoa
checkAddEdit("delete");
$fs_redirect	= base64_decode(getValue("returnurl","str","GET",base64_encode("listing.php")));
$record_id		= getValue("record_id","int","GET");
$field_id		= "kvcb_ent_id";
//kiểm tra quyền sửa xóa của user xem có được quyền ko
//checkRowUser("lesson_details",$field_id,$record_id,$fs_redirect);
//kiểm tra xóa hết cấp con chưa mới có thể xóa cấp cha

//Delete data with 
$db_del = new db_execute("DELETE FROM kids_vcb_entries WHERE kvcb_ent_id =" . $record_id);
unset($db_del);

redirect($fs_redirect);

?>