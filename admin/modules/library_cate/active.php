<?
include ("inc_security.php");
//check quyền them sua xoa
checkAddEdit("edit");

$record_id		=	getValue("record_id");
$sql				=	"";
$type				=	getValue("type","str","GET","",1);
$value			=	getValue("value");
$filed			=	"";
switch($type){
	case "lib_cat_active":
		$filed	=	"lib_cat_active";
	break;
	case "cat_all":
		$filed   =  "cat_all";
	break;
	case "cat_show":
		$filed	=	"cat_show";
	break;
	default:
		$filed	=	"lib_cat_active";
		$value	=	0;
	break;
}
$url				=	base64_decode(getValue("url","str","GET",base64_encode("listing.php")));
$ajax				=	getValue("ajax");
if($ajax==1){
	$db_select = new db_query("SELECT " . $filed . " FROM " . $fs_table . " WHERE lib_cat_id=" . $record_id);
	if($row=mysqli_fetch_assoc($db_select->result)){
		$value = abs($row[$filed]-1);
	}
}
$db_category	= new db_execute("UPDATE " . $fs_table . " SET " . $filed . " = " . $value . " WHERE lang_id = " . $_SESSION["lang_id"] . " AND lib_cat_id=" . $record_id);
//echo "UPDATE " . $fs_table . " SET " . $filed . " = " . $value . " WHERE lang_id = " . $_SESSION["lang_id"] . " AND cat_id=" . $record_id;
unset($db_category);
if($ajax!=1){
	redirect($url);
}else{
	?><img border="0" src="<?=$fs_imagepath?>check_<?=$value?>.gif"><?
}
?>