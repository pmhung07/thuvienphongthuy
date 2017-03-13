<?
require_once("inc_security.php");
//check quyền them sua xoa
checkAddEdit("delete");
$fs_redirect	= base64_decode(getValue("returnurl","str","GET",base64_encode("listing.php")));
$record_id		= getValue("record_id","int","GET");
//kiểm tra quyền sửa xóa của user xem có được quyền ko
//checkRowUser("lesson_details",$field_id,$record_id,$fs_redirect);
//kiểm tra xóa hết cấp con chưa mới có thể xóa cấp cha
$db_type = new db_query("SELECT skl_cont_type FROM ".$fs_table." WHERE ".$id_field." = " . $record_id);
$row_type = mysqli_fetch_assoc($db_type->result);
switch($row_type['skl_cont_type']){
   case 1:
      $db_select = new db_query("SELECT main_id FROM main_lesson WHERE main_skl_cont_id =" . $record_id);
   case 2:
      $db_select = new db_query("SELECT gram_id FROM grammar_lesson WHERE gram_skl_cont_id =" . $record_id);
   case 3:
      $db_select = new db_query("SELECT voc_id FROM vocabulary_lesson WHERE voc_skl_cont_id =" . $record_id);
   case 4:
      $db_select = new db_query("SELECT learn_wr_id FROM learn_writing WHERE learn_skl_cont_id =" . $record_id);
}

if($row = mysqli_fetch_assoc($db_select->result)){
	echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">';
	echo '<script language="javascript">alert("Bạn chưa xóa hết nội dung chi tiết trong lesson ! Bấm vào xem chi tiết để xóa.");</script>';
	redirect($fs_redirect);
	exit();
}
unset($db_select);

//Delete data with
$db_del = new db_execute("DELETE FROM ".$fs_table." WHERE ".$id_field." = " . $record_id);
unset($db_del);

redirect($fs_redirect);

?>