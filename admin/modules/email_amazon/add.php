<?
	include "inc_security.php";	
    require_once("../../../classes/amazon_ses.php");
    require_once("../../../amazon-sdk/sdk.class.php");
	//Kiem tra quyen them sua xoa
	checkAddEdit("add");
    
    
    
    $base_url          =  $_SERVER['HTTP_HOST'];
	
	$fs_action		=	"";
	$fs_errorMsg	=	"";    
    
	$ema_time		=	time();
    $content = getValue("ema_content","str","POST","Hoc123.vn - Không rõ nội dung",0);
    $ema_content = stripcslashes($content);
	
	$myform	=	new generate_form();
	$myform->removeHTML(0);
     
	$myform->add('ema_title', 'ema_title', 0, 0, '', 1, 'Bạn chưa nhập tiêu đề gửi', 0, '');
	$myform->add('ema_send', 'ema_send', 0, 0, '', 1, 'Bạn chưa nhập email gửi đi', 0, '');
	$myform->add('ema_content', 'ema_content', 0, 1, '', 1, 'Bạn chưa nhập nội dung gửi', 0, '');
	$myform->add('ema_time','ema_time', 1, 1, '', 0, '', 0, '');
	
	
	$myform->addTable($fs_table);
	
	$action			= getValue("action","str","POST","");
	if($action 		== 'execute'){
        //Check form data
		$fs_errorMsg .= $myform->checkdata();
		if($fs_errorMsg == ""){
			$myform->addTable($fs_table);
			$db_insert 		= new db_execute_return();
			$last_id			= $db_insert->db_execute($myform->generate_insert_SQL());
            //Gửi email đi cho danh sách user
            if($last_id > 0) {
                    $_SESSION['email_amazon_id'] = $last_id;
                    $_SESSION['total_email'] = 0;
                    $post_send = "<form action='http://".$base_url."/home_v2/send_email.php?c=0' method='post' target='_blank' name='frm'>";
                    $post_send .= "</form>";
                    $post_send .= '<script language="JavaScript">document.frm.submit();</script>';
                    echo $post_send;
                    redirect('listing.php');
            }
            
		}
        
	}
	
	$myform->addFormname("add_new");
	$myform->evaluate();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<?=$load_header?>
<? $myform->checkjavascript();?>
</head>
<body topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0">
<?=template_top(translate_text("Add merchant"))?>
	<p align="center" style="padding-left:10px;">
		<?
		$form = new form();
		$form->create_form("add_new",$fs_action,"post","multipart/form-data","onsubmit='validateForm(); return false;'");
		$form->create_table();		
		?>
		<?=$form->text_note('Những ô dấu sao (<font class="form_asterisk">*</font>) là bắt buộc phải nhập.')?>
		<? //Khai bao thong bao loi ?>
		<?=$form->errorMsg($fs_errorMsg)?>
		<?=$form->text("Tiêu đề gửi ", "ema_title", "ema_title", $ema_title, "Tiêu đề gửi", 1, 250)?>
        <?=$form->text("Email gửi ", "ema_send", "ema_send", $ema_send, "Email gửi", 1, 250)?>
        <?=$form->textarea("Nội dung html","ema_content","ema_content","","Nội dung gửi đi",1,600,500,"","","")?>
		<?=$form->button("submit" . $form->ec . "reset", "submit" . $form->ec . "reset", "submit" . $form->ec . "reset", "Gửi đi" . $form->ec . "Làm lại", "Gửi đi" . $form->ec . "Làm lại", 'style="background:url(' . $fs_imagepath . 'button_1.gif) no-repeat"' . $form->ec . 'style="background:url(' . $fs_imagepath . 'button_2.gif)"', "");?>
		<?=$form->hidden("action", "action", "execute", "");?>
		<?
		$form->close_table();
		$form->close_form();
		unset($form);
		?>
	 </p>
<?=template_bottom() ?>
<div class="wrap_load" style="width: 100%; height: 100%; position: absolute;top: 0px; left: 0px; z-index: 10000; background: rgba(34, 52, 47, 0.6); display: none;"></div>
<div class="load_sending" style="width: 128px; height: 100px; position: absolute; top: 100px; left: 200px;z-index: 10000; display: none;"><img src="load_sending.gif" /></div>
<script>
    $('#submit').click(function() {
        $('.wrap_load').css('display','block');
        $('.load_sending').css('display','block');
    })
</script>
</body>
</html>