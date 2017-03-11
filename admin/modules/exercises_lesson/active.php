<? 
include ("inc_security.php"); 
//check quyền them sua xoa
checkAddEdit("edit");

$record_id		=	getValue("record_id");
$field			=	getValue("field", "str", "GET", "exe_active");
$value			=	0;
$iCat				=	0;

//Lay ra trang thai hien tai
$db_select  =	new db_query("SELECT " . $field . ", exe_id
									  FROM	" . $fs_table . "
								  	  WHERE	" . $id_field . " = " . $record_id);
if($row	=	mysql_fetch_assoc($db_select->result)){
   $value			=	abs($row[$field] - 1);
	$iCat				=	$row['exe_id'];
	$db_active	= new db_execute("UPDATE " . $fs_table . "
											SET " . $field . " = " . $value . "
											WHERE " . $id_field ." = " . $record_id);
	
	unset($db_active);
	echo	'<img border="0" src="' . $fs_imagepath . 'check_' . $value . '.gif" />';
}
unset($db_select);
?>