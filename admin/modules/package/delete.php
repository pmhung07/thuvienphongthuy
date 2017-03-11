<?
include("inc_security.php");
//check quyền them sua xoa
checkAddEdit("delete");
$returnurl 		= base64_decode(getValue("returnurl","str","GET",base64_encode("listing.php")));
$record_id		= getValue("record_id","str","POST","0");
//Delete data with ID
///delete_file($fs_table,$id_field,$record_id,"typ_direct_audio",$data_path);
//$db_del = new db_execute("DELETE FROM ". $fs_table ." WHERE " . $id_field . " IN(" . $record_id . ")");
$db_del = new db_execute("DELETE FROM ". $fs_table ." WHERE " . $id_field ." = ". $record_id."");
$db_del_data = new db_execute("DELETE FROM package_data WHERE padt_pack_id =".$record_id);
unset($db_del_data);
unset($db_del);
echo translate_text("Lệnh xóa đã được thực thi");
?>