<?
include("inc_security.php");
checkAddEdit("delete");
$returnurl 		= base64_decode(getValue("returnurl","str","GET",base64_encode("listing.php")));
$record_id		= getValue("record_id","int","GET","0");
$que_id        = getValue("que_id","int","GET",0);

//Delete data with ID
//delete_file($fs_table,$id_field,$record_id,"test_image",$imgpath);
$db_del = new db_execute("DELETE FROM questions WHERE que_id = " .$que_id);
unset($db_del);
redirect("confirmation.php?record_id=".$record_id);

?>