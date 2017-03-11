<?
require_once("inc_security.php");
//check quyền them sua xoa
checkAddEdit("delete");
$fs_redirect	= base64_decode(getValue("returnurl","str","GET",base64_encode("listing.php")));
$record_id		= getValue("record_id","int","GET");
$field_id		= "les_det_id";
//kiểm tra quyền sửa xóa của user xem có được quyền ko
//checkRowUser("lesson_details",$field_id,$record_id,$fs_redirect);
//kiểm tra xóa hết cấp con chưa mới có thể xóa cấp cha
$db_select = new db_query("SELECT gram_id FROM grammar_lesson WHERE gram_det_id =" . $record_id);

if($row=mysql_fetch_assoc($db_select->result)){
	echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">';
	echo '<script language="javascript">alert("Bạn chưa xóa hết nội dung chi tiết có trong lesson ! Bấm vào chi tiết để xóa.");</script>';
	redirect($fs_redirect);
	exit();
}

//Delete data with 
$db_del = new db_execute("DELETE FROM lesson_details WHERE les_det_id =" . $record_id);
unset($db_del);

redirect($fs_redirect);

?>