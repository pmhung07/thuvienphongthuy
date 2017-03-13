<?
require_once("inc_security.php");
checkAddEdit("add");
//Check
	$iTab = getValue('iTab');
	$iUnit = getValue('iUnit');
	$fs_title = $module_name . " | Danh sách quản lý Tabs";
	$fs_redirect = base64_decode(getValue("url","str","GET",base64_encode("listing.php")));
	$after_save_data = getValue("after_save_data", "str", "POST", "add.php");
	$com_active = 1;

	$myform = new generate_form();

 	$dbquery = new db_query("SELECT * FROM courses_multi_tabs WHERE cou_tab_id =".$iTab);
 	$arrTabs = $dbquery->resultArray();

 	$dbquery2 = new db_query("SELECT * FROM courses_multi WHERE com_id =".$iUnit);
 	$arrUnits = $dbquery2->resultArray();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<?=$load_header?>
<? $myform->checkjavascript();?>
</head>
   	<body>
   	<? /*------------------------------------------------------------------------------------------------*/ ?>
   	<?=template_top($fs_title)?>
   	<? /*------------------------------------------------------------------------------------------------*/ ?>
   	<a style="background: #A0007F;text-decoration: none;color: white;padding: 10px 20px;display: -webkit-inline-box;text-transform: uppercase;" href="course_unit_data.php?iTab=<?=$iTab?>&iUnit=<?=$iUnit?>">Refresh</a>
   	<a style="background: #A0007F;text-decoration: none;color: white;padding: 10px 20px;display: -webkit-inline-box;text-transform: uppercase;" href="<?=$fs_redirect?>">Quay lại quản lý Bài học</a>
   	<div class="navtool">
   		<div class="navtool_title">Tabs : <span><?=$arrTabs[0]['cou_tab_name']?> </span> ---------- Unit : <span><?=$arrUnits[0]['com_name']?> </span></div>
   	</div>
  	<div class="sidebartool">
  		<a href="course_unit_data_video.php?iUnit=<?=$iUnit?>" target="_blank" class="tab_videocodinh">Thêm VIDEO cố định cho Unit</a>
   		<a href="course_unit_tab_data.php?iUnit=<?=$iUnit?>&iTab=<?=$iTab?>" target="_blank" class="tab_noidung" href="">Thêm nội dung cho BÀI HỌC</a>
   		<a href="course_unit_tab_question_multiple_choice.php?iUnit=<?=$iUnit?>&iTab=<?=$iTab?>" target="_blank" class="tab_baitap" href="">Thêm bài tập dạng MULTIPLE CHOICE</a>
   		<a href="course_unit_tab_question_matching.php?iUnit=<?=$iUnit?>&iTab=<?=$iTab?>" target="_blank" class="tab_baitap" href="">Thêm bài tập dạng KÉO THẢ & ĐIỀN TỪ</a>
   		<a href="course_unit_tab_question_recording.php?iUnit=<?=$iUnit?>&iTab=<?=$iTab?>" target="_blank" class="tab_baitap" href="">Thêm bài tập dạng GHI ÂM</a>
   		<a href="course_unit_tab_question_writing.php?iUnit=<?=$iUnit?>&iTab=<?=$iTab?>" target="_blank" class="tab_baitap" href="">Thêm bài tập dạng VIẾT BÀI</a>
  	</div>

	<div class="navtool">
   		<div class="navtool_title">Listing : <span><?=$arrTabs[0]['cou_tab_name']?></span></div>
   		<div class></div>
   	</div>
  	<div class="sidebartool">

  	</div>

   <?=template_bottom() ?>
   <? /*------------------------------------------------------------------------------------------------*/ ?>

   <div style="width:100%;">
	<table cellpadding="5" cellspacing="0" width="100%" style="border-collapse:collapse;" bordercolor="#CCCCCC" border="1">
		<tr style="background: #303030;color:white;">
			<th width="10">ID</th>
			<th width="200">Block Name</th>
			<th width="200">Block Type</th>
			<th width="50">Thứ tự</th>
		</tr>
		<?
		$sql = '';
		$db_picture = new db_query("SELECT * FROM courses_multi_tabs_block WHERE  com_block_tab_id=" . $iTab." ORDER BY com_block_data_order");
		$i=0;
		while($row = mysqli_fetch_assoc($db_picture->result)){ $i++;
		?>
			<tr style="background:#FDD5D5;">
				<td align="center"><?=$i?></td>
	            <td width="200"><?=$row["com_block_data_name"]?></td>
	            <td width="200"><?=$row["com_block_data_type"]?></td>
	            <td width="50" align="center">
	            	<input class="valueordeblockmainr_<?=$row["com_block_id"]?>" style="width:80px;" type="text" value="<?=$row["com_block_data_order"]?>">
		            <span onclick="update_orderblockmain(<?=$row["com_block_id"]?>)" style="cursor:pointer;text-decoration: none;padding: 6px 10px;background: #00C28E;color: white;">Update</span>
	           	</td>
			</tr>
		<? } ?>
	</table>
	</div>


   </body>
</html>

<script type="text/javascript">
function update_orderblockmain(com_id){
   	var order = $('.valueordeblockmainr_'+com_id).val();
	$.ajax({
		type:'POST',
		dataType:'text',
		data:{
			com_id:com_id,
			order:order,
			tab_type:"update_orderblockmain"
      	},
		url:'ajax.php',
		success:function(data){
			if($.trim(data) == 1){
				alert('Update Thứ tự Block thành công');
				window.location.reload();
			}else{
				alert('Xảy ra lỗi trong quá trình xử lý');
			}
      	}
   	});
}
</script>
<style type="text/css">
.tab_videocodinh{
	background: #18A892!important;
}
.tab_noidung{
	background: #1887A8!important;
}
.tab_baitap{
	background: #A85A18!important;
}
.trinvi{display: none;}
.wrap-add-content span:hover{
	background: #1C3D7B!important;
}
.wrap-add-content a:hover{
	background: #1C3D7B!important;
}
.navtool{
	overflow: hidden;
	width: 100%;
}
.navtool_title{
	height: 35px;
	line-height: 35px;
	background: #303030;
	color: white;
	font-size: 11px;
	padding-left: 20px;
	margin-top: 2px;
}
.navtool_title span{
	text-transform: uppercase;
}
.sidebartool{
	float: left;
	width: 100%;
}
.contenttool{
	float: left;
	width: 75%;
	height: 300px;
}
.sidebartool a{
	width: 25%;
	display: block;
	height: 30px;
	line-height: 30px;
	text-decoration: none;
	padding-left: 20px;
	background: #454545;
	color: white;
	margin-bottom: 1px;
}
.sidebartool a:hover{
	margin-left: 5px;
}
</style>