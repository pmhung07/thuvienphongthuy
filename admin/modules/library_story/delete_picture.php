<?
include("inc_security.php");
//check quyền them sua xoa
checkAddEdit("delete");
$map_key		= getValue("map_key", "str", "GET", "");
$returnurl 		= base64_decode(getValue("url","str","GET",base64_encode("more_picture.php")));
$record_id		= getValue("record_id","int","GET","0");

echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">';
delete_file("images_story","img_id",$record_id,"img_url",$imgpath_more_pic);

$db_del	= new db_execute("DELETE FROM images_story 
											WHERE img_id = " . $record_id);
echo '<script language="javascript">alert("Lệnh xóa thành công !")</script>';
unset($db_del);
redirect($returnurl);
?>