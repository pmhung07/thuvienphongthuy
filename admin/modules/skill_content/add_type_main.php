<?php
require_once("inc_security.php");
//check quy?n them sua xoa
checkAddEdit("add");

	//Khai bao Bien
   $fs_redirect = base64_decode(getValue("url","str","GET",base64_encode("listing.php")));
	$record_id = getValue("record_id");
   $db_Main = new db_query("SELECT * FROM  main_lesson
									 WHERE  main_skl_cont_id = ".$record_id." ORDER BY main_order");
                                    
   $db_Lesson = new db_query("SELECT skl_les_id,skl_les_name,skl_cont_id,skl_cont_title,skl_cont_order
      							   FROM  skill_lesson,skill_content
      							   WHERE skill_lesson.skl_les_id = skill_content.skl_cont_les_id
                              AND skill_content.skl_cont_id = ".$record_id);
                              
   while($row_lesson = mysql_fetch_assoc($db_Lesson->result)){
      $nLesson = $row_lesson['skl_les_name'];
      $nContent = $row_lesson['skl_cont_order'];
      //$nCourse  = $row_lesson['com_cou_id'];
   }; unset($db_Lesson);
   
   //Khai bao mang kieu bai hoc chinh
   $array_main_type 		= array(0 => translate_text("Ẩn phần text nội dung(có nút nội dung và nút dịch)"),
                                1 => translate_text("Hiển thị phần text nội dung(ko có nút nội dung và nút dịch)"),
                                2 => translate_text("Hiển thị text nội dung(ko có nút nội dung,có nút dịch)")
                                );  
   $myform 	= new generate_form();
   //Loại bỏ chuc nang thay the Tag Html
   $myform->removeHTML(0);
   $myform->add("main_skl_cont_id", "main_skl_cont_id", 1, 0,$record_id, 0, "", 0, "");
   $myform->add("main_content_vi","main_content_vi",0,0,"",0,"",0,"");
   $myform->add("main_content_en","main_content_en",0,0,"",0,"",0,"");
   $myform->add("main_media_type","main_media_type",1,0,0,0,"",0,"");
   $myform->add("main_type","main_type",1,0,0,0);
   $myform->add("main_order", "main_order", 1, 0, 0, 0, "", 0, "");
	//Add table
	$myform->addTable("main_lesson");
	//Warning Error!
	$fs_errorMsg = "";
	//Get Action.
	$action	= getValue("action", "str", "POST", "");
    if($action == "execute"){
      $fs_errorMsg .= $myform->checkdata();
      if($fs_errorMsg == ""){
         $upload1		    = new upload("main_media_url1", $mediapath, $fs_extension, $fs_filesize);       
      	$filename1	= $upload1->file_name;    
         if($filename1 != ""){
            $myform->add("main_media_url1","filename1",0,1,0,0);
            foreach($arr_resize as $type => $arr){
      		resize_image($mediapath, $filename1, $arr["width"], $arr["height"], $arr["quality"], $type);
            }
         }
         $fs_errorMsg .= $upload1->show_warning_error();
         if($fs_errorMsg == ""){
      		$myform->removeHTML(0);//loại bỏ  các ký tự html( 0 thi ko loại bỏ, 1: bỏ) tránh lỗi 
      		$db_insert = new db_execute($myform->generate_insert_SQL());
            unset($db_insert);       			
      		redirect("add_type_main.php?url=".base64_encode(getURL())."&record_id=".$record_id);
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
      <tr>
         <td align="right" style="font-size: 12px; font-weight:bold; color:#004000;">Chọn kiểu hiển thị :</td>
         <td align="left">
            <select id="main_type" name="main_type" class="form_control">
               <?
                  foreach($array_main_type as $key => $value){
               ?>
                     <option value="<?=$key?>"><?=$value?></option>
               <?      
                  }
               ?>
            </select>
         </td>
         <td></td>
      </tr>
      <?=$form->radio("Chọn kiểu media","main_media_type","main_media_type",1,$main_media_type,"Ảnh",0,"","")?>
      <?=$form->radio("","main_media_type","main_media_type",2,$main_media_type,"Video",0,"","")?>
      <?=$form->radio("","main_media_type","main_media_type",3,$main_media_type,"Flash",0,"","")?>
      <?=$form->getFile("Media 1", "main_media_url1", "main_media_url1", "Media cho Bài học chính", 0, 30, "", "")?>
      <tr>
         <td colspan="2">
         <?=$form->wysiwyg("Nội dung tiếng anh", "main_content_en", $main_content_en, "../../resource/wysiwyg_editor/", 800, 250)?>
         </td>
      </tr>
      <tr>
         <td colspan="2">
         <?=$form->wysiwyg("Nội dung tiếng việt", "main_content_vi", $main_content_vi, "../../resource/wysiwyg_editor/", 800, 250)?>
         </td>
      </tr>
      <?=$form->text("Thứ tự", "main_order", "main_order", $main_order, "Thứ tự", 0, 40, "", 255, "", "", "")?>
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
         <td class="bold bg" width="150"><?=translate_text("Nội dung tiếng anh")?></td>
         <td class="bold bg" width="150"><?=translate_text("Nội dung tiếng việt")?></td>
         <td class="bold bg" align="center" width="100">Media</td>
         <td class="bold bg" align="center" width="40">Order</td>
         <td class="bold bg" align="center" width="20" >Sửa</td>
         <td class="bold bg" align="center" width="20" >Xóa</td>			
      </tr>
      <form action="quickedit.php?returnurl=<?=base64_encode(getURL())?>" method="post" name="form_listing" id="form_listing" enctype="multipart/form-data">
      <input type="hidden" name="iQuick" value="update" />
       <? 
   		
   	$i=0;
      $j = 0;
   	while($row = mysql_fetch_array($db_Main->result)){ $i++;
       
   	?>
      <tr <? if($i%2==0) echo ' bgcolor="#FAFAFA"';?>>
         <td width="20"><?php echo $i ?></td>
         <td width="" align="left" >
            <textarea style="width: 300px;height: 100px;padding: 0px;">
            <?php echo removeHTML($row['main_content_en']); ?>
            </textarea>  
         </td>
         <td width="" align="left" >
            <textarea style="width: 300px;height: 100px;">
            <?php echo removeHTML($row['main_content_vi']); ?>
            </textarea>  
         </td>
         <td nowrap="nowrap">
            <?php 
            $url = $mediapath.$row['main_media_url1'];         
            checkmedia_les($row['main_media_type'],$url);
            ?>               
         </td>
         <td align="center" width="30">
         <input style="width:30px;background: #eee;" type="text" readonly="" value="<?=$row["main_order"]?>" />
         </td>
         <td align="center"><a class="text" href="edit_type_main.php?record_id=<?=$row["main_id"]?>&returnurl=<?=base64_encode(getURL())?>"><img src="<?=$fs_imagepath?>edit.png" alt="EDIT" border="0"></a></td>
         <td align="center"><img src="<?=$fs_imagepath?>delete.gif" alt="DELETE" border="0" onClick="if (confirm('Are you sure to delete?')){ window.location.href='del_type_main.php?record_id=<?=$row["main_id"]?>&returnurl=<?=base64_encode(getURL())?>'}" style="cursor:pointer"></td>
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