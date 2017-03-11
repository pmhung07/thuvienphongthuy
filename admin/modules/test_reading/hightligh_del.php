<?
include("inc_security.php");
//check quy?n them sua xoa
checkAddEdit("delete");
$returnurl 		= base64_decode(getValue("returnurl","str","GET",base64_encode("listing.php")));
$record_id		= getValue("record_id","int","GET","0");
$iPara         = getValue("iPara","int","GET","");
$high_id        = getValue("high_id","int","GET",0);

//Delete data with ID
//delete_file($fs_table,$id_field,$record_id,"test_image",$imgpath);
$db_del = new db_execute("DELETE FROM  test_highlight WHERE high_id = " .$high_id);
unset($db_del);
redirect("add_exercises.php?iPara=".$iPara."record_id=".$record_id);

?>