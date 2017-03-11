<? 
  include "inc_security.php";
  checkAddEdit("add");
  //Cac bien su dung
  $fs_action    = "";
  $fs_errorMsg  = "";
    $record_id = getValue('record_id');
  //Class generate form
  $myform   =   new generate_form();
  $myform->add('ans_content','ans_content',0,0,'',1,'Bạn chưa nhập câu trả lời');
  $myform->addTable('faq_answers');
  $submitform   =   getValue("action", "str", "POST","");
  if($submitform == "execute"){
    $myform->removeHTML(0);
        $fs_errorMsg  .=  $myform->checkdata();
    //Neu khong co l oi
    if($fs_errorMsg == ""){
      $db_insert  = new db_execute($myform->generate_update_SQL($id_answers,$record_id));
      echo $myform->generate_update_SQL($id_field,$record_id);
      unset($db_insert);
        redirect('listing.php');
    }
  }
  
    $myform->addFormname("add_new");
    $myform->evaluate();  
    $db_data = new db_query('SELECT * FROM faq_answers WHERE ans_id = '.$record_id);
    if($row     = mysql_fetch_assoc($db_data->result)){
    foreach($row as $key=>$value){
      if($key!='lang_id' && $key!='admin_id') $$key = $value;
    }
  }else{
      exit();
  }
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<?=$load_header?>
<? $myform->checkjavascript();?>
<?
$fs_errorMsg  .=  $myform->strErrorField;

?>
</head>
<body topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0">
<?=template_top(translate_text("Add merchant"))?>
  <p align="center" style="padding-left:10px;">
   <strong style="text-align:center;">Sửa đổi trả lời</strong>
    <?
    $form = new form();
    $form->create_form("add_new",$fs_action,"post","multipart/form-data","onsubmit='validateForm(); return false;'");
    $form->create_table();    
    ?>
    <?=$form->text_note('Những ô dấu sao (<font class="form_asterisk">*</font>) là bắt buộc phải nhập.')?>
    <? //Khai bao thong bao loi ?>
    <?=$form->errorMsg($fs_errorMsg)?>
        <?=$form->textarea('Nội dung trả lời ','ans_content','ans_content',$ans_content,'',0,400,100)?>
    <?=$form->button("submit" . $form->ec . "reset", "submit" . $form->ec . "reset", "submit" . $form->ec . "reset", "Cập nhật" . $form->ec . "Làm lại", "Cập nhật" . $form->ec . "Làm lại", 'style="background:url(' . $fs_imagepath . 'button_1.gif) no-repeat"' . $form->ec . 'style="background:url(' . $fs_imagepath . 'button_2.gif)"', "");?>
    <?=$form->hidden("action", "action", "execute", "");?>
    <?
    $form->close_table();
    $form->close_form();
    unset($form);
    ?>
   </p>
<?=template_bottom() ?>
<script>

</script>
</body>
</html>