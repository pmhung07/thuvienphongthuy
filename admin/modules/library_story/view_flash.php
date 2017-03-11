<?
include ("inc_security.php");
checkAddEdit("add");
$fs_action = getURL();
$record_id = getValue("record_id","int","GET","");
$game_url = getValue("game_url","str","GET","");
?>