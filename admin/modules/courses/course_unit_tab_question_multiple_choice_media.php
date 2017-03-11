<?
include ("inc_security.php");
$fs_title = $module_name . " | Thêm mới";
checkAddEdit("add");

$iQues            = getValue("iQues","int","GET","");
$fs_action			= getURL();
$fs_errorMsg		= "";
$after_save_data  = getValue("after_save_data", "str", "POST", "add_exercises.php");
$fs_redirect      = $after_save_data;


$arrayMedia = array(
   0 => "Chon kiểu Media",
   1 => "Kiểu Video",
   2 => "Kiểu Audio",
   3 => "Kiểu Images"
);

$myform = new generate_form();  
$myform->add("cou_tab_question_media_type", "cou_tab_question_media_type", 1, 0, 0, 0, "", 0, "");
$myform->add("cou_tab_question_paragraph", "cou_tab_question_paragraph", 0, 0, "", 0, "", 0, "");
$myform->addTable("courses_multi_tab_questions");
//Get action variable for add new data
$action	  = getValue("action", "str", "POST", ""); 
//Check $action for insert new datac

if($action == "execute"){      
   if($fs_errorMsg == ""){    	
   	$myform->removeHTML(0);//loại bỏ  các ký tự html( 0 thi ko loại bỏ, 1: bỏ) tránh lỗi 
      $upload = new upload("cou_tab_question_media", $imgpath_data, $fs_extension_all, $fs_filesize );
      $filename = $upload->file_name;
      if($filename != ""){
         $myform->add("cou_tab_question_media","filename", 0, 1, "", 0);
      }

      //thực hiện insert 
      $db_ex = new db_execute($myform->generate_update_SQL("cou_tab_question_id", $iQues));
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
$db_data 	= new db_query("SELECT * FROM courses_multi_tab_questions WHERE cou_tab_question_id =".$iQues);
if($row 		= mysql_fetch_assoc($db_data->result)){
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
      <tr>
      <td class="form_name">Đoạn văn nếu có :</td>
      <td class="form_text">
         <textarea class="cou_tab_cont_text" id="cou_tab_question_paragraph" name="cou_tab_question_paragraph" style="width:500px;height: 50px;"><?=$cou_tab_question_paragraph?></textarea>
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
      <?=$form->select("Chọn Kiểu Media", "cou_tab_question_media_type", "cou_tab_question_media_type", $arrayMedia, $cou_tab_question_media_type ,"Chọn Kiểu Media cho nội dung",1,"500",1,0,"","")?>
      <?=$form->getFile("Tải Media", "cou_tab_question_media", "cou_tab_question_media", "Tải Media", 0, 30, "", "")?>
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

<? /*------------------------------------------------------------------------------------------------*/ ?>

   
</body>
</html>
