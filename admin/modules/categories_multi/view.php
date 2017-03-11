<?
include ("inc_security.php");
checkAddEdit("add");
$record_id = getValue("record_id","int","GET","");

$db_cat = new db_query("SELECT cat_picture FROM categories_multi WHERE cat_id = ".$record_id);
$row_cat = mysql_fetch_assoc($db_cat->result);
unset($db_cat);
?>
<img src="<?=$imgpath.$row_cat['cat_picture']?>"/>

