<?php
require_once("inc_security.php");
//check quy?n them sua xoa
checkAddEdit("add");

	//Khai bao Bien
   $fs_redirect = base64_decode(getValue("url","str","GET",base64_encode("listing.php")));
	$record_id = getValue("record_id");
   $db_Main = new db_query("SELECT * FROM  kids_lessons
									 WHERE  kunit_id = ".$record_id." ORDER BY kles_id");

   $db_Lesson = new db_query("SELECT kunit_title,kunit_id
      							   FROM  kids_units
      							   WHERE  kids_units.kunit_id = ".$record_id);

   while($row_lesson = mysqli_fetch_assoc($db_Lesson->result)){
      $nLesson = $row_lesson['kunit_title'];
   }; unset($db_Lesson);
   echo $record_id;

   //Khai bao mang kieu bai hoc chinh
   $kles_media_type = getValue("kles_media_type","int","POST",0);

   $myform 	= new generate_form();
   //Loại bỏ chuc nang thay the Tag Html
   $myform->removeHTML(0);
   $myform->add("	kunit_id", "	kunit_id", 1, 1,$record_id, 0, "", 0, "");
   $myform->add("kles_title","kles_title",0,0,"",1,translate_text("Bạn chưa nhập tiêu đề"),0,"");
   $myform->add("kles_desc","kles_desc",0,0,"",1,translate_text("Bạn chưa nhập mô tả"),0,"");
   $myform->add("kles_media_type","kles_media_type",1,0,0,0,translate_text("Bạn chưa chọn dạng media"),0,"");
   if($kles_media_type == 1){
      $myform->add("kles_media_content","kles_media_content",0,0,"",1,translate_text("Bạn chưa nhập mô tả"),0,"");
   }
	//Add table
	$myform->addTable("kids_lessons");
	//Warning Error!
	$fs_errorMsg = "";
	//Get Action.
	$action	= getValue("action", "str", "POST", "");
    if($action == "execute"){
      $fs_errorMsg .= $myform->checkdata();
      if($fs_errorMsg == ""){
         $upload1		    = new upload("kles_media_content", $imgpath, $fs_extension, $fs_filesize);
      	$filename1	= $upload1->file_name;
         $arr_file = array('content' => $filename1);
         $get_ar_filename = json_encode($arr_file);
         if($filename1 != ""){
            $myform->add("kles_media_content","get_ar_filename",0,1,0,0);
            foreach($arr_resize as $type => $arr){
      		resize_image($imgpath, $filename1, $arr["width"], $arr["height"], $arr["quality"], $type);
            }
         }
         $fs_errorMsg .= $upload1->show_warning_error();
         if($fs_errorMsg == ""){
      		$myform->removeHTML(0);//loại bỏ  các ký tự html( 0 thi ko loại bỏ, 1: bỏ) tránh lỗi
      		$db_insert = new db_execute($myform->generate_insert_SQL());
            unset($db_insert);
      		redirect("listdetail.php?url=".base64_encode(getURL())."&record_id=".$record_id);
      	}
      }
   }
	$myform->addFormname("add_new");
	$myform->evaluate();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<?=$load_header?>
</head>
   <body>
   <? /*------------------------------------------------------------------------------------------------*/ ?>
      <p class="head">- Thêm Bài học chính trong Unit : <span style="color: red;"><?=$nLesson?></span></p>
      <p class="head head_cate">
      </p>
      <table border="0" cellpadding="3" cellspacing="0" class="tablelist formdetail" width="90%">
      <?php $form = new form();
      $form->create_form("add", $_SERVER["REQUEST_URI"], "post", "multipart/form-data",'onsubmit="validateForm(); return false;"');
      ?>
      <?=$form->text_note('Những ô dấu (<font class="form_asterisk">*</font>) là bắt buộc phải nhập.')?>
      <?=$form->errorMsg($fs_errorMsg)?>
      <? //media type = 1 (Url) , 2 (Video) , 3 (Flash) ?>
      <?=$form->radio("<font class='form_asterisk'>*</font> Chọn kiểu media","kles_media_type","kles_media_type",1,$kles_media_type,"URL",0,"","")?>
      <?=$form->radio("","kles_media_type","kles_media_type",2,$kles_media_type,"Video",0,"","")?>
      <?=$form->radio("","kles_media_type","kles_media_type",3,$kles_media_type,"Flash",0,"","")?>
      <?=$form->getFile("Media 1", "kles_media_content", "kles_media_content", "Media cho Bài học chính", 0, 30, "", "")?>
      <?=$form->text("URL", "kles_media_content", "kles_media_content", "", "",0, 250, 24, 255, "", "", "")?>
      <?=$form->text("Tiêu đề", "kles_title", "kles_title", "", "",0, 250, 24, 255, "", "", "")?>
      <?=$form->textarea("Mô tả", "kles_desc", "kles_desc", "", "",0, 300, 50, 255, "", "", "")?>
      <?=$form->button("submit" . $form->ec . "reset", "submit" . $form->ec . "reset", "submit" . $form->ec . "reset", "Cập nhật" . $form->ec . "Làm lại", "Cập nhật" . $form->ec . "Làm lại", 'style="background:url(' . $fs_imagepath . 'button_1.gif) no-repeat"' . $form->ec . 'style="background:url(' . $fs_imagepath . 'button_2.gif)"', "");?>
    	<?=$form->hidden("action", "action", "execute", "");?>
    	<?
    	$form->close_form();
    	unset($form);
      ?>
      </table>
      <p class="head_cate"></p>

      <p class="head">- Danh sách Bài học có trong Lesson</p>
      <table border="1" cellpadding="3" cellspacing="0" class="tablelist" width="90%" bordercolor="#E3E3E3">
      <tr class="head">
         <td class="bold bg" align="center" width="20">STT</td>
         <td class="bold bg" width="150">Tiêu đề</td>
         <td class="bold bg" width="150">Mô tả</td>
         <td class="bold bg" align="center" width="100">Media</td>
         <td class="bold bg" align="center" width="20" >Sửa</td>
         <td class="bold bg" align="center" width="20" >Xóa</td>
      </tr>
      <form action="quickedit.php?returnurl=<?=base64_encode(getURL())?>" method="post" name="form_listing" id="form_listing" enctype="multipart/form-data">
      <input type="hidden" name="iQuick" value="update" />
       <?

   	$i=0;
      $j = 0;
   	while($row = mysqli_fetch_array($db_Main->result)){ $i++;

   	?>
      <tr <? if($i%2==0) echo ' bgcolor="#FAFAFA"';?>>
         <td width="20"><?php echo $i ?></td>
         <td width="" align="left" >
            <input type="text" value="<?=removeHTML($row['kles_title'])?>" />
         </td>
         <td width="" align="left" >
            <input type="text" value="<?=removeHTML($row['kles_desc'])?>" />
         </td>
         <td nowrap="nowrap">
            <?php
            if($row['kles_media_type'] == 1){
               ?><input type="text" value="<?=$row['kles_media_content']?>" /><?
            }elseif($row['kles_media_type'] == 0){
               echo "Not Found";
            }else{
               $json = $row['kles_media_content'];
               $obj = json_decode($json);
               $url_file =  $obj->{'content'};
               $url = $imgpath.$url_file;
               checkmedia_les($row['kles_media_type'],$url);
            }
            ?>
         </td>
         <td align="center"><a class="text" href="editdetail.php?record_id=<?=$row["kles_id"]?>&returnurl=<?=base64_encode(getURL())?>"><img src="<?=$fs_imagepath?>edit.png" alt="EDIT" border="0"></a></td>
         <td align="center"><img src="<?=$fs_imagepath?>delete.gif" alt="DELETE" border="0" onClick="if (confirm('Are you sure to delete?')){ window.location.href='deletedetail.php?record_id=<?=$row["kles_id"]?>&returnurl=<?=base64_encode(getURL())?>'}" style="cursor:pointer"></td>
   	</tr>
      <?php } unset($db_Main) ?>
      </form>
      </table>
   <? /*------------------------------------------------------------------------------------------------*/ ?>
   </body>
</html>
<style>
.a_detail{padding: 3px 15px;border:solid 1px;background:#EEE;text-decoration:none;}
</style>