<?
require_once("inc_security.php");
//check quyền them sua xoa
checkAddEdit("delete");
$fs_redirect	= base64_decode(getValue("returnurl","str","GET",base64_encode("listing.php")));
$record_id		= getValue("record_id","int","GET");
$field_id		= "skl_ext_id";
//kiểm tra quyền sửa xóa của user xem có được quyền ko
//checkRowUser($fs_table,$field_id,$record_id,$fs_redirect);

//Delete data with ID
delete_file("skill_ext","skl_ext_id",$record_id,"skl_ext_media",$mediapath);
delete_file("skill_ext","skl_ext_id",$record_id,"skl_ext_audio",$mediapath);

$db_del = new db_execute("DELETE FROM skill_ext WHERE skl_ext_id =" . $record_id);
unset($db_del);

redirect($fs_redirect);

?>