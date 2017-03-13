<?
require_once("inc_security.php");
//check quyền them sua xoa
checkAddEdit("delete");
$fs_redirect	= base64_decode(getValue("returnurl","str","GET",base64_encode("listing.php")));
$record_id	= getValue("record_id","int","GET",0);
$type_del		= getValue('type','str',"GET",'');
switch ($type_del) {
	case 'del_comment':
		# code...
		$db_del = new db_execute("DELETE FROM ". $fs_table ." WHERE com_id =" . $record_id);
		$db_del_rep = new db_execute("DELETE FROM ".$fs_table_reply." WHERE rep_comment_id=".$record_id);
		unset($db_del_rep);
		break;
	case 'del_reply':
		# code...
		$db_del = new db_execute("DELETE FROM ".$fs_table_reply." WHERE rep_id =" . $record_id);
		break;
}
//kiểm tra quyền sửa xóa của user xem có được quyền ko
//checkRowUser($fs_table,$field_id,$record_id,$fs_redirect);
//kiểm tra xóa hết cấp con chưa mới có thể xóa cấp cha
//$db_select = new db_query("SELECT com_id FROM " . $fs_table . " WHERE com_parent_id =" . $record_id);
/*
if($row=mysqli_fetch_assoc($db_select->result)){
	echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">';
	echo '<script language="javascript">alert("' . translate_text("You must delete all the levels of this category") . '!");</script>';
	redirect($fs_redirect);
	exit();
}*/

//Delete data with ID
//delete_file($fs_table,"que_id",$record_id,"com_picture",$imgpath);
unset($db_del);
redirect($fs_redirect);

?>