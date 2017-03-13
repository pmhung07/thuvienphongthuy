<?php

/**
 * @author    hoanlv
 * @copyright 2012
 * @Email     it.hoanlv@gmail.com
 */
require_once("inc_security.php");
//check quy?n them sua xoa
checkAddEdit("add");

	//Khai bao Bien
	$fs_redirect 							= base64_decode(getValue("url","str","GET",base64_encode("listing.php")));
	$record_id 								= getValue("record_id");
   $ext_type                        = getValue("ext_type","int","GET",0);

   $db_Grammar = new db_query("SELECT * FROM  skill_ext
                               WHERE  skl_ext_skl_cont_id = ".$record_id);

   $db_Lesson = new db_query("SELECT skl_les_id,skl_les_name,skl_cont_id,skl_cont_title,skl_cont_order
      							   FROM  skill_lesson,skill_content
      							   WHERE skill_lesson.skl_les_id = skill_content.skl_cont_les_id
                              AND skill_content.skl_cont_id = ".$record_id);

   while($row_lesson = mysqli_fetch_assoc($db_Lesson->result)){
      $nLesson = $row_lesson['skl_les_name'];
      $nContent = $row_lesson['skl_cont_order'];
   }; unset($db_Lesson);

   $arr_type_display = array( 1 => "Upload Game",
                              );

   $myform = new generate_form();
	//Loại bỏ chuc nang thay the Tag Html
	$myform->removeHTML(0);
   $myform->add("skl_ext_skl_cont_id", "skl_ext_skl_cont_id", 1, 1,$record_id, 0, "", 0, "");
   $myform->add("skl_ext_type","skl_ext_type",1,0,$ext_type,1,"Bạn chưa chọn dạng hiển thị",0,"");
   if($ext_type == 1){
      $myform->add("skl_ext_cont","skl_ext_cont",0,0,"",0,"",0,"");
      $myform->add("skl_ext_media_type","skl_ext_media_type",1,0,3,0,"",0,"");
   }

	//Add table
	$myform->addTable("skill_ext");
	//Warning Error!
	$fs_errorMsg = "";
	//Get Action.
	$action	= getValue("action", "str", "POST", "");
    if($action == "execute"){
         //Check form data : kiêm tra lỗi
         $fs_errorMsg .= $myform->checkdata();
         if($fs_errorMsg == ""){
            $upload		    = new upload("skl_ext_media", $mediapath, $fs_extension, $fs_filesize);
            $uploadAudio    = new upload("skl_ext_audio", $mediapath, $fs_extension, $fs_filesize);
            $filename	    = $upload->file_name;
            $filenameAudio	 = $uploadAudio->file_name;
            if($filename != ""){
               $myform->add("skl_ext_media","filename",0,1,0,0);
            }
            if($filenameAudio != ""){
               $myform->add("skl_ext_audio","filenameAudio",0,1,0,0);
            }
            $fs_errorMsg .= $upload->show_warning_error();

            if($fs_errorMsg == ""){
            //Insert to database
            $myform->removeHTML(0);//loại bỏ  các ký tự html( 0 thi ko loại bỏ, 1: bỏ) tránh lỗi
            //thực hiện insert
            $db_insert = new db_execute($myform->generate_insert_SQL());
            //unset biến để giải phóng bộ nhớ.
            unset($db_insert);
            //Redirect after insert complate
            //$fs_redirect = "add.php?order=" . (getValue("cur_order","int","POST") + 1);
            redirect("add_type_ext.php?url=".base64_encode(getURL())."&record_id=".$record_id);
            }
  	      }//End if($fs_errorMsg == "")

    }//End if($action == "insert")
	//add form for javacheck
	$myform->addFormname("add_new");
	$myform->evaluate();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<?=$load_header?>
</head>
<body topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0">
<? /*------------------------------------------------------------------------------------------------*/ ?>
    <p class="head">- Thêm nội dung trong bài học : <span style="color: red;"><?=$nLesson?></span></p>
    <p class="head head_cate">
        <span style="padding: 0 12px;">- Content số        : <span style="color: red;"><?=$nContent?></span></span>
    </p>
   <table border="0" cellpadding="3" cellspacing="0" class="tablelist formdetail" width="90%">
   <?php $form = new form();
   $form->create_form("add", $_SERVER["REQUEST_URI"], "post", "multipart/form-data",'onsubmit="validateForm(); return false;"');
   ?>
   <?=$form->text_note('Những ô dấu (<font class="form_asterisk">*</font>) là bắt buộc phải nhập.')?>
   <?=$form->errorMsg($fs_errorMsg)?>
   <? //media type = 1 (Ảnh) , 2 (Video) , 3 (Flash) ?>
   <tr>
      <td align="right" style="font-size: 12px; font-weight:bold; color:#004000;">Chọn dạng hiển thị :</td>
      <td align="left">
         <select id="skl_ext_type" name="skl_ext_type" class="form_control" onChange="window.location.href='add_type_ext.php?ext_type='+this.value+'&record_id=<?=$record_id?>'">
            <option value="">Chọn dạng</option>
            <?
               foreach($arr_type_display as $key => $value){
            ?>
                  <option value="<?=$key?>" <?if($key == $ext_type) echo "selected = 'selected'"?>><?=$value?></option>
            <?
              }
            ?>
         </select>
      </td>
      <td></td>
   </tr>
   <?if($ext_type == 1){
      echo $form->getFile("Upload Game", "skl_ext_media", "skl_ext_media", "Upload Game", 0, 30, "", "");
      echo $form->textarea("Hướng dẫn chơi","skl_ext_cont","skl_ext_cont",$skl_ext_cont,"Hướng dẫn chơi",0,300,100,"","");
      echo $form->button("submit" . $form->ec . "reset", "submit" . $form->ec . "reset", "submit" . $form->ec . "reset", "Cập nhật" . $form->ec . "Làm lại", "Cập nhật" . $form->ec . "Làm lại", 'style="background:url(' . $fs_imagepath . 'button_1.gif) no-repeat"' . $form->ec . 'style="background:url(' . $fs_imagepath . 'button_2.gif)"', "");
      echo $form->hidden("action", "action", "execute", "");
   }?>

   <?
   $form->close_form();
   unset($form);
   ?>
   </table>
   <p class="head_cate"></p>

    <p class="head">- Danh sách Content Items</p>
    <table border="1" cellpadding="3" cellspacing="0" class="tablelist" width="90%" bordercolor="#E3E3E3">
    <tr class="head">
        <td class="bold bg" width="2%" nowrap="nowrap" align="center" style="background: none;"><img src="<?=$fs_imagepath?>save.png" border="0"/></td>
		  <td class="bold bg" width="15%"><?=translate_text("Dạng")?></td>
        <td class="bold bg" width="30%"><?=translate_text("Nội dung")?></td>
        <td class="bold bg" align="center" width="100">Media</td>
        <td class="bold bg" align="center" width="100">Audio</td>
        <!--<td class="bold bg" align="center" width="40">Order</td>-->
        <td class="bold bg" align="center" width="30" >Sửa</td>
        <td class="bold bg" align="center" width="30" >Xóa</td>
	</tr>
   <form action="quickedit.php?returnurl=<?=base64_encode(getURL())?>" method="post" name="form_listing" id="form_listing" enctype="multipart/form-data">
	<input type="hidden" name="iQuick" value="update" />
    <?
	$i=0;
   $j = 0;
	while($row = mysqli_fetch_array($db_Grammar->result)){ $i++;
	?>
   <tr <? if($i%2==0) echo ' bgcolor="#FAFAFA"';?>>
      <td></td>
      <?/*<td nowrap="nowrap">
      	<textarea style="width: 240px;height: 60px;"><?php echo $row['gram_content_en'] ?></textarea>
      </td>
      */?>
      <td align="center" width="50">
         <?foreach($arr_type_display as $key => $value){
            if($key == $row['skl_ext_type']) echo '<input style="width:220px;background: #eee;" type="text" readonly="" value="'.$value.'" />';
         }?>

      </td>

      <td nowrap="nowrap">
   	   <textarea style="width: 240px;height: 60px;"><?php echo $row['skl_ext_cont']?></textarea>
      </td>
      <td nowrap="nowrap">
         <?php
         $url = $mediapath.$row['skl_ext_media'];
         checkmedia_les($row['skl_ext_media_type'],$url);
         ?>
      </td>
      <td>
      <?
         $url =  $mediapath.$row['skl_ext_audio'];
         checkmedia_les(2,$url);
      ?>
      </td>
      <?/*
      <td align="center" width="30">
         <input style="width:30px;background: #eee;" type="text" readonly="" value="<?=$row["gram_order"]?>" />
      </td>
      */?>
      <td align="center"><a class="text" href="edit_type_ext.php?record_id=<?=$row["skl_ext_id"]?>&ext_type=<?=$row["skl_ext_type"]?>&returnurl=<?=base64_encode(getURL())?>"><img src="<?=$fs_imagepath?>edit.png" alt="EDIT" border="0"></a></td>
      <td align="center"><img src="<?=$fs_imagepath?>delete.gif" alt="DELETE" border="0" onClick="if (confirm('Are you sure to delete?')){ window.location.href='del_type_ext.php?record_id=<?=$row["skl_ext_id"]?>&returnurl=<?=base64_encode(getURL())?>'}" style="cursor:pointer"></td>
   </tr>
   <?php } unset($db_Grammar) ?>
   </form>
   </table>
<? /*------------------------------------------------------------------------------------------------*/ ?>
</body>
</html>
<style>
.a_detail{padding: 3px 15px;border:solid 1px;background:#EEE;text-decoration:none;}
</style>