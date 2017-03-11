<?
require_once("inc_security.php");
checkAddEdit("add");

$iTab = getValue('iTab');
$iUnit = getValue('iUnit');
error_reporting(E_ALL);
$fs_title = $module_name . " | Thêm nội dung cho phần bài tập dạng Recording ( Tabs )";
$fs_redirect = base64_decode(getValue("url","str","GET",base64_encode("listing.php")));
$after_save_data = getValue("after_save_data", "str", "POST", "add.php");
$com_active = 1;
$fs_errorMsg = "";
$fs_fieldupload = "";

$myform = new generate_form();

$dbquery2 = new db_query("SELECT * FROM courses_multi WHERE com_id =".$iUnit);
$arrUnits = $dbquery2->resultArray();

 	/*
Call class form:
1). Ten truong
2). Ten form
3). Kieu du lieu , 0 : string , 1 : kieu int, 2 : kieu email, 3 : kieu double, 4 : kieu hash password
4). Noi luu giu data  0 : post, 1 : variable
5). Gia tri mac dinh, neu require thi phai lon hon hoac bang default
6). Du lieu nay co can thiet hay khong
7). Loi dua ra man hinh
8). Chi co duy nhat trong database
9). Loi dua ra man hinh neu co duplicate
*/
//$cou_tab_cont_media = 1;
$cou_tab_cont_active = 1;
$cou_tab_question_status = 1;
$cou_tab_question_type = "recording";

$myform = new generate_form();
$myform->add("cou_tab_question_tabs_id", "iTab", 1, 1, "", 0, "", 0, "");
$myform->add("cou_tab_question_block_id", "cou_tab_cont_block_id", 1, 0, "", 0, "", 0, "");
$myform->add("cou_tab_question_title", "cou_tab_question_title", 0, 0, "", 0, "", 0, "");
$myform->add("cou_tab_question_content", "cou_tab_question_content", 0, 0, "", 0, "", 0, "");
$myform->add("cou_tab_question_status", "cou_tab_question_status", 1, 1, 0, 0, "", 0, "");
$myform->add("cou_tab_question_order", "cou_tab_question_order", 1, 0, 0, 0, "", 0, "");
$myform->add("cou_tab_question_type", "cou_tab_question_type", 0, 1, "", 0, "", 0, "");
//Add table insert data
$myform->addTable("courses_multi_tab_questions");
//Get action variable for add new data
$action				= getValue("action", "str", "POST", "");
//Check $action for insert new data
if($action == "execute"){
	$fs_errorMsg 	.= $myform->checkdata();
	if($fs_errorMsg == ""){
		$myform->removeHTML(0);
		$db_insert		= new db_execute($myform->generate_insert_SQL());
		redirect($_SERVER['REQUEST_URI']);
	}
}

$db_block = new db_query("SELECT * FROM courses_multi_tabs_block WHERE  com_block_tab_id=" . $iTab . " AND com_block_data_type ='question_recording'");
$arrayBlock = array();
$arrayBlock[0] = "Chọn Block để thêm nội dung";
$i=1;
while($row = mysql_fetch_assoc($db_block->result)){
	$arrayBlock[$row['com_block_id']] = $row['com_block_data_name'];
	$i++;
}


$arrayMedia = array(
	0 => "Chon kiểu Media",
	1 => "Kiểu Video",
	2 => "Kiểu Audio",
	3 => "Kiểu Images"
);

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
   	<div class="navtool" style="width:100%;">
   		<div class="navtool_title">Unit : <span><?=$arrUnits[0]['com_name']?></span></div>
   	</div>

   	<? /*------------------------------------------------------------------------------------------------*/ ?>
	<div style="width:100%;background: #E2EDFC;">

	<div class="addblockintab" style="height: 50px;line-height: 50px;background: #BD0000;">
		<input class="addblock_<?=$iTab?>" style="height: 25px;border: none;margin-left: 115px;" type="text" value ="Tiêu đề Block">
		<span onclick="addblockintab(<?=$iTab?>)" style="cursor: pointer;height: 25px;background: rgb(48, 48, 48);padding: 7px 10px;color: white;font-weight: bold;">Thêm Block</span>
	</div>

	<?
	$form = new form();
	$form->create_form("add", $_SERVER['REQUEST_URI'], "post", "multipart/form-data",'onsubmit="validateForm(); return false;"');
	$form->create_table();
	?>
	<?=$form->text_note('Những ô có dấu sao (<font class="form_asterisk">*</font>) là bắt buộc phải nhập.')?>
	<?=$form->errorMsg($fs_errorMsg)?>
	<?=$form->select("Chọn Block", "cou_tab_cont_block_id", "cou_tab_cont_block_id", $arrayBlock, 0 ,"Chọn Block để thêm nội dung",1,"498",1,0,"","")?>
	<?=$form->text("Tiêu đề", "cou_tab_question_title", "cou_tab_question_title", "", "Tiêu đề", 0, 489, 20, 255, "", "", "")?>
	<?//=$form->textarea("Nội dung dạng bài tập", "cou_tab_question_content", "cou_tab_question_content", "", "Nội dung", 0, 500, 20, 255, "", "", "style='resize:none;'")?>
   	<tr>
		<td class="form_name">Nội dung bài tập :</td>
		<td class="form_text">
			<textarea class="cou_tab_question_content" id="cou_tab_question_content" name="cou_tab_question_content" style="width:500px;height: 50px;"></textarea>
			<script src="/../../js/tinymce/tinymce.min.js" type="text/javascript" charset="utf-8"></script>
			<script type="text/javascript">
		   	tinymce.init({
				selector: "textarea",   
				plugins: [
					"advlist autolink lists link image charmap print preview hr anchor pagebreak",
					"searchreplace wordcount visualblocks visualchars code fullscreen",
					"insertdatetime media nonbreaking save table contextmenu directionality",
					"emoticons template paste textcolor jbimages"
		      	],
		      	toolbar1: "cut copy paste pastetext pasteword | insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | tablecontrols | bullist numlist outdent indent | link image ",
		      	toolbar2: "print preview media | forecolor backcolor emoticons jbimages |styleselect formatselect fontselect fontsizeselect",
		      	image_advtab: true,
		      	relative_urls : false,
		      	templates: [
		         	{title: 'Test template 1', content: 'Test 1'},
		         	{title: 'Test template 2', content: 'Test 2'}
		      	] 
		   	});
		   	</script>  
		</td>
	</tr>
   	<?=$form->text("Thứ tự", "cou_tab_question_order", "cou_tab_question_order", "", "Thứ tự", 0, 40, "", 255, "", "", "")?>
	<?=$form->button("submit" . $form->ec . "reset", "submit" . $form->ec . "reset", "submit" . $form->ec . "reset", "Cập nhật" . $form->ec . "Đóng cửa sổ", "Cập nhật" . $form->ec . "Đóng cửa sổ", 'style="background:url(' . $fs_imagepath . 'button_1.gif) no-repeat"' . $form->ec . 'style="background:url(' . $fs_imagepath . 'button_2.gif)" onclick="window.parent.tb_remove()"', "");?>
	<?=$form->hidden("action", "action", "execute", "");?>
	<?//=$form->hidden("ppic_temp_key", "ppic_temp_key", $temp_key, "");?>
	<?
	$form->close_table();
	$form->close_form();
	unset($form);
	?>
	</div>
	
<? /*------------------------------------------------------------------------------------------------*/ ?>
	<div style="width:100%;">
	<table cellpadding="5" cellspacing="0" width="100%" style="border-collapse:collapse;" bordercolor="#CCCCCC" border="1">
		<tr style="background: #303030;color:white;">
			<th width="10">ID</th>
			<th width="200">Tiêu đề</th>
			<th width="50">Sửa</th></th>
			<th width="20" align="center">Xóa</th>
		</tr>
		<?
		$sql = '';
		$db_picture = new db_query("SELECT * FROM courses_multi_tabs_block WHERE  com_block_tab_id=" . $iTab . " AND com_block_data_type ='question_recording'");
		?>

		<?
		$i=0;
		while($row = mysql_fetch_assoc($db_picture->result)){ $i++;
		?>
			<tr style="background:#FDD5D5;">
				<td align="center"><?=$i?></td>
	            <td colspan="2" width="200">
	            	<input class="update_blockname_<?=$row["com_block_id"]?>" type="text" class="update_blockname" value="<?=$row["com_block_data_name"]?>">
		            <span onclick="update_blockname(<?=$row["com_block_id"]?>)" style="cursor:pointer;text-decoration: none;padding: 6px 10px;background: #0054C2;color: white;">Save</span>
	            </td>
	            <td width="50" align="center"><img src="<?=$fs_imagepath?>delete.gif" alt="DELETE" border="0" onClick="if (confirm('Are you sure to delete?')){ window.location.href='course_unit_data_block_delete.php?record_id=<?=$row["com_block_id"]?>&returnurl=<?=base64_encode(getURL())?>'}" style="cursor:pointer"></td>
	        </tr>
			<? 
			$db_content = new db_query("SELECT * FROM courses_multi_tab_questions WHERE cou_tab_question_tabs_id =".$iTab." AND cou_tab_question_block_id=".$row["com_block_id"]." ORDER BY cou_tab_question_order");
			$countarrContent = $db_content->resultArray(); 
			$j = 0;
			if(count($countarrContent) > 0){ 
				foreach($countarrContent as $key=>$value){ $j++;
			?>
			<tr style="background:rgb(179, 218, 200);border-bottom: solid 1px white;">
				<td align="center"><?=$j?></td>
	            <td width="200">
	            	<?=$value["cou_tab_question_title"]?>
	            </td>
	            <td width="100" align="center">
	            	<a style="padding:5px 0px 5px 6px;text-decoration:none;" title="Add audio" class="thickbox noborder a_detail" href="course_unit_tab_question_recording_edit.php?iQues=<?=$value['cou_tab_question_id']?>'&url=<?=base64_encode(getURL())?>'&TB_iframe=true&amp;height=350&amp;width=1000">
	                  <b style="background: none repeat scroll 0 0;color: black;padding: 2px 10px;">Update Câu hỏi này</b>
	               </a>
	            </td>
	            <td align="center"><a onclick="if (confirm('Bạn muốn xóa bản ghi?')){ window.location.href='course_unit_tab_question_recording_delete.php?record_id=<?=$value["cou_tab_question_id"]?>&url=<?=base64_encode($_SERVER['REQUEST_URI'])?>' }" href="#" class="delete"><img border="0" src="<?=$fs_imagepath?>delete.gif"></a></td>
			</tr>
			<? } } ?>
		<? } ?>
	</table>
	</div>
   <?=template_bottom() ?>
   <? /*------------------------------------------------------------------------------------------------*/ ?>
   </body>
</html>

<script type="text/javascript">
function addblockintab(tab_id){
	var blockname = $(".addblock_"+tab_id).val();
	$.ajax({
		type:'POST',
		dataType:'text',
		data:{
			tab_id:tab_id,
			tab_type:"addblockintabquesrecording",
			blockname:blockname
      	},
		url:'ajax.php',
		success:function(data){
			if($.trim(data) == 1){
				alert('Add Block thành công');	
				window.location.reload();
			}else{
				alert('Xảy ra lỗi trong quá trình xử lý');
			}
      	}
   	});
}
function update_blockname(cou_block_id){
   	var blockname = $('.update_blockname_'+cou_block_id).val();
	$.ajax({
		type:'POST',
		dataType:'text',
		data:{
			cou_block_id:cou_block_id,
			blockname:blockname,
			tab_type:"update_blockname"
      	},
		url:'ajax.php',
		success:function(data){
			if($.trim(data) == 1){
				alert('Update Tên Block thành công');	
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
.a_detail{padding: 0px 13px;border: solid 1px;background: #EEE;text-decoration: none;margin: 6px 4px;color: #8C99A5;float: left;height: 18px;line-height: 18px;}
#wr_list_answer{float: left;margin:10px 0px 30px 30px;border-right: solid 1px #eee;border: solid 1px #eee;width: 940px;}
#list_title{width: 933px;float: left;background: #E0EBF6;padding: 4px 0px 4px 7px;color: #616D76;font-weight: bold;text-align: center;height: 15px;line-height: 15px;}
#wr_detail{width: 100%;height: 100%;}
#detail_title{width: 490px;float: left;background: #eee;color: #616D76;font-weight: bold;height: 23px;line-height: 23px;}
#wr_detail_info{float: left;width: 100%;border-bottom: solid 1px #eee;}
#wr_detail_answer{float: left;margin:10px 0px 0px 12px;border-right: solid 1px #eee;border: solid 1px #eee;width: 490px;}
#wr_detail_media{float: left;margin:10px 0px 0px 11px;border-right: solid 1px #eee;border: solid 1px #eee;width: 495px;}
#wr_detail_left{float: left;width: 420px;}
#detail_content{float: left;width: 406px;padding:5px 0px 5px 4px;border-bottom: dotted 1px #eee;}
#multi_choice{float: left;width: 485px;height:243px;padding:5px 0px 5px 4px;overflow: scroll;}
#drag{float: left;width: 485px;padding: 5px 0px 5px 4px;}
#fill_word{float: left;width: 485px;padding: 5px 0px 5px 4px;height:243px;overflow: scroll;}
#media{float: left;width: 490px;padding:5px 0px 5px 4px;}
#content_multi_choice{float: left;width: 406px;padding-left: 4px;}
#dv_add_action{float: left;width: 100%;}
#im_note{float: left;width: 406px;padding:5px 0px 5px 4px;}
#im_note p{float: left;width: 406px;padding: 5px 0px 0px 4px;color: red;margin: 0px;}
#para_detail{float: left;padding-left: 10px;width: 475px;height: 250px;overflow: scroll;}
.dv_add_action_invi{display: none;}
.p_info{padding:10px 12px;float: left;width: 100%;margin: 0px;}
.b_info{color: red;}
.a_submit{border: solid 1px #5E6C77;padding: 3px 15px;background: #EEE;color: #E27A13;font-weight: bold;margin: 0px 4px;float: left;cursor: pointer;}
.a_close{float:right;color: #64707B;padding-right: 5px;text-decoration: underline;cursor: pointer;}
.btn_add{background-color: #F2F2F2;border: 1px #CCC solid;font-size: 11px;margin-left: 23px;cursor: pointer;}
.btn_add_drag{background-color: #F2F2F2;border: 1px #CCC solid;font-size: 11px;margin-left: 5px;cursor: pointer;}
.table_info_exe{color: #616D76;font-size: 11px;margin-top: 0px;}
.table_info_exe th{border: 1px solid #DDD;line-height: 10px;padding: 7px;vertical-align: top;}
.table_info_exe td{border: 1px solid #DDD;line-height: 23px;padding: 7px;vertical-align: top;}
.ans_content{width: 60%;padding: 4px 4px;border: solid #616D76 1px;border-radius: 1px;color: #616D76;margin:2px 0px;}
.ans_edit{padding: 4px 10px;background: #EEE;border: solid 1px;border-radius: 1px;cursor: pointer;}
.ans_del{padding: 4px 6px;background: #EEE;border: solid 1px;border-radius: 1px;cursor: pointer;}
.ans_add{padding: 4px 12px;background: #EEE;border: solid 1px;border-radius: 1px;cursor: pointer;margin-left:0;}
.med_deny{padding: 2px 5px;background: #EEE;border: solid 1px;border-radius: 5px;cursor: pointer;}
.ans_close{padding: 4px 10px;background: #EEE;border: solid 1px;border-radius: 1px;cursor: pointer;}
.media_deny{padding: 4px 9px;background: #EEE;border: solid 1px;border-radius: 5px;cursor: pointer;}
.add_action{background: none repeat scroll 0 0 #EEEEEE;border: 1px solid;border-radius: 1px;cursor: pointer;float: left;height: 18px;line-height: 17px;margin-bottom: 3px;margin-left: 20px;margin-top: 5px;padding: 0 18px;}
.p_dt_title{float: left;padding-left: 10px;margin: 0px;}
.sl_list_media{border: solid 1px #616D76;padding: 2px 2px;border-radius: 4px;margin: 5px 0px;}
.a_score{margin: 7px 0px 5px 0px;text-decoration: no;background: green;height: 18px;color: white;line-height: 18px;padding: 0px 5px;}
</style>