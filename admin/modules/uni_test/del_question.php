<?
require_once("inc_security.php");
$fs_redirect	= base64_decode(getValue("returnurl","str","GET",base64_encode("listing.php")));
$record_id		= getValue("record_id","int","GET");
$db_del = new db_execute("DELETE FROM uni_quest WHERE uque_id =" . $record_id);
unset($db_del);
redirect($fs_redirect);
?>