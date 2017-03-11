<?
include("inc_security.php");
//check quyền them sua xoa
checkAddEdit("delete");
$returnurl 		= base64_decode(getValue("returnurl","str","GET",base64_encode("listing.php")));
$record_id		= getValue("record_id","str","POST","0");
//Delete data with ID

$db_move   = new db_execute('UPDATE get_new_db SET gen_move = 1 WHERE gen_id ='.$record_id);
echo translate_text("Lệnh xóa đã được thực thi");
?>