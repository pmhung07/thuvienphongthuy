<?
include("inc_security.php");
//check quyền them sua xoa
checkAddEdit("delete");
$returnurl 		= base64_decode(getValue("returnurl","str","GET",base64_encode("listing.php")));
$record_id		= getValue("record_id","str","GET","0");
//Delete data with ID
$db_del = new db_execute("DELETE FROM courses_multi_tabs_content WHERE cou_tab_cont_id IN(" . $record_id . ")");
//Delete tags
unset($db_del);
redirect($returnurl);
?>