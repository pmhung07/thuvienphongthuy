<?
include ("inc_security.php");
//check quyền them sua xoa
checkAddEdit("edit");
$record_id = getValue("record_id");
$field =	getValue("field", "str", "GET", "use_active");
$value =	0;
$url = base64_decode(getValue("url", "str", "GET", base64_encode("publisher.php")));
//Lay ra trang thai hien tai
$db_select = new db_query("SELECT " . $field . "
								   FROM	" . $fs_table . "
								   WHERE	" . $id_field . " = " . $record_id);
if($row = mysqli_fetch_assoc($db_select->result)){
	$value = abs($row[$field] - 1);
	$db_active = new db_execute("UPDATE " . $fs_table . "
										  SET " . $field . " = " . $value . "
										  WHERE " . $id_field ." = " . $record_id);
	unset($db_active);
	echo	'<img border="0" src="' . $fs_imagepath . 'check_' . $value . '.gif" />';
}unset($db_select);
?>