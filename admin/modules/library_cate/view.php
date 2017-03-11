<?
include ("inc_security.php");
checkAddEdit("add");
$record_id = getValue("record_id","int","GET","");

$db_cat = new db_query("SELECT lib_cat_picture FROM ".$fs_table." WHERE lib_cat_id = ".$record_id);
$row_cat = mysql_fetch_assoc($db_cat->result);
unset($db_cat);
?>
<img src="<?=$imgpath.$row_cat['lib_cat_picture']?>"/>

