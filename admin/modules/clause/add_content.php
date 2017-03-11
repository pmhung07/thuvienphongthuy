<?
include("inc_security.php");
checkAddEdit("add");
//khai báo biến
$fs_redirect 	= base64_decode(getValue("url","str","GET",base64_encode("listing.php")));
$record_id 		= getValue("record_id");
$fs_errorMsg	= '';
//$fs_fieldupload = "images_story";
/*
Call class form:
1). Ten truong
2). Ten form
3). Kieu du lieu , 0 : string , 1 : kieu int, 2 : kieu email, 3 : kieu double, 4 : kieu hash password
4). Noi luu giu data  0 : post, 1 : variable
5). Gia tri mac dinh, neu require thi phai lon hon hoac bang default
6). Du lieu nay co can thiet hay khong
7). Loi dua ra man hinh
8). Chi co duy nhat trong database
9). Loi dua ra man hinh neu co duplicate
*/

$myform = new generate_form();
$myform->add("clause_content", "clause_content", 0, 0, "", 1, "", 0, "");
//Add table insert data
$myform->addTable("clause");

//Get action variable for add new data
$action				= getValue("action", "str", "POST", "");
//Check $action for insert new data
if($action == "execute"){
	if($fs_errorMsg == ""){
	   $myform->removeHTML(0);  
		//Insert to database
		$db_ex = new db_execute($myform->generate_update_SQL("clause_id", $record_id));      
		redirect($_SERVER['REQUEST_URI']);	  
		
	}//End if($fs_errorMsg == "")
	
}//End if($action == "execute")
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<style type="text/css">
.info_category{
font-weight:bold;
margin:5px;
}
</style>
<?=$load_header?>
<? 
$myform->checkjavascript(); 
//chuyển các trường thành biến để lấy giá trị thay cho dùng kiểu getValue
$myform->evaluate();
$fs_errorMsg .= $myform->strErrorField;
//lay du lieu cua record can sua doi
$db_data 	= new db_query("SELECT * FROM clause 
                            WHERE clause_id = " . $record_id);
if($row 		= mysql_fetch_assoc($db_data->result)){
   foreach($row as $key=>$value){
   	if($key!='lang_id' && $key!='admin_id') $$key = $value;
   }
}else{
		exit();
}
?>
</head>
<body topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0">
<? /*------------------------------------------------------------------------------------------------*/ ?>
	<?
	$form = new form();
	$form->create_form("add", $_SERVER['REQUEST_URI'], "post", "multipart/form-data",'onsubmit="validateForm(); return false;"');
	$form->create_table();
	?>
	<?=$form->text_note('Những ô có dấu sao (<font class="form_asterisk">*</font>) là bắt buộc phải nhập.')?>
	<?=$form->errorMsg($fs_errorMsg)?>
   <div class="form_name" style="text-align:left; padding:5px; width:99%"><font class="form_asterisk">*</font> Nội dung bài viết </div>
   <textarea class="clause_content" id="clause_content" name="clause_content" style="height: 270px;"><?=$clause_content?></textarea>
   <script src="/../../js/tinymce/tinymce.min.js" type="text/javascript" charset="utf-8"></script>
   <script type="text/javascript">
   tinymce.init({
      selector: "textarea",   
      plugins: [
         "advlist autolink lists link charmap print preview anchor",
         "searchreplace visualblocks code fullscreen",
         "insertdatetime media table contextmenu paste jbimages image",
      ],
      toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image jbimages",  
      relative_urls: false , 
      theme_advanced_buttons1: "forecolor,backcolor,fontselect,fontsizeselect",  
   });
   </script>          
  	<?=$form->button("submit" . $form->ec . "reset", "submit" . $form->ec . "reset", "submit" . $form->ec . "reset", "Cập nhật" . $form->ec . "Đóng cửa sổ", "Cập nhật" . $form->ec . "Đóng cửa sổ", 'style="background:url(' . $fs_imagepath . 'button_1.gif) no-repeat"' . $form->ec . 'style="background:url(' . $fs_imagepath . 'button_2.gif)" onclick="window.parent.tb_remove()"', "");?>
	<?=$form->hidden("action", "action", "execute", "");?>
	<?//=$form->hidden("ppic_temp_key", "ppic_temp_key", $temp_key, "");?>
	<?
	$form->close_table();
	$form->close_form();
	unset($form);
	?>
	
<? /*------------------------------------------------------------------------------------------------*/ ?>
</body>
</html>
<style>
.a_detail{padding: 3px 15px;border:solid 1px;background:#EEE;text-decoration:none;color: #8C99A5;}
</style>