<?
include("inc_security.php");
//check quy?n them sua xoa
checkAddEdit("delete");
$returnurl 		= base64_decode(getValue("returnurl","str","GET",base64_encode("listing.php")));
$record_id		= getValue("record_id","int","GET","0");
$iPara         = getValue("iPara","int","GET","");
$fil_id        = getValue("fil_id","int","GET",0);
$que_id        = getValue("teque_id","int","GET",0);

//Delete data with ID
//delete_file($fs_table,$id_field,$record_id,"test_image",$imgpath);
$db_del_ques = new db_execute("DELETE FROM test_questions WHERE teque_id = " .$que_id);
unset($db_del_ques);
$db_del_fill = new db_execute("DELETE FROM test_fillwords WHERE fil_id = " .$fil_id);
unset($db_del_fill);
redirect("add_exercises.php?iPara=".$iPara."&record_id=".$record_id);
?>