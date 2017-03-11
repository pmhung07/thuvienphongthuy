<?
include("inc_security.php");
//check quyền them sua xoa
checkAddEdit("delete");
$fs_redirect	= base64_decode(getValue("returnurl","str","GET",base64_encode("listing.php")));
$record_id		= getValue("record_id","str","POST","0");
//Kiem tra xem xoa het cap con chua moi co the xoa cap cha
$db_check = new db_query("SELECT iety_id FROM ielt_type WHERE iety_ielt_id =" . $record_id);

if($row=mysql_fetch_assoc($db_check->result)){
	echo 'Bạn chưa xóa hết nội dung chi tiết trong Đề thi';
	exit();
}
//Delete data with ID
delete_file($fs_table,$id_field,$record_id,"ielt_image",$imgpath);
$db_del = new db_execute("DELETE FROM ". $fs_table ." WHERE " . $id_field . " IN(" . $record_id . ")");
unset($db_del);
//Delete tags
delete_tags($record_id,3,3);
echo translate_text("Lệnh xóa đã được thực thi");
?>