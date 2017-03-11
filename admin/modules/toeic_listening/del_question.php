<?
require_once("inc_security.php");
$fs_redirect	= base64_decode(getValue("returnurl","str","GET",base64_encode("listing.php")));
$record_id		= getValue("record_id","int","GET");
delete_file("ielt_questions","ieque_id",$record_id,"ieque_image",$image_path);
$db_del = new db_execute("DELETE FROM ielt_questions WHERE ieque_id =" . $record_id);
unset($db_del);
redirect($fs_redirect);
?>