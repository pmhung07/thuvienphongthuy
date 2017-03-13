<?php
require_once("inc_security.php");
//check quy?n them sua xoa
checkAddEdit("add");

	//Khai bao Bien
   $fs_redirect = base64_decode(getValue("url","str","GET",base64_encode("listing.php")));
	$record_id = getValue("record_id");
   $db_Main = new db_query("SELECT * FROM  learn_writing
									 WHERE  learn_skl_cont_id = ".$record_id);

   $db_Lesson = new db_query("SELECT skl_les_id,skl_les_name,skl_cont_id,skl_cont_title,skl_cont_order
      							   FROM  skill_lesson,skill_content
      							   WHERE skill_lesson.skl_les_id = skill_content.skl_cont_les_id
                              AND skill_content.skl_cont_id = ".$record_id);

   while($row_lesson = mysqli_fetch_assoc($db_Lesson->result)){
      $nLesson = $row_lesson['skl_les_name'];
      $nContent = $row_lesson['skl_cont_order'];
      //$nCourse  = $row_lesson['com_cou_id'];
   }; unset($db_Lesson);


   $myform 	= new generate_form();
   //Loại bỏ chuc nang thay the Tag Html
   $myform->removeHTML(0);
   $myform->add("learn_skl_cont_id", "learn_skl_cont_id", 1, 0,$record_id, 0, "", 0, "");
   $myform->add("learn_wr_ques","learn_wr_ques",0,0,"",0,translate_text(""),0,"");
   $myform->add("learn_wr_mtype","learn_wr_mtype",1,0,"",0,translate_text(""),0,"");
   $myform->add("learn_wr_note", "learn_wr_note",0, 0, "", 0, translate_text(""), 0, "");
   $myform->add("learn_wr_content", "learn_wr_content", 0, 0, "", 0, translate_text(""), 0, "");
	//Add table
	$myform->addTable("learn_writing");
	//Warning Error!
	$fs_errorMsg = "";
	//Get Action.
	$action	= getValue("action", "str", "POST", "");
    if($action == "execute"){
      $fs_errorMsg .= $myform->checkdata();
      if($fs_errorMsg == ""){
         $upload1		    = new upload("learn_wr_media", $mediapath, $fs_extension, $fs_filesize);
      	$filename1	= $upload1->file_name;
         if($filename1 != ""){
            $myform->add("learn_wr_media","filename1",0,1,0,0);
         }
         $fs_errorMsg .= $upload1->show_warning_error();
         if($fs_errorMsg == ""){
      		$myform->removeHTML(0);//loại bỏ  các ký tự html( 0 thi ko loại bỏ, 1: bỏ) tránh lỗi
      		$db_insert = new db_execute($myform->generate_insert_SQL());
            unset($db_insert);
      		redirect("add_type_writing.php?url=".base64_encode(getURL())."&record_id=".$record_id);
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
      <p class="head">- Thêm nội dung trong bài học : <span style="color: red;"><?=$nLesson?></span></p>
      <p class="head head_cate">
        <span style="padding: 0 12px;">- Content số : <span style="color: red;"><?=$nContent?></span></span>

      </p>
      <table border="0" cellpadding="3" cellspacing="0" class="tablelist formdetail" width="90%">
      <?php $form = new form();
      $form->create_form("add", $_SERVER["REQUEST_URI"], "post", "multipart/form-data",'onsubmit="validateForm(); return false;"');
      ?>
      <?=$form->text_note('Những ô dấu (<font class="form_asterisk">*</font>) là bắt buộc phải nhập.')?>
      <?=$form->errorMsg($fs_errorMsg)?>
      <? //media type = 1 (Ảnh) , 2 (Video) , 3 (Flash) ?>
      <?=$form->radio("Chọn kiểu media","learn_wr_mtype","learn_wr_mtype",1,$learn_wr_mtype,"Ảnh",0,"","")?>
      <?=$form->radio("","learn_wr_mtype","learn_wr_mtype",2,$learn_wr_mtype,"Video",0,"","")?>
      <?=$form->radio("","learn_wr_mtype","learn_wr_mtype",3,$learn_wr_mtype,"Flash",0,"","")?>
      <?=$form->getFile("Upload Media", "learn_wr_media", "learn_wr_media", "Media cho Content", 0, 30, "", "")?>
      <tr>
    	<td colspan="2">
        	<?=$form->wysiwyg("Hướng dẫn","learn_wr_note",$learn_wr_note, "../../resource/wysiwyg_editor/",800,300)?>
        </td>
      </tr>
      <tr>
    	<td colspan="2">
        	<?=$form->wysiwyg("Câu hỏi","learn_wr_ques",$learn_wr_ques, "../../resource/wysiwyg_editor/",800,300)?>
     </td>
      </tr>
      <tr>
        <td colspan="2">
            <?=$form->wysiwyg("Đoạn văn", "learn_wr_content", $learn_wr_content, "../../resource/wysiwyg_editor/", 800, 300)?>
        </td>
      </tr>
      <?=$form->button("submit" . $form->ec . "reset", "submit" . $form->ec . "reset", "submit" . $form->ec . "reset", "Cập nhật" . $form->ec . "Làm lại", "Cập nhật" . $form->ec . "Làm lại", 'style="background:url(' . $fs_imagepath . 'button_1.gif) no-repeat"' . $form->ec . 'style="background:url(' . $fs_imagepath . 'button_2.gif)"', "");?>
    	<?=$form->hidden("action", "action", "execute", "");?>
    	<?
    	$form->close_form();
    	unset($form);
      ?>
      </table>
      <p class="head_cate"></p>

      <p class="head">- Danh sách Content Items</p>
      <table border="1" cellpadding="3" cellspacing="0" class="tablelist" width="90%" bordercolor="#E3E3E3">
      <tr class="head">
         <td class="bold bg" align="center" width="20">STT</td>
         <td class="bold bg" width="150"><?=translate_text("Hướng dẫn")?></td>
         <td class="bold bg" width="150"><?=translate_text("Câu hỏi")?></td>
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
            <textarea style="width: 300px;height: 100px;padding: 0px;">
            <?php echo removeHTML($row['learn_wr_note']); ?>
            </textarea>
         </td>
         <td width="" align="left" >
            <textarea style="width: 300px;height: 100px;">
            <?php echo removeHTML($row['learn_wr_ques']); ?>
            </textarea>
         </td>
         <td nowrap="nowrap">
            <?php
            $url = $mediapath.$row['learn_wr_media'];
            checkmedia_les($row['learn_wr_mtype'],$url);
            ?>
         </td>
         <td align="center"><a class="text" href="edit_type_writing.php?record_id=<?=$row["learn_wr_id"]?>&returnurl=<?=base64_encode(getURL())?>"><img src="<?=$fs_imagepath?>edit.png" alt="EDIT" border="0"></a></td>
         <td align="center"><img src="<?=$fs_imagepath?>delete.gif" alt="DELETE" border="0" onClick="if (confirm('Are you sure to delete?')){ window.location.href='del_type_writing.php?record_id=<?=$row["learn_wr_id"]?>&returnurl=<?=base64_encode(getURL())?>'}" style="cursor:pointer"></td>
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