<?
	include("inc_security.php");
	//check quyền them sua xoa
	checkAddEdit("delete");

	$record_id		= getValue("record_id","str","POST","0");
	$arr_record 	= explode(",", $record_id);
	$total 			= 0;
	
	foreach($arr_record as $i=>$record_id){
		$record_id = intval($record_id);
		if($record_id > 0){
			//Delete data with ID
			$db_del = new db_execute("DELETE FROM ". $fs_table ." WHERE " . $id_field . " = " . $record_id);
			unset($db_del);
			$total++;
			
			//$user_delete = "User " . $admin_id . " da xoa bai viet : " . $record_id;
			//save_log_info("delete_news" , $user_delete);
		}
	}
	echo "Có " . $total . " bản ghi đã được xóa !";
?>