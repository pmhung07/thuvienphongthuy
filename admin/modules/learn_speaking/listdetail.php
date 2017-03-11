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
    $db_Speaking = new db_query("SELECT *
									FROM  learn_content
									WHERE  lec_learn_id = ".$record_id ." AND lec_learn_type = 0 ORDER BY lec_order");
                                    
    $db_unit = new db_query("SELECT com_name,learn_unit_id,com_cou_id,com_id
									FROM  courses_multi,learn_speaking
									WHERE courses_multi.com_id = learn_speaking.learn_unit_id
                                    AND   learn_speaking.learn_sp_id = ".$record_id);
                                    
    while($row_unit = mysql_fetch_assoc($db_unit->result)){
      $nUnit    = $row_unit['com_name'];
      $nCourse  = $row_unit['com_cou_id'];
      $iCourse  = $row_unit['com_id'];

    }; unset($db_unit);
    
    $db_course = new db_query("SELECT cou_id,cou_cat_id,cou_name,cou_lev_id
									FROM  courses
									WHERE  cou_id = ".$nCourse);
                                    
    while($row_course = mysql_fetch_assoc($db_course->result)){
      $nCourse    = $row_course['cou_name'];
      $nLever     = nameLevel($row_course['cou_lev_id']);
      $nCate      = $row_course['cou_cat_id'];
      $iCour      = $row_course['cou_id'];
    }; unset($db_course);
    
    $db_cate = new db_query("SELECT cat_name,cat_id
									FROM   categories_multi
									WHERE  cat_id = ".$nCate);
    while($row_cate = mysql_fetch_assoc($db_cate->result)){
      $nCate    = $row_cate['cat_name'];
    }; unset($db_cate);
    $link = generate_preview_link($nCate,$nLever,$nUnit,$iCour,$iCourse,'speak');
    $myform 								= new generate_form();
	//Loại bỏ chuc nang thay the Tag Html
	$myform->removeHTML(0);
    $myform->add("lec_learn_id", "lec_learn_id", 1, 0,$record_id, 0, "", 0, "");
    $myform->add("lec_text","lec_text",0,0,"",0,translate_text("Vui lòng nhập nghĩa tiếng việt của ngữ pháp"),0,"");
    $myform->add("lec_media_type","lec_media_type",1,0,"",1,translate_text("Vui lòng chọn dạng media cho phần Grammar"),0,"");
    $myform->add("lec_order", "lec_order", 1, 0, 0, 0, "", 0, "");
    $myform->add("lec_note", "lec_note", 0, 0, "", 0, "", 0, "");
	 $myform->add("lec_question", "lec_question", 0, 0, "", 0, "", 0, "");
    //$myform->add("com_cou_id","com_cou_id",1,0,$iParent,0,"",0,"");
	//Add table
	$myform->addTable("learn_content");
	//Warning Error!
	$fs_errorMsg = "";
	//Get Action.
	$action	= getValue("action", "str", "POST", "");
    if($action == "execute"){     
         //Check form data : kiêm tra lỗi
         $fs_errorMsg .= $myform->checkdata();
         if($fs_errorMsg == ""){
            $upload		    = new upload("lec_media", $mediapath, $fs_extension, $fs_filesize);
            $filename	    = $upload->file_name;
            if($filename != ""){
               $myform->add("lec_media","filename",0,1,0,0);
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
            redirect($url);
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
    <p class="head">- Thêm Speaking trong UNIT : <span style="color: red;"><?=$nUnit?></span></p>
    <p class="head head_cate"> 
        <span style="padding: 0 12px;">- Thuộc Chuyên mục  : <span style="color: red;"><?=$nCate?></span></span> 
        <span style="padding: 0 12px;">- Level             : <span style="color: red;"><?=$nLever?></span></span>
        <span style="padding: 0 12px;">- Course            : <span style="color: red;"><?=$nCourse?></span></span> 
    </p>
    <table border="0" cellpadding="3" cellspacing="0" class="tablelist formdetail" width="90%">
        <?php $form = new form();
        $form->create_form("add", $_SERVER["REQUEST_URI"], "post", "multipart/form-data",'onsubmit="validateForm(); return false;"');
    	?>
    	<?=$form->text_note('Những ô dấu (<font class="form_asterisk">*</font>) là bắt buộc phải nhập.')?>
    	<?=$form->errorMsg($fs_errorMsg)?>
        <? //media type = 1 (Ảnh) , 2 (Video) , 3 (Flash) ?>
        <?=$form->radio("Chọn kiểu media","lec_media_type","lec_media_type",1,$lec_media_type,"Ảnh",0,"","")?>
        <?=$form->radio("","lec_media_type","lec_media_type",2,$lec_media_type,"Video - Audio",0,"","")?>
        <?=$form->radio("","lec_media_type","lec_media_type",3,$lec_media_type,"Flash",0,"","")?>
        <?=$form->getFile("Media cho Speaking", "lec_media", "lec_media", "Media cho Speaking", 0, 30, "", "")?>
        <?=$form->text("Thứ tự", "lec_order", "lec_order", $lec_order, "Thứ tự", 0, 40, "", 255, "", "", "")?>
        <?=$form->text("Hướng dẫn", "lec_note", "lec_note", $lec_note, "Hướng dẫn", 0, 200, 22, 255, "", "", "")?>
        <tr>
            <td colspan="2">
            <?=$form->wysiwyg("Câu hỏi", "lec_question",$lec_question, "../../resource/wysiwyg_editor/", 800, 300)?>
            </td>
        </tr>
        <tr>
            <td colspan="2">
            <?=$form->wysiwyg("Đoạn văn", "lec_text", $lec_text, "../../resource/wysiwyg_editor/", 800, 300)?>
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
    
    <p class="head">- Danh sách Speaking có trong UNIT</p>
    <table border="1" cellpadding="3" cellspacing="0" class="tablelist" width="90%" bordercolor="#E3E3E3">
    <tr class="head"> 
        <td class="bold bg" width="2%" nowrap="nowrap" align="center" style="background: none;"><img src="<?=$fs_imagepath?>save.png" border="0"/></td>
		<td class="bold bg" width="30%"><?=translate_text("Đoạn văn")?></td>
        <td class="bold bg" width="30%"><?=translate_text("Hướng dẫn")?></td>
        <td class="bold bg" align="center" width="100">Media</td>
        <td class="bold bg" align="center" width="40">Order</td>
        <td class="bold bg" align="center" width="30" >Sửa</td>
        <td class="bold bg" align="center" width="30" >Xóa</td>
        <td class="bold bg" align="center" width="30" >Preview</td>
	</tr>
   <form action="quickedit.php?returnurl=<?=base64_encode(getURL())?>" method="post" name="form_listing" id="form_listing" enctype="multipart/form-data">
	<input type="hidden" name="iQuick" value="update" />
    <? 		
	$i=0;
   $j = 0;
	while($row = mysql_fetch_array($db_Speaking->result)){ $i++;
	?>
   <tr <? if($i%2==0) echo ' bgcolor="#FAFAFA"';?>>
      <td></td>
      <?/*<td nowrap="nowrap">
      	<textarea style="width: 240px;height: 60px;"><?php echo $row['gram_content_en'] ?></textarea>
      </td>*/?>
      <td align="center" width="100">
         <textarea style="width: 240px;height: 60px;"><?php echo $row['lec_text'] ?></textarea>
      </td>
      <td nowrap="nowrap">
   	   <textarea style="width: 240px;height: 60px;"><?php echo $row['lec_note'] ?></textarea>
      </td>
      <td nowrap="nowrap">            
         <?php 
         $url = $mediapath.$row['lec_media'];
         checkmedia_les($row['lec_media_type'],$url);
         ?>   
      </td>
      <td align="center" width="30">
         <input style="width:30px;background: #eee;" type="text" readonly="" value="<?=$row["lec_order"]?>" />
      </td>
      <td align="center"><a class="text" href="edit.php?record_id=<?=$row["lec_id"]?>&returnurl=<?=base64_encode(getURL())?>"><img src="<?=$fs_imagepath?>edit.png" alt="EDIT" border="0"></a></td>
      <td align="center"><img src="<?=$fs_imagepath?>delete.gif" alt="DELETE" border="0" onClick="if (confirm('Are you sure to delete?')){ window.location.href='delete.php?record_id=<?=$row["lec_id"]?>&returnurl=<?=base64_encode(getURL())?>'}" style="cursor:pointer"></td>
      <td align="center"><a class="text" target="_blank" href="<?=$link?>">Preview</a></td>
   </tr>
   <?php } unset($db_Speaking) ?>
   </form>
   </table>
<? /*------------------------------------------------------------------------------------------------*/ ?>
</body>
</html>
<style>
.a_detail{padding: 3px 15px;border:solid 1px;background:#EEE;text-decoration:none;}
</style>