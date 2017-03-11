<? 
include ("inc_security.php"); 
//check quyền them sua xoa
checkAddEdit("edit");

$record_id		=	getValue("record_id");
$sql			=	"";
$type			=	getValue("type","str","GET","",1);
$value			=	getValue("value");
$filed			=	"";
switch($type){
	case "act_answers":
		$filed	=	"ans_active";
		$fs_active = "faq_answers";
		$filed_where = '1 AND ans_id';
	break;
	case "act_question":
		$filed   =  "que_active";
		$fs_active = $fs_table;
		$filed_where = ' 1 AND que_id';
	break;
}
$url				=	base64_decode(getValue("url","str","GET",base64_encode("listing.php")));
$ajax				=	getValue("ajax");
if($ajax==1){
	$db_select = new db_query("SELECT " . $filed . " FROM " . $fs_active . " WHERE ".$filed_where."=" . $record_id);
	if($row=mysql_fetch_assoc($db_select->result)){	
		$value = abs($row[$filed]-1);
	}
}
$db_category	= new db_execute("UPDATE " . $fs_active . " SET " . $filed . " = " . $value . " WHERE ".$filed_where."=" . $record_id);
//echo "UPDATE " . $fs_table . " SET " . $filed . " = " . $value . " WHERE lang_id = " . $_SESSION["lang_id"] . " AND cat_id=" . $record_id;
unset($db_category);
if($ajax!=1){
	redirect($url);
}else{
	?><img border="0" src="<?=$fs_imagepath?>check_<?=$value?>.gif"><?
}
?>