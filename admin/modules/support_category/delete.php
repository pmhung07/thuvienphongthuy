<?
require_once("inc_security.php");
//check quyền them sua xoa
checkAddEdit("delete");
$fs_redirect	= base64_decode(getValue("returnurl","str","GET",base64_encode("listing.php")));
$record_id		= getValue("record_id","int","GET");
$field_id		= "scat_id";
//kiểm tra quyền sửa xóa của user xem có được quyền ko
checkRowUser($fs_table,$field_id,$record_id,$fs_redirect);
//kiểm tra xóa hết cấp con chưa mới có thể xóa cấp cha
$db_select = new db_query("SELECT scat_id FROM " . $fs_table . " WHERE scat_parent_id =" . $record_id);

if($row=mysql_fetch_assoc($db_select->result)){
	echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">';
	echo '<script language="javascript">alert("' . translate_text("Bạn chưa xóa các danh mục con!") . '!");</script>';
	redirect($fs_redirect);
	exit();
}

//Delete data with ID
delete_file($fs_table,"scat_id",$record_id,"scat_picture",$fs_filepath);
$db_del = new db_execute("DELETE FROM ". $fs_table ." WHERE scat_id =" . $record_id);
unset($db_del);
$db_del = new db_execute("DELETE FROM admin_user_category WHERE auc_category_id =" . $record_id);
unset($db_del);

redirect($fs_redirect);

?>