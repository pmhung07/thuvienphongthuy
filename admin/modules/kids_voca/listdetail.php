<?
include ("inc_security.php");
$fs_title = $module_name . " | Thêm mới";
checkAddEdit("add");

$record_id 		   = getValue("record_id");
$exam_name_1      = getValue("exam_name_1","str","POST","");
$descript_1       = getValue("descript_1","str","POST","");
$exam_name_2      = getValue("exam_name_2","str","POST","");
$descript_2       = getValue("descript_2","str","POST","");
$exam_name_3      = getValue("exam_name_3","str","POST","");
$descript_3       = getValue("descript_3","str","POST","");
$fs_action			= getURL();
$fs_errorMsg		= "";
$after_save_data  = getValue("after_save_data", "str", "POST", "listdetail.php");
$fs_redirect      = $after_save_data;

$db_picture_a = new db_query("SELECT kvcb_ent_examples FROM kids_vcb_entries WHERE kvcb_ent_id	=".$record_id);
if($row = mysql_fetch_assoc($db_picture_a->result)){
	$cont_ex = $row["kvcb_ent_examples"];
}

$myform = new generate_form();  
$myform->addTable("kids_vcb_entries");
//Get action variable for add new data
$action	  = getValue("action", "str", "POST", ""); 
//Check $action for insert new datac
$filename_1 = "";
$filename_img_1 = "";
$filename_2 = "";
$filename_img_2 = "";
$filename_3 = "";
$filename_img_3 = "";
if($action == "execute"){      
   if($fs_errorMsg == ""){    	
   	$myform->removeHTML(0); 
      $upload		= new upload("audio_1", $imgpath, $fs_extension, $fs_filesize);
      $filename_1	= $upload->file_name;
            
      $upload_img_1	= new upload("image_1", $imgpath, $fs_extension, $fs_filesize);
      $filename_img_1	= $upload_img_1->file_name;
      if($filename_img_1 != ""){
      	foreach($arr_resize as $type => $arr){
      	  resize_image($image_path, $filename_img_1, $arr["width"], $arr["height"], $arr["quality"], $type);
      	}
      }
      $myform->removeHTML(0); 
      $upload		= new upload("audio_2", $imgpath, $fs_extension, $fs_filesize);
      $filename_2	= $upload->file_name;
            
      $upload_img_2	= new upload("image_2", $imgpath, $fs_extension, $fs_filesize);
      $filename_img_2	= $upload_img_2->file_name;
      if($filename_img_2 != ""){
      	foreach($arr_resize as $type => $arr){
      	  resize_image($image_path, $filename_img_2, $arr["width"], $arr["height"], $arr["quality"], $type);
      	}
      }
      $myform->removeHTML(0); 
      $upload		= new upload("audio_3", $imgpath, $fs_extension, $fs_filesize);
      $filename_3	= $upload->file_name;
            
      $upload_img_3	= new upload("image_3", $imgpath, $fs_extension, $fs_filesize);
      $filename_img_3	= $upload_img_3->file_name;
      if($filename_img_3 != ""){
      	foreach($arr_resize as $type => $arr){
      	  resize_image($image_path, $filename_img, $arr["width"], $arr["height"], $arr["quality"], $type);
      	}
      }
      //-----------------------------
      $arr_json = array();
      //$arr_examples = array[("item" => $exam_name_1 , "image" => $filename_img_1 , "audio" => $filename_1 , "description" => $descript_1 ) , ("item" => $exam_name_2 , "image" => $filename_img_2 , "audio" => $filename_2 , "description" => $descript_2 ) ,("item" => $exam_name_3 , "image" => $filename_img_3 , "audio" => $filename_3 , "description" => $descript_3 )];
      //if($cont_ex == ""){
         //$update_exam  = json_encode(array($arr_examples));
      //}
      
      
      if($exam_name_1 != "" && $filename_img_1 != "" && $descript_1 != ""){
         $udp_ex_1 = '{"item":"'.$exam_name_1.'","image":"'.$filename_img_1.'","audio":"'.$filename_1.'","description":"'.$descript_1.'" } ';
      }//else { $udp_ex_1 = ""; }
      if($exam_name_2 != "" && $filename_img_2 != "" && $descript_2 != ""){
         $udp_ex_2 = ', {"item":"'.$exam_name_2.'","image":"'.$filename_img_2.'","audio":"'.$filename_2.'","description":"'.$descript_2.'" } ';
      }//else { $udp_ex_2 = ""; }
      if($exam_name_3 != "" && $filename_img_3 != "" && $descript_3 != ""){
         $udp_ex_3 = ', {"item":"'.$exam_name_3.'","image":"'.$filename_img_3.'","audio":"'.$filename_3.'","description":"'.$descript_3.'" }';
      }//else { $udp_ex_3 = ""; }
      /*$update_exam = '[{"item":"'.$exam_name_1.'","image":"'.$filename_img_1.'","audio":"'.$filename_1.'","description":"'.$descript_1.'"},
                       {"item":"'.$exam_name_2.'","image":"'.$filename_img_2.'","audio":"'.$filename_2.'","description":"'.$descript_2.'"},
                       {"item":"'.$exam_name_3.'","image":"'.$filename_img_3.'","audio":"'.$filename_3.'","description":"'.$descript_3.'"}]';
      */
      $update_exam = "[".$udp_ex_1.$udp_ex_2.$udp_ex_3."]";
      $myform->add("kvcb_ent_examples","update_exam",0,1,"",0,"",0,"");
      $db_ex = new db_execute($myform->generate_update_SQL("kvcb_ent_id", $record_id));
  		redirect("listing.php");	
   }
}
$myform->addFormname("add_new");
$myform->evaluate();
$myform->checkjavascript();
$fs_errorMsg .= $myform->strErrorField;

//==========================================================
//Get data update
$db_get_dt = new db_query("SELECT kvcb_ent_examples FROM kids_vcb_entries WHERE kvcb_ent_id	=".$record_id);
$i=0;
while($row = mysql_fetch_assoc($db_get_dt->result)){
	$content = $row["kvcb_ent_examples"];
   $content = json_decode($content);   
   if(isset($content[0])){ 
      $exam_name_get_1 = $content[0]->{'item'};
      $descript_get_1 = $content[0]->{'description'};
   }else{
      $exam_name_get_1 = "";
      $descript_get_1 = "";
   }
   if(isset($content[1])){
      $exam_name_get_2 = $content[1]->{'item'};
      $descript_get_2 = $content[1]->{'description'};
   }else{
      $exam_name_get_2 = "";
      $descript_get_2 = "";
   }
   if(isset($content[2])){
      $exam_name_get_3 = $content[2]->{'item'};
      $descript_get_3 = $content[2]->{'description'};      
   }else{
      $exam_name_get_3 = "";
      $descript_get_3 = "";
   }  
}

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
      <?=$form->text("Tên ví dụ 1","exam_name_1","exam_name_1",$exam_name_get_1,"Nhập tên ví dụ",1,250,"",255,"","","");?>
      <?=$form->text("Mô tả 1","descript_1","descript_1",$descript_get_1,"Nhập mô tả",1,250,"",255,"","","");?>
      <?=$form->getFile("Tải Audio 1", "audio_1", "audio_1", "Tải audio", 0, 30, "", "")?>
      <?=$form->getFile("Tải ảnh 1", "image_1", "image_1", "Tải ảnh", 0, 30, "", "")?>
      <?=$form->text("Tên ví dụ 2","exam_name_2","exam_name_2",$exam_name_get_2,"Nhập tên ví dụ",1,250,"",255,"","","");?>
      <?=$form->text("Mô tả 2","descript_2","descript_2",$descript_get_2,"Nhập mô tả",1,250,"",255,"","","");?>
      <?=$form->getFile("Tải Audio 2", "audio_2", "audio_2", "Tải audio", 0, 30, "", "")?>
      <?=$form->getFile("Tải ảnh 2", "image_2", "image_2", "Tải ảnh", 0, 30, "", "")?>
      <?=$form->text("Tên ví dụ 3","exam_name_3","exam_name_3",$exam_name_get_3,"Nhập tên ví dụ",1,250,"",255,"","","");?>
      <?=$form->text("Mô tả 3","descript_3","descript_3",$descript_get_3,"Nhập mô tả",1,250,"",255,"","","");?>
      <?=$form->getFile("Tải Audio 3", "audio_3", "audio_3", "Tải audio", 0, 30, "", "")?>
      <?=$form->getFile("Tải ảnh 3", "image_3", "image_3", "Tải ảnh", 0, 30, "", "")?>
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
         <th width="100">Item</th>
         <th width="100">Audio</th>
         <th width="100">Image</th>
         <th width="100">Mô tả</th>
		</tr>
		<?
      $db_picture = new db_query("SELECT kvcb_ent_examples FROM kids_vcb_entries WHERE kvcb_ent_id	=".$record_id);
		$i=0;
		while($row = mysql_fetch_assoc($db_picture->result)){
			$content = $row["kvcb_ent_examples"];
         $content = json_decode($content);
      }
      for($j = 0;$j < count($content);$j++){
		?>
			<tr <?=$fs_change_bg?>>
				<td align="center"><?=$j+1?></td>
            <td align="center">
               <input type="text" value="<?echo $content[$j]->{'item'};?>" />
            </td>
            <td align="center">
               <?
                  $url_file =   $content[$j]->{'audio'};
                  if($url_file != ""){
                     $url = $imgpath.$url_file;         
                     checkmedia_les(2,$url);
                  }else{
                     echo "Not Found";
                  }
               ?>
            </td>
            <td align="center">
               <?
                  $url_file =   $content[$j]->{'image'};
                  $url = $imgpath.$url_file;         
                  checkmedia_les(2,$url);
               ?>
            </td>
            <td align="center">
               <input type="text" value="<?echo $content[$j]->{'description'};?>" />
            </td>
         </tr>
      <?}?>
	</table>
	</div>
<? /*------------------------------------------------------------------------------------------------*/ ?>

   
</body>
</html>
