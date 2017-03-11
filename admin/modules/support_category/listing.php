<?
require_once("inc_security.php");

$list = new fsDataGird($id_field,$name_field,translate_text("Listing"));

$scat_type 			= getValue("scat_type","str","GET","");
$iCat		 			= getValue("iCat");

$sql					=	"1";
$sql2					=	"";
if($scat_type != ""){
	$sql	=	"scat_type = '" . $scat_type . "'";
	$sql2	=	" AND scat_type = '" . $scat_type . "'";
}

$menu = new menu();
$listAll = $menu->getAllChild("support_category","scat_id","scat_parent_id",$iCat,$sql . " AND lang_id = " . $lang_id . $sqlcategory,"scat_id,scat_name,scat_order,scat_type,scat_parent_id,scat_has_child,scat_picture,scat_active,admin_id","scat_type ASC,scat_order ASC, scat_name ASC","scat_has_child");

$arrayCat = array(0=>translate_text("Danh mục"));


$db_cateogry = new db_query("SELECT scat_type,scat_name,scat_id
										FROM support_category
										WHERE scat_parent_id = 0" . $sql2);
while($row = mysql_fetch_array($db_cateogry->result)){
	$arrayCat[$row["scat_id"]] = $row["scat_name"];
}

$list->addSearch(translate_text("Chọn loại danh mục"),"scat_type", "array", $array_value, $scat_type);
$list->addSearch(translate_text("Danh mục"),"iCat","array",$arrayCat,$iCat);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<?=$load_header?>
</head>
<body topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0">
<? /*------------------------------------------------------------------------------------------------*/ ?>
<?=template_top(translate_text("Category listing"),$list->urlsearch())?>
	<?
	if(!is_array($listAll)) $listAll = array();
	?>
	<table border="1" cellpadding="3" cellspacing="0" class="table" width="100%" bordercolor="<?=$fs_border?>">
		<tr> 
			<td class="bold bg" width="5"><input type="checkbox" id="check_all" onClick="check('1','<?=count($listAll)+1?>')"/></td>
			<td class="bold bg" width="2%" nowrap="nowrap" align="center"><img src="<?=$fs_imagepath?>save.png" border="0"/></td>
			<?
			if($array_config["image"]==1){
			?>
			<td class="bold bg" width="5%" nowrap="nowrap" align="center"><?=translate_text("Image")?></td>
			<?
			}
			?>
			<td class="bold bg" ><?=translate_text("Tên danh mục")?></td>
			<?
			if($array_config["order"]==1){
			?>
			<td class="bold bg" align="center"><?=translate_text("order")?></td>
			<?
			}
			?>
			<td class="bold bg" align="center" width="5"><?=translate_text("Active")?></td>				
			<td class="bold bg" align="center" width="16"><img src="<?=$fs_imagepath?>edit.png" border="0" width="16"/></td>
			<td class="bold bg" align="center" width="16"><img src="<?=$fs_imagepath?>delete.gif" border="0"/></td>
		</tr>
		<form action="quickedit.php?returnurl=<?=base64_encode(getURL())?>" method="post" name="form_listing" id="form_listing" enctype="multipart/form-data">
		<input type="hidden" name="iQuick" value="update" />	
		<? 
		
		$i=0;
		$scat_type = '';
		foreach($listAll as $key=>$row){ $i++;
		?>
		<?
		if($scat_type != strtolower($row["scat_type"])){
			$scat_type = strtolower($row["scat_type"]);
		?>
			<tr>
				<td colspan="14" align="center" class="bold" bgcolor="#FFFFCC" style="color:#FF0000; padding:6px;"><?=isset($array_value[$scat_type]) ?  $array_value[$scat_type] : ''?></td>
			</tr>
		<?
		}
		?>
		<tr <? if($i%2==0) echo ' bgcolor="#FAFAFA"';?>>
			<td <? if($row["admin_id"] == $admin_id) echo ' bgcolor="#FFFF66"';?>>
				<input type="checkbox" name="record_id[]" id="record_<?=$row["pcat_id"]?>_<?=$i?>" value="<?=$row["scat_id"]?>"/>
			 </td>
			<td width="2%" nowrap="nowrap" align="center"><img src="<?=$fs_imagepath?>save.png" border="0" style="cursor:pointer" onClick="document.form_listing.submit()" alt="Save"></td>
			<?
			if($array_config["image"]==1){
			?>
			<td align="center">
				<?
				$path = $fs_filepath . $row["scat_picture"];
				if($row["scat_picture"] != "" && file_exists($path)){
					echo '<a rel="tooltip"  title="<img src=\'' . $fs_filepath . $row["pcat_picture"] . '\' border=\'0\'>" href="#"><img  src="' . $fs_filepath . $row["scat_picture"] . '"  style="cursor:pointer" width=120 height=20 border=\'0\'></a>';
					?><a href="delete_pic.php?record_id=<?=$row["pcat_id"]?>&url=<?=base64_encode($_SERVER['REQUEST_URI'])?>"><img src="<?=$fs_imagepath?>delete.gif" border="0" /></a><?
				}
				?>
				<input type="file" name="picture<?=$row["scat_id"]?>" id="picture<?=$row["scat_id"]?>" class="form" onchange="check_edit('record_<?=$row["scat_id"]?>_<?=$i?>')" size="10">			
			</td>
			<?
			}
			?>
			<td nowrap="nowrap">
				<?
				for($j=0;$j<$row["level"];$j++) echo "|----";
				?>
				<input type="text"  name="cat_name<?=$row["scat_id"];?>" id="cat_name<?=$row["scat_id"];?>" onKeyUp="check_edit('record_<?=$row["scat_id"]?>_<?=$i?>')" value="<?=$row["scat_name"];?>" class="form" size="50">
			</td>
			
			<td align="center"><input type="text" size="2" class="form" value="<?=$row["scat_order"]?>" onKeyUp="check_edit('record_<?=$row["pcat_id"]?>_<?=$i?>')" id="cat_order<?=$row["pcat_id"]?>" name="cat_order<?=$row["pcat_id"]?>"></td>
			<td align="center"><a onClick="loadactive(this); return false;" href="active.php?record_id=<?=$row["scat_id"]?>&type=cat_active&value=<?=abs($row["pcat_active"]-1)?>&url=<?=base64_encode(getURL())?>"><img border="0" src="<?=$fs_imagepath?>check_<?=$row["scat_active"];?>.gif" title="Active!"></a></td>
            <td align="center" width="16"><a class="text" href="edit.php?record_id=<?=$row["scat_id"]?>&returnurl=<?=base64_encode(getURL())?>"><img src="<?=$fs_imagepath?>edit.png" alt="EDIT" border="0"></a></td>
			<td align="center"><img src="<?=$fs_imagepath?>delete.gif" alt="DELETE" border="0" onClick="if (confirm('Are you sure to delete?')){ window.location.href='delete.php?record_id=<?=$row["scat_id"]?>&returnurl=<?=base64_encode(getURL())?>'}" style="cursor:pointer"></td>
			
		</tr>
		<? } ?>
		</form>
		</table>
<?=template_bottom() ?>
<? /*------------------------------------------------------------------------------------------------*/ ?>
</body>
</html>
