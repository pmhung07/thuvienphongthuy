<?
include ("inc_security.php");
$fs_title = $module_name . " | Thêm mới";
checkAddEdit("add");

$iQues            = getValue("iQues","int","GET","");
$record_id 		   = getValue("record_id");
$fs_action			= getURL();
$fs_errorMsg		= "";
$after_save_data  = getValue("after_save_data", "str", "POST", "add_exercises.php");
$fs_redirect      = $after_save_data;


$myform = new generate_form();
$myform->addTable("toeic_questions");
//Get action variable for add new data
$action	  = getValue("action", "str", "POST", "");
//Check $action for insert new datac

if($action == "execute"){
   if($fs_errorMsg == ""){
   	$myform->removeHTML(0);//loại bỏ  các ký tự html( 0 thi ko loại bỏ, 1: bỏ) tránh lỗi
      $upload		= new upload("toque_audio", $data_path, $fs_extension, $fs_filesize);
      $filename	= $upload->file_name;
      if($filename != ""){
         $myform->add("toque_audio","filename",0,1,0,0);
      }

      $upload_img	= new upload("toque_image", $image_path, $fs_extension_img, $fs_filesize);
      $filename_img	= $upload_img->file_name;
      if($filename_img != ""){
      	$myform->add("toque_image","filename_img",0,1,0,0);
      	foreach($arr_resize as $type => $arr){
      	  resize_image($image_path, $filename_img, $arr["width"], $arr["height"], $arr["quality"], $type);
      	}
      }

      //thực hiện insert
      $db_ex = new db_execute($myform->generate_update_SQL("toque_id", $iQues));
      unset($db_ex);
   	//redirect("add_exercises.php?iPara=".$iPara."&record_id=".$record_id);
      redirect($_SERVER['REQUEST_URI']);
   }
}
$myform->addFormname("add_new");
$myform->evaluate();
$myform->checkjavascript();
$fs_errorMsg .= $myform->strErrorField;

//lay du lieu cua record can sua doi
$db_data 	= new db_query("SELECT * FROM toeic_questions WHERE toque_id =".$iQues);
if($row 		= mysqli_fetch_assoc($db_data->result)){
   foreach($row as $key=>$value){
   	if($key!='lang_id' && $key!='admin_id') $$key = $value;
   }
}else{
		exit();
}


//==========================================================
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<?=$load_header?>
</head>
<body>
<?=template_top($fs_title)?>
   <p align="center" style="padding-left:10px;">
      <?
      $form = new form();
      $form->create_form("add", $fs_action, "post", "multipart/form-data",'onsubmit="validateForm(); return false;"');
      $form->create_table();
      ?>
      <?=$form->getFile("Tải Audio", "toque_audio", "toque_audio", "Tải audio", 0, 30, "", "")?>
      <?=$form->getFile("Tải Ảnh", "toque_image", "toque_image", "Tải ảnh", 0, 30, "", "")?>
      <?=$form->button("submit" . $form->ec . "reset", "submit" . $form->ec . "reset", "submit" . $form->ec . "reset", "Cập nhật" . $form->ec . "Làm lại", "Cập nhật" . $form->ec . "Làm lại", 'style="background:url(' . $fs_imagepath . 'button_1.gif) no-repeat"' . $form->ec . 'style="background:url(' . $fs_imagepath . 'button_2.gif)"', "");?>
      <?=$form->hidden("action", "action", "execute", "");?>
      <?
      $form->close_table();
      $form->close_form();
      unset($form);
      ?>
   </p>
   <?=template_bottom() ?>

   <? /*------------------------------------------------------------------------------------------------*/ ?>
	<div style="padding-left:3px; padding-right:3px;">
	<table cellpadding="5" cellspacing="0" width="450px" style="border-collapse:collapse;" bordercolor="#CCCCCC" border="1">
		<tr>
			<th width="10">ID</th>
         <th width="100">Audio</th>
         <th width="100">Image</th>
		</tr>
		<?
      $db_picture = new db_query("SELECT * FROM toeic_questions WHERE  toque_id=".$iQues);
		$i=0;
		while($row = mysqli_fetch_assoc($db_picture->result)){
			$i++;
		?>
			<tr <?=$fs_change_bg?>>
				<td align="center"><?=$i?></td>
            <?$url = $data_path.$row['toque_audio'];?>
            <?$url_img = $image_path.$row['toque_image'];?>
            <td align="center"><a style="padding:5px 0px 5px 6px;text-decoration:underline;float:left;" title="Audio" class="thickbox noborder a_detail" href="view_media.php?url=<?=base64_encode(getURL())?>&media_type=2&url_media=<?=$url?>&TB_iframe=true&amp;height=300&amp;width=300" /><b style="background: none repeat scroll 0 0 #1D5691;color: white;padding: 2px 10px;"> View Audio</b></a></td>
            <td align="center"><a style="padding:5px 0px 5px 6px;text-decoration:underline;float:left;" title="Audio" class="thickbox noborder a_detail" href="view_media.php?url=<?=base64_encode(getURL())?>&media_type=1&url_media=<?=$url_img?>&TB_iframe=true&amp;height=300&amp;width=300" /><b style="background: none repeat scroll 0 0 #1D5691;color: white;padding: 2px 10px;"> View Image</b></a></td>
			</tr>
		<?
		}unset($db_picture);
		?>
	</table>
	</div>
<? /*------------------------------------------------------------------------------------------------*/ ?>


</body>
</html>
