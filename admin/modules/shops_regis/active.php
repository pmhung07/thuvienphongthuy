<?
include ("inc_security.php");
//check quyền them sua xoa
checkAddEdit("edit");

$record_id		=	getValue("record_id");
$sql			=	"";
$value			=	getValue("value");
$filed			=	"sig_active";
$url				=	base64_decode(getValue("url","str","GET",base64_encode("listing.php")));
$ajax				=	getValue("ajax");
if($ajax==1){
	$db_select = new db_query("SELECT " . $filed . " FROM " . $fs_table . " WHERE ".$id_field."=" . $record_id);
	if($row=mysqli_fetch_assoc($db_select->result)){
		$value = abs($row[$filed]-1);
	}
}
$db_category	= new db_execute("UPDATE " . $fs_table . " SET " . $filed . " = " . $value . " WHERE ".$id_field."=" . $record_id);
//echo "UPDATE " . $fs_table . " SET " . $filed . " = " . $value . " WHERE lang_id = " . $_SESSION["lang_id"] . " AND cat_id=" . $record_id;
unset($db_category);
if($ajax!=1){
	redirect($url);
}else{
	?><img border="0" src="<?=$fs_imagepath?>check_<?=$value?>.gif"><?
}
?>