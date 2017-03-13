<?
include("inc_security.php");
checkAddEdit("add");

   $fs_title			= $module_name . " | Thêm mới";
   $fs_action			= getURL();
   $fs_errorMsg		= "";
   $add					= "add.php";
   $listing				= "listing.php";
   $after_save_data	= getValue("after_save_data", "str", "POST", "add.php");
   $fs_redirect		= $after_save_data;
   $typ_type         = 1;
   $iTyp             = getValue("iTyp","int","GET",0);

   if($iTyp > 0){
      $db_check_type = new db_query("SELECT typ_id FROM type_test WHERE typ_test_id = ". $iTyp ." AND typ_type = 1");
      $total_row = mysqli_num_rows($db_check_type->result);
      if($total_row > 0){
         echo("<script>alert('Đã tồn tại phần thi Reading của bài thi này!Hãy họn đề thi khác!');</script>");
         redirect("add.php");
      }
   }
   $arr_get_typ = array();
   //Get Test
   $db_select_test = new db_query("SELECT * FROM test STRAIGHT_JOIN type_test ON test_id = typ_test_id WHERE typ_type = 1 GROUP BY typ_test_id");
   $i = 0;
   while($row_a = mysqli_fetch_assoc($db_select_test->result)){
      $arr_get_typ[$i] = $row_a["typ_test_id"];
      $i++;
   }
   //var_dump($arr_get_typ);

   $db_select_test = new db_query("SELECT test_id,test_name FROM test");
   while($row = mysqli_fetch_assoc($db_select_test->result)){
      $arr_get_test[$row["test_id"]] = $row["test_name"];
   }unset($db_select_test);


    /*
	Call class form:
	1). Ten truong
	2). Ten form
	3). Kieu du lieu , 0 : string , 1 : kieu int, 2 : kieu email, 3 : kieu double, 4 : kieu hash password
	4). Noi luu giu data  0 : post(sẽ tìm trong form ở dưới có cotrol nào có name đc khai báo ở (2)), 1 : variable (sẽ tìm những biến nào có tên đã đc khai báo ở (2) )
	5). Gia tri mac dinh, neu require thi phai lon hon hoac bang default
	6). Du lieu nay co can thiet hay khong (tương ứng với bên form bên dưới)
	7). Loi dua ra man hinh nếu mà ko nhập
	8). Chi co duy nhat trong database (0: cho phép trùng ; 1: ko cho phép)
	9). Loi dua ra man hinh neu co duplicate
	*/
   $test_date = time();
   //tạo mới class generate_form
   $myform = new generate_form();
   $myform->add("typ_test_id", "typ_test_id", 1, 0, 0, 1, "Bạn chưa chọn đề thi", 0, "");
   $myform->add("typ_name", "typ_name", 0, 0, "", 1, "Bạn chưa nhập tên phần thi", 0, "");
   $myform->add("typ_type", "typ_type", 1, 1, 1, 0, "", 0, "");
	$myform->addTable($fs_table);
   //Get action variable for add new data
   $action			= getValue("action", "str", "POST", "");
   //Check $action for insert new data
   if($action == "execute"){
      if($fs_errorMsg == ""){
         if($fs_errorMsg == ""){
         	//Insert to database
         	$myform->removeHTML(0);//loại bỏ  các ký tự html( 0 thi ko loại bỏ, 1: bỏ) tránh lỗi
            //thực hiện insert
         	$db_insert = new db_execute($myform->generate_insert_SQL());
         	//unset biến để giải phóng bộ nhớ.
            unset($db_insert);
         	//Redirect after insert complate
         	//$fs_redirect = "add.php?order=" . (getValue("cur_order","int","POST") + 1);
         	redirect($fs_redirect);
         }
      }//End if($fs_errorMsg == "")

   }//End if($action == "insert")
   $myform->addFormname("add_new");
   $myform->evaluate();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<?=$load_header?>
<?
// kiểm tra lỗi và alert ra màn hinh (check ngay tại máy của minh)
$myform->checkjavascript();
//Chú ý : khi check cần có thêm phần check PHP ( bảo mật, thực thi tai sver). t
//chuyển các trường thành biến để lấy giá trị thay cho dùng kiểu getValue
//giữ lại giá trị các control đã nhập nếu bị thông báo lỗi

$fs_errorMsg .= $myform->strErrorField;
?>
</head>
<body topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0">
<? /*------------------------------------------------------------------------------------------------*/ ?>
<?=template_top($fs_title)?>
<? /*------------------------------------------------------------------------------------------------*/ ?>
	<p align="center" style="padding-left:10px;">
	<?
	$form = new form();

	$form->create_form("add", $fs_action, "post", "multipart/form-data",'onsubmit="validateForm(); return false;"');
   $form->create_table();
	?>
   <?=$form->text_note('<strong style="text-align:center;">----------Thêm mới Test Reading-----------</strong>')?>
   <?=$form->text_note('Những ô có dấu sao (<font class="form_asterisk">*</font>) là bắt buộc phải nhập.')?>
   <?=$form->errorMsg($fs_errorMsg)?>
   <tr>
      <td class="form_name"><font color="red">*</font>&nbsp;Chọn đề thi : </td>
      <td>
         <select class="form_control" style="width: 186px;" name="typ_test_id" id="typ_test_id">
            <option value=""> - Chọn đề thi - </option>
            <?foreach($arr_get_test as $id=>$name){
            if(in_array($id,$arr_get_typ)) continue;
            ?>
      			<option value="<?=$id?>"<?=($id == $iTyp) ? "selected='selected'" : ""?>><?=$name?></option>
      		<?}?>
         </select>
      </td>
   </tr>
   <?=$form->text("Tên phần thi", "typ_name", "typ_name", "Reading", "Phần thi", 1, 272, "", 255, "", "", "")?>
   <?//=$form->getFile("Audio hướng dẫn", "typ_direct_audio", "typ_direct_audio", "Tải audio hướng dẫn", 0, 30, "", "")?>
   <?=$form->radio("Sau khi lưu dữ liệu", "add_new" . $form->ec . "return_listing", "after_save_data", $add . $form->ec . $listing, $after_save_data, "Thêm mới" . $form->ec . "Quay về danh sách", 0, $form->ec, "");?>
   <?=$form->button("submit" . $form->ec . "reset", "submit" . $form->ec . "reset", "submit" . $form->ec . "reset", "Cập nhật" . $form->ec . "Làm lại", "Cập nhật" . $form->ec . "Làm lại", 'style="background:url(' . $fs_imagepath . 'button_1.gif) no-repeat"' . $form->ec . 'style="background:url(' . $fs_imagepath . 'button_2.gif)"', "");?>
   <?=$form->hidden("action", "action", "execute", "");?>
   <?
   $form->close_table();
   $form->close_form();
   unset($form);
   ?>
	</p>
<? /*------------------------------------------------------------------------------------------------*/ ?>
<?=template_bottom() ?>
<? /*------------------------------------------------------------------------------------------------*/ ?>
</body>
</html>

<script>
$(document).ready(function() {
   $('#typ_test_id').change(function (){
      var iTyp		   =	$("#typ_test_id").val();
      window.location	=	"add.php?iTyp=" +iTyp;
   });
});
</script>