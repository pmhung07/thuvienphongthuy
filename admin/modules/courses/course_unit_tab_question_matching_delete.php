<?
include("inc_security.php");
//check quyền them sua xoa
checkAddEdit("delete");
$returnurl 		= base64_decode(getValue("returnurl","str","GET",base64_encode("listing.php")));
$record_id		= getValue("record_id","str","GET","0");
//Delete data with ID
$db_del = new db_execute("DELETE FROM courses_multi_tab_questions WHERE cou_tab_question_id = " .$record_id);
unset($db_del);
//Delete tags
echo translate_text("Lệnh xóa đã được thực thi");
redirect($returnurl);
?>