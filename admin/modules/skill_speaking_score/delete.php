<?
include("inc_security.php");
//check quyền them sua xoa
checkAddEdit("delete");
$fs_redirect	= base64_decode(getValue("returnurl","str","GET",base64_encode("listing.php")));
$record_id		= getValue("record_id","str","POST","0");

$db_data 	    = new db_query("SELECT * FROM learn_speak_result WHERE " . $id_field . " = " . $record_id);
$row            = mysqli_fetch_assoc($db_data ->result);
$audio = $row['lsr_audio'];
unlink($data_path.trim($audio));

$db_del = new db_execute("DELETE FROM ". $fs_table ." WHERE " . $id_field . " IN(" . $record_id . ")");
unset($db_del);

echo translate_text("Lệnh xóa đã được thực thi");
?>