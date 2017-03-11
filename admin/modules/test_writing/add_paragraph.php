<?
include("inc_security.php");
checkAddEdit("add");
//khai báo biến
$fs_redirect 	= base64_decode(getValue("url","str","GET",base64_encode("listing.php")));
$record_id 		= getValue("record_id");
$fs_errorMsg	= '';

$iTyp          = getValue("iTyp","int","GET","1");
$arr_form      = array(1 => "Câu 1" , 2 => "Câu 2");

$time_ques_minute	= getValue("time_ques_minute", "int", "POST", 0);
$time_ques_second	= getValue("time_ques_second", "int", "POST", 0);
$time_ques_minute_cv = $time_ques_minute * 60;
$total_ques_time = $time_ques_minute_cv + $time_ques_second;

$time_audio_minute	= getValue("time_audio_minute", "int", "POST", 0);
$time_audio_second	= getValue("time_audio_second", "int", "POST", 0);
$time_audio_minute_cv = $time_audio_minute * 60;
$total_audio_time = $time_audio_minute_cv + $time_audio_second;

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

$db_listing = new db_query("SELECT * FROM  test_content WHERE tec_typ_id = ".$record_id." ORDER BY tec_order");
$total_row = mysql_num_rows($db_listing->result);

$myform = new generate_form();
if($iTyp == 1){
   $myform->add("tec_name", "tec_name", 0, 0, "", 1, "Bạn chưa nhập tiêu đề đoạn văn", 0, "");
   $myform->add("tec_content", "tec_content", 0, 0, "", 1, "Bạn chưa nhập nội dung cho đoạn văn", 0, "");
   $myform->add("tec_ques", "tec_ques", 0, 0, "", 0, "Bạn chưa nhập câu hỏi", 0, "");
   $myform->add("tec_time_ques", "total_ques_time", 1, 1, 0, 0, "", 0, "");
   $myform->add("tec_time_audio", "total_audio_time", 1, 1, 0, 0, "", 0, "");
   $myform->add("tec_order", "tec_order", 1, 0, 0, 0, "", 0, "");
   $myform->add("tec_typ_id", "record_id", 1, 1, 0, 0, "", 0, "");
}elseif($iTyp == 2){
   $myform->add("tec_name", "tec_name", 0, 0, "", 1, "Bạn chưa nhập tiêu đề đoạn văn", 0, "");
   $myform->add("tec_ques", "tec_ques", 0, 0, "", 0, "Bạn chưa nhập câu hỏi", 0, "");
   $myform->add("tec_order", "tec_order", 1, 0, 0, 0, "", 0, "");
   $myform->add("tec_typ_id", "record_id", 1, 1, 0, 0, "", 0, "");      
}
//Add table insert data
$myform->addTable("test_content");
       
//Get action variable for add new data
$action				= getValue("action", "str", "POST", "");
//Check $action for insert new data
if($action == "execute"){
   
   $upload		= new upload("tec_audio", $data_path, $fs_extension, $fs_filesize);
   $filename	= $upload->file_name;
   if($filename != ""){
   	$myform->add("tec_audio","filename",0,1,0,0);
   }	
   $fs_errorMsg .= $upload->show_warning_error();
   $fs_errorMsg .= $myform->checkdata();
	$fs_errorMsg .= $upload->warning_error;
   if($total_row < 2){
   	if($fs_errorMsg == ""){
   		$myform->removeHTML(0);
   		//Insert to database
   		$db_insert		= new db_execute($myform->generate_insert_SQL());
   		redirect($_SERVER['REQUEST_URI']);
   		
   	}//End if($fs_errorMsg == "")
	}else{
      echo("<script>alert('Chỉ được thêm 2 câu trong phần Writing')</script>");
      redirect($_SERVER['REQUEST_URI']);
   }
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
?>
</head>
<body>                                                                                   
<? /*------------------------------------------------------------------------------------------------*/ ?>
	<?
	$form = new form();
	$form->create_form("add", $_SERVER['REQUEST_URI'], "post", "multipart/form-data",'onsubmit="validateForm(); return false;"');
	$form->create_table();
	?>
   <tr>
      <td class="form_name">Form câu hỏi : </td>
      <td>
        <select onclick="" class="form_control" style="width: 500px;" name="form_type" id="form_type">
            <option value=""> - Chọn Form câu hỏi - </option>
            <?foreach($arr_form as $id=>$name){?>
         		<option value="<?=$id?>"<?=($id == $iTyp) ? "selected='selected'" : ""?>><?=$name?></option>
         	<?}?>
         </select> 
      </td>
   </tr>
	<?=$form->text_note('Những ô có dấu sao (<font class="form_asterisk">*</font>) là bắt buộc phải nhập.')?>
	<?=$form->errorMsg($fs_errorMsg)?>
   <?if($iTyp == 1){?>
      <?=$form->text("Tiêu đề", "tec_name", "tec_name", $tec_name, "Tiêu đề đoạn văn", 1, 272, "", 255, "", "", "")?>
      <tr>
         <td></td>
         <td><?=$form->wysiwyg("<font class='form_asterisk'>*</font> Nội dung đoạn văn", "tec_content", $tec_content, "../../resource/wysiwyg_editor/", 800, 250)?></td>
      </tr>
      <?=$form->textarea("Câu hỏi", "tec_ques", "tec_ques", $tec_ques, "Câu hỏi", 0, 272, "", 255, "", "", "")?>
      <tr>
         <td>Thời gian câu hỏi :</td>
         <td>
            <input id="time_ques_minute" name="time_ques_minute" value="<?=$time_ques_minute?>" type="text" class="time_ques_minute"/> minutes
            <input id="time_ques_second" name="time_ques_second" value="<?=$time_ques_second?>" type="text" class="time_ques_second"/> seconds
            <span style="color: #717F89;">(Ví dụ : mm/ss)</span>
         </td>
      </tr>
      <?=$form->getFile("Tải Audio", "tec_audio", "tec_audio", "Tải audio", 0, 30, "", "")?>
      <tr>
         <td>Thời gian audio :</td>
         <td>
            <input id="time_audio_minute" name="time_audio_minute" value="<?=$time_audio_minute?>" type="text" class="time_audio_minute"/> minutes
            <input id="time_audio_second" name="time_audio_second" value="<?=$time_audio_second?>" type="text" class="time_audio_second"/> seconds
            <span style="color: #717F89;">(Ví dụ : mm/ss)</span>
         </td>
      </tr>
   	<?=$form->text("Thứ tự", "tec_order", "tec_order", $tec_order, "Thứ tự", 0, 40, "", 255, "", "", "")?>
   <?}elseif($iTyp == 2){?>
      <?=$form->text("Tiêu đề", "tec_name", "tec_name", $tec_name, "Tiêu đề đoạn văn", 1, 272, "", 255, "", "", "")?>
      <?=$form->textarea("Câu hỏi", "tec_ques", "tec_ques", $tec_ques, "Câu hỏi", 0, 272, "", 255, "", "", "")?>
     	<?=$form->text("Thứ tự", "tec_order", "tec_order", $tec_order, "Thứ tự", 0, 40, "", 255, "", "", "")?>
   <?}?>
	<?=$form->button("submit" . $form->ec . "reset", "submit" . $form->ec . "reset", "submit" . $form->ec . "reset", "Cập nhật" . $form->ec . "Đóng cửa sổ", "Cập nhật" . $form->ec . "Đóng cửa sổ", 'style="background:url(' . $fs_imagepath . 'button_1.gif) no-repeat"' . $form->ec . 'style="background:url(' . $fs_imagepath . 'button_2.gif)" onclick="window.parent.tb_remove()"', "");?>
	<?=$form->hidden("action", "action", "execute", "");?>
	<?//=$form->hidden("ppic_temp_key", "ppic_temp_key", $temp_key, "");?>
	<?
	$form->close_table();
	$form->close_form();
	unset($form);
	?>
	
<? /*------------------------------------------------------------------------------------------------*/ ?>
	<div style="padding-left:3px; padding-right:3px;padding-top: 30px;">
	<table cellpadding="5" cellspacing="0" width="100%" style="border-collapse:collapse;" bordercolor="#CCCCCC" border="1">
		<tr>
			<th width="10">ID</th>
			<th width="150px">Tiêu đề</th>
         <th width="100">Câu hỏi</th>
         <th width="200">Audio</th>
			<th width="70">Thứ tự</th>
         <th width="30" align="center">Sửa</th>
			<th width="30" align="center">Xóa</th>
		</tr>
		<?
		$sql = '';
		//if($temp_key != '') $sql .= " AND ppic_temp_key = '" . $temp_key . "'";
		$db_picture = new db_query("SELECT * FROM  test_content
											 WHERE  tec_typ_id = " . $record_id . $sql . " ORDER BY tec_order");
		?>
		<?
		$i=0;
		while($row = mysql_fetch_assoc($db_picture->result)){
			$i++;
		?>
			<tr <?=$fs_change_bg?>>
				<td align="center"><?=$i?></td>
				<td align="center" width="150">
               <input style="width: 195px;" type="text" readonly="" value="<?=$row["tec_name"]?>" />
            </td>
            <td>
               <input style="width: 195px;" type="text" readonly="" value="<?=$row["tec_ques"]?>" />
            </td>
            <td align="center" width="200">
               <?
                  if($row['tec_audio'] != ""){
                     $url = $data_path.$row['tec_audio'];
                     checkmedia_exe(2,$url);
                  }else{
                     echo "Không có Audio";
                  }
               ?>
            </td>
            <td width="50" align="center"><?=$row["tec_order"]?></td>
				<td align="center"><a href="edit_paragraph.php?record_id=<?=$row["tec_id"]?>&tec_typ_id=<?=$record_id?>&url=<?=base64_encode($_SERVER['REQUEST_URI'])?>" href="#" class="edit"><img border="0" src="<?=$fs_imagepath?>edit.gif"/></a></td>
  		      <td align="center"><img src="<?=$fs_imagepath?>delete.gif" alt="DELETE" border="0" onClick="if (confirm('Are you sure to delete?')){ window.location.href='del_paragraph.php?record_id=<?=$row["tec_id"]?>&returnurl=<?=base64_encode(getURL())?>'}" style="cursor:pointer"></td>   
          </tr>
		<?
		}
		?>
	</table>
	</div>
<? /*------------------------------------------------------------------------------------------------*/ ?>

</body>
</html>

<script>
$(document).ready(function() {
   $('#form_type').change(function (){
      var iTyp		   =	$("#form_type").val();
      window.location	=	"add_paragraph.php?&record_id=<?=$record_id?>&iTyp=" +iTyp;
   });
}); 
</script>

<style>
.a_detail{padding: 3px 15px;border:solid 1px;background:#EEE;text-decoration:none;}
</style>

