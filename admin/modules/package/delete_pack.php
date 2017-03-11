<?
include("inc_security.php");
$returnurl 		= base64_decode(getValue("returnurl","str","GET",base64_encode("listing.php")));
$record_id		= getValue("id","str","POST","");
//Delete data with ID
///delete_file($fs_table,$id_field,$record_id,"typ_direct_audio",$data_path);
//$db_del = new db_execute("DELETE FROM ". $fs_table ." WHERE " . $id_field . " IN(" . $record_id . ")");
$db_del = new db_execute("DELETE FROM package_data WHERE padt_id = ". $record_id."");
unset($db_del);
$data['error'] = '';
json_encode($data);
?>