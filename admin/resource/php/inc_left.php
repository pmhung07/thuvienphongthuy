<div class="left_title">
	<?=translate_text("Menu")?>
</div>
<?
$isAdmin = isset($_SESSION["isAdmin"]) ? intval($_SESSION["isAdmin"]) : 0;
$user_id = isset($_SESSION["user_id"]) ? intval($_SESSION["user_id"]) : 0;
$sql = '';
if($isAdmin != 1){
	$sql = ' INNER JOIN admin_user_right ON(adu_admin_module_id  = mod_id AND adu_admin_id = ' . $user_id . ')';
}

$db_order = new db_query("SELECT * FROM admin_menu_order WHERE amo_admin = " . $user_id . " ORDER BY amo_order ASC");

$db_menu = new db_query("SELECT *
								 FROM modules
								 " . $sql . "
								 ORDER BY mod_order ASC");
$arrayTemp = array();
$arrayModule = array();
while($row = mysqli_fetch_assoc($db_menu->result))  $arrayTemp[$row["mod_id"]] = $row;

while($ord=mysqli_fetch_assoc($db_order->result)){
	if(isset($arrayTemp[$ord["amo_module"]])){
		$arrayModule[$ord["amo_module"]] = $arrayTemp[$ord["amo_module"]];
		unset($arrayTemp[$ord["amo_module"]]);
	}
}
foreach($arrayTemp as $key=>$ord){
	$arrayModule[$ord["mod_id"]] = $arrayTemp[$ord["mod_id"]];
	$db_ex = new db_execute("REPLACE INTO admin_menu_order(amo_admin,amo_module) VALUES(" . $user_id . "," . $ord["mod_id"] . ")");
}
unset($arrayTemp);
unset($db_menu);
unset($db_order);
?>
<ul id="test-list">
	<?
	$i=0;
	foreach($arrayModule as $key=>$row){
		if(file_exists("modules/" . $row["mod_path"] . "/inc_security.php")===true){
			$i++;
			?>
			<li id="listItem_<?=$row["mod_id"]?>">
				<table cellpadding="3" cellspacing="0" width="100%">
					<tr>
						<td width="10"><img src="resource/images/show.png" style="cursor:pointer" id="image_<?=$i?>" onclick="showhidden(<?=$i?>);" title="<?=translate_text("Show list menu")?>" /></td>
						<td class="t"><span style="cursor:pointer" onclick="showhidden(<?=$i?>);"><?=$row["mod_name"]?></span></td>
						<td width="10"><img src="resource/js/sortable/arrow.png" title="<?=translate_text("Move")?>" class="handle" /></td>
					</tr>
					<tbody id="showmneu_<?=$i?>" bgcolor="#FFFFFF" style="display:none">
						<?
						$arraySub = explode("|",$row["mod_listname"]);
						$arrayUrl = explode("|",$row["mod_listfile"]);
						?>
						<?
						foreach($arraySub as $key=>$value){
							$url = isset($arrayUrl[$key]) ? $arrayUrl[$key] : '#';
						?>
						<tr>
							<td width="6" align="center"><img src="resource/images/4.gif" border="0" /></td>
							<td colspan="2" class="m"><a href="modules/<?=$row["mod_path"]?>/<?=$url?>" target="mainFrame"><?=$value?></a></td>
						</tr>
						<?
						}
						?>
					</tbody>
				</table>
			</li>
			<?
		}
	}
	?>
</ul>
<script language="javascript">
	function showhidden(divid){
		var object = document.getElementById("showmneu_"+divid);
		var objectimg = document.getElementById("image_"+divid);
		if(object.style.display == 'none'){
			object.style.display = '';
			objectimg.src = 'resource/images/hidden.png';
		}else{
			object.style.display = 'none';
			objectimg.src = 'resource/images/show.png';
		}
	}
</script>