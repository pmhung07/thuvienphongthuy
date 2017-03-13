<?
include ("inc_security.php");
checkAddEdit("add");

$fs_action			= getURL();
$fs_errorMsg		= "";

$fs_redirect      = getValue("url","str","GET",base64_encode("listing.php"));
$record_id        = getValue("record_id","int","GET","");
$score            = getValue("score","int","GET",0);
$fs_title			= $module_name . " | Sửa đổi";

// Update comment
$myform = new generate_form();
$myform->add("tesr_cmt_writing_1", "tesr_cmt_writing_1", 0, 0, "",1, "Bạn chưa nhập đánh giá dạng bài thứ 1", 0, "");
$myform->add("tesr_cmt_writing_2", "tesr_cmt_writing_2", 0, 0, "",1, "Bạn chưa nhập đánh giá dạng bài thứ 2", 0, "");
$myform->addTable("test_result");
//Get action variable for add new data
$action				= getValue("action", "str", "POST", "");
//Check $action for insert new data
if($action == "execute"){
	//Check form data
	$fs_errorMsg .= $myform->checkdata();
	if($fs_errorMsg == ""){
		$myform->removeHTML(0);
		$db_ex = new db_execute($myform->generate_update_SQL("tesr_id",$record_id));
      echo("<script>alert('Sửa đổi thành công')</script>");
		redirect($fs_action);
	}
}
$myform->addFormname("add_new");
$myform->evaluate();
$myform->checkjavascript();
$fs_errorMsg .= $myform->strErrorField;
//---------------
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<?=$load_header?>
</head>
<body>
<? /*------------------------------------------------------------------------------------------------*/ ?>
<? /*------------------------------------------------------------------------------------------------*/ ?>
	<div style="padding-left:3px; padding-right:3px;">
	<table cellpadding="5" cellspacing="0" width="100%" style="border-collapse:collapse;" bordercolor="#CCCCCC" border="1">
		<tr>
			<th width="10">ID</th>
         <th width="400">Text_1</th>
         <th width="400">Text_2</th>
         <th width="150">Scores</th>
		</tr>
		<?
		$db_picture = new db_query("SELECT * FROM result_writing WHERE  rew_tesr_id=" . $record_id);
		?>
		<?
		$i=0;
		while($row = mysqli_fetch_assoc($db_picture->result)){
			$i++;
		?>
			<tr <?=$fs_change_bg?>>
				<td align="center"><?=$i?></td>
            <td align="center" width="100">
               <?
                  if($row['rew_content_1'] != ""){
                     ?>
                     <textarea style="width: 390px;height: 200px;"><?=$row['rew_content_1'];?></textarea>
                     <?
                  }else{
                     echo "Not Text";
                  }
               ?>
            </td>
            <td align="center" width="100">
               <?
                  if($row['rew_content_2'] != ""){
                     ?>
                     <textarea style="width: 390px;height: 200px;"><?=$row['rew_content_2'];?></textarea>
                     <?
                  }else{
                     echo "Not Text";
                  }
               ?>
            </td>
            <td align="center">
               <input id="score_writing_<?=$record_id?>" style="width: 30px;background: #eee;text-align: center;color: red;font-weight: bold;" type="text" value="<?=$score?>" />
               <a onclick="score_writing(<?=$record_id?>)" class="a_detail">Scores</a>
            </td>
			</tr>
		<?
		}
		?>
	</table>
	</div>
<? /*------------------------------------------------------------------------------------------------*/ ?>
   <? /*------------------------------------------------------------------------------------------------*/ ?>
<?
//lay du lieu comment của speaking
$db_data 	= new db_query("SELECT * FROM test_result WHERE tesr_id = " . $record_id);
if($row 		= mysqli_fetch_assoc($db_data->result)){
   foreach($row as $key=>$value){
   	if($key!='lang_id' && $key!='admin_id') $$key = $value;
   }
}else{
		exit();
}
//--------------------------------
?>

<?=template_top($fs_title)?>
   <p align="center" style="padding-left:10px;">
      <?
      $form = new form();
      $form->create_form("add", $fs_action, "post", "multipart/form-data",'onsubmit="validateForm(); return false;"');
      $form->create_table();
      ?>
      <tr>
         <td width="" class="form_name"></td>
         <td width="800">
            <?=$form->wysiwyg("<font class='form_asterisk'>*</font> Đánh giá dạng bài thứ 1", "tesr_cmt_writing_1", $tesr_cmt_writing_1 , "../../resource/wysiwyg_editor/", 900, 250)?>
         </td>
      </tr>
      <tr>
         <td width="" class="form_name"></td>
         <td width="800">
            <?=$form->wysiwyg("<font class='form_asterisk'>*</font> Đánh giá dạng bài thứ 2", "tesr_cmt_writing_2", $tesr_cmt_writing_2 , "../../resource/wysiwyg_editor/", 900, 250)?>
         </td>
      </tr>
      <?=$form->button("submit" . $form->ec . "reset", "submit" . $form->ec . "reset", "submit" . $form->ec . "reset", "Cập nhật" . $form->ec . "Làm lại", "Cập nhật" . $form->ec . "Làm lại", 'style="background:url(' . $fs_imagepath . 'button_1.gif) no-repeat"' . $form->ec . 'style="background:url(' . $fs_imagepath . 'button_2.gif)"', "");?>
      <?=$form->hidden("action", "action", "execute", "");?>
      <?
      $form->close_table();
      $form->close_form();
      unset($form);
      ?>
   </p>
   <?=template_bottom() ?>
</body>
</html>
<style>
.a_detail{padding: 1px 15px;padding-top: 2px;border: solid 1px;background: #EEE;text-decoration: none;color: red;cursor: pointer;}
</style>
<script>
function score_writing(record_id){
   var writing_speak = $('#score_writing_'+record_id).val();
	$.ajax({
		type:'POST',
		dataType:'json',
		data:{
		   writing_speak:writing_speak,
         tesr_id:record_id,
      },
		url:'ajax_score_writing.php',
		success:function(data){
			if(data.err == ''){
				alert(data.msg);
				//window.location.reload();
			}else{
				alert(data.err);
			}
      }
   });
}
</script>