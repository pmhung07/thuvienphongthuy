<?
include("inc_security.php");
checkAddEdit("edit");
$fs_errorMsg = "";

$fs_action = getURL();
$fs_redirect = base64_decode(getValue("url","str","GET",base64_encode("listing.php")));
$record_id = getValue("record_id");

$after_save_data	= getValue("after_save_data", "str", "POST", "add.php");
$add					= "add.php";
$listing				= "listing.php";

//Get course id
$iCourse = "";
$iCourse = getValue("iCourse","int","GET",0);

//Get unit id
$iUnit            = "";
$iUnit            = getValue("iUnit","int","GET",0);

//Get com id
$iLesson = "";
$iLesson = getValue("iLesson","int","GET",0);

//Get iLessonType
$iLessonType = "";
$iLessonType = getValue("iLessonType","int","GET",0);

//Set type_of_lesson
$type_of_lesson   = array(1 => "Content Main Lesson" , 2 => "Grammar Lesson" , 3 => "Vocabulary Lesson");

//Display information of course
if($iCourse > 0){
   $db_course_select = new db_query("SELECT cou_name,cat_name
                                     FROM courses INNER JOIN categories_multi
                                     ON cou_cat_id = cat_id WHERE cou_id = ". $iCourse ."");
}

//Display all Unit of Courses
if($iCourse > 0){
   $sql_get_unit = new db_query("SELECT com_id,com_name
                                 FROM courses_multi
                                 WHERE com_active = 1 AND com_cou_id = ". $iCourse ."");
   while($row_unit = mysqli_fetch_assoc($sql_get_unit->result)){
      $arr_get_unit[$row_unit["com_id"]] = $row_unit["com_name"];
   }unset($sql_get_unit);
}

//Get active
$exe_active    	= getValue("exe_active", "int", "POST", 0);
//Get type lesson
$type_les    	   = getValue("type_les", "int", "POST", -1);
//Set date
$exe_date    	   = time();
//Set_type
$exe_type         = 1;

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
$myform->add("exe_com_id","unit_select",1,0,"",1,"Bạn chưa chọn [Unit]",0,"");
$myform->add("exe_name","exe_name",0,0,"",1,"Bạn chưa nhập tên [Quiz]",0,"");
$myform->add("exe_type","exe_type",1,1,1,0,"",0,"");
$myform->add("exe_type_lesson","les_type",1,0,"",1,"Bạn chưa chọn phân loại trong bài học",0,"");
$myform->add("exe_date","exe_date",1,1,0,0,"",0,"");
$myform->add("exe_active","exe_active",1,1,0,0,"",0,"");
$myform->addTable($fs_table);
//Get action variable for add new data
$action	= getValue("action", "str", "POST", "");
//Check $action for insert new data
if($action == "execute"){
	$fs_errorMsg .= $myform->checkdata();
   if($fs_errorMsg == ""){
      $myform->removeHTML(0);
		$db_update = new db_execute($myform->generate_update_SQL($id_field, $record_id));
		unset($db_update);
      redirect($fs_redirect);
   }
}//End if($action == "execute")
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<?=$load_header?>
<?
//chuyển các trường thành biến để lấy giá trị thay cho dùng kiểu getValue
$myform->addFormname("edit");
$myform->checkjavascript();
$myform->evaluate();
$fs_errorMsg .= $myform->strErrorField;

//lay du lieu cua record can sua doi
$db_data 	= new db_query("SELECT * FROM " . $fs_table . " WHERE " . $id_field . " = " . $record_id);
if($row 		= mysqli_fetch_assoc($db_data->result)){
	foreach($row as $key=>$value){
		if($key!='lang_id' && $key!='admin_id') $$key = $value;
	}
}else{
   exit();
}

?>
</head>
<body>
<? /*------------------------------------------------------------------------------------------------*/ ?>
<?=template_top(translate_text("Edit member"))?>
   <div class="search">
   <form action="" onsubmit="searchKeyword(); return false;">
      <table>
         <tr>
            <td class="form_name">Tìm kiếm khóa học :</td>
            <td>
         		<div><input type="text" maxlength="255" autocomplete="off" name="keyword" id="keyword" class="form_control ip_search" onblur="searchKeyword()"/>
               <input type="button" value="Tìm"  class="form_control btn_search" onclick="searchKeyword()" /></div>
               <input type="hidden" name="check_edit" id="check_edit" value="check_edit"/></div>
               <input type="hidden" name="record_id" id="record_id" value="<?=$record_id?>"/></div>
               <p class="p_note">
                  • Chọn Khóa học : Tìm theo [Mã khóa học] hoặc [Tên khóa học] <br/>
                  • Chọn [Unit] để thêm bài tập <br/>
                  • Chọn [Lesson] để thêm bài tập <br/>
                  • Phân loại trong bài học <br/>
                  • Nhập tên [Bài tập] như ví dụ <br/>
               </p>
            </td>
         </tr>
      </table>
   </form>
   <div style="float: left;" id="show_result"></div>
   <p align="center" style="padding-left:10px;">
      <?
   	$form = new form();
   	$form->create_form("add", $fs_action, "post", "multipart/form-data",'onsubmit="validateForm(); return false;"');
   	$form->create_table();
      ?>
         <?=$form->text_note('<strong style="textalign:center;">----------- Sửa thông tin Quiz ---------</strong>')?>
      	<?=$form->text_note('Những ô có dấu sao (<font class="form_asterisk">*</font>) là bắt buộc phải nhập.')?>
      	<?=$form->errorMsg($fs_errorMsg)?>
         <?
         if($iCourse > 0){
            if($row_course = mysqli_fetch_assoc($db_course_select->result)){?>
               <tr>
                  <td class="form_name">Danh mục :</td>
                  <td class="form_text"><p class="p_name_course"><?=$row_course["cat_name"]?></p></td>
               </tr>
               <tr>
                  <td class="form_name">Khóa học :</td>
                  <td class="form_text"><p class="p_name_course"><?=$row_course["cou_name"]?></p></td>
               </tr>
         <?}unset($db_course_select);}?>
         <tr>
            <td class="form_name"><font color="red">*</font>&nbsp;Chọn Unit : </td>
            <td>
               <select onchange="load_session()" class="form_control" style="width: 186px;" name="unit_select" id="unit_select">
                  <option value="-1"> - Chọn Units - </option>
                  <?foreach($arr_get_unit as $id=>$name){?>
   						<option value="<?=$id?>" <?=($id == $iUnit) ? "selected='selected'" : ""?>><?=$name?></option>
   					<?}?>
               </select>
            </td>
         </tr>
         <tr>
            <td class="form_name"><font color="red">*</font>&nbsp;Phân loại trong bài học : </td>
            <td>
               <select class="form_control" style="width: 186px;" name="les_type" id="les_type">
                  <option value="-1"> - Phân loại trong bài học - </option>
                  <?foreach($type_of_lesson as $id=>$name){?>
   						<option value="<?=$id?>" <?=($id == $iLessonType) ? "selected='selected'" : ""?>><?=$name?></option>
   					<?}?>
               </select>
            </td>
         </tr>
         <?=$form->text("Nhập tên Quiz", "exe_name", "exe_name", $exe_name, "Tên [Quiz]", 1, 180, "", 255, "", "", "<span style='color:red;padding-left:5px;'>• Example: Unit [NumberUnit] Quiz</span>")?>
        	<?=$form->checkbox("Kích hoạt", "exe_active", "exe_active", 1, $exe_active, "Kích hoạt", 0, "", "")?>
      	<?=$form->radio("Sau khi lưu dữ liệu", "add_new" . $form->ec . "return_listing", "after_save_data", $add . $form->ec . $listing, $after_save_data, "Thêm mới" . $form->ec . "Quay về danh sách", 0, $form->ec, "");?>
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
</body>
</html>

<style>
.search{margin-top:10px;background:#F5F4F1;width: 525px;float: left;margin-right: 100%;}
.ip_search{width: 175px;float:left;margin-left:12px;}
.btn_search{float:left;padding: 0 5px;height: 18px;line-height:18px;margin-top:2px;cursor:pointer;}
.p_note{color:red;float:left;margin:0 12px;font-size:10px;}
#wr_add_course{position:relative;margin-top: 20px;float: left;width: 500px;}
.p_name_course{padding-left:5px;font-weight:bold;color:#6E7C86;margin:0px;}
</style>

<script>
function load_session(){
   var iUnit			=	$("#unit_select").val();
   window.location	=	"edit.php?iCourse=<?=$iCourse?>&record_id=<?=$record_id?>&iLessonType=<?=$iLessonType?>&iUnit=" + iUnit;
}
function searchKeyword(){
	keyvalue = document.getElementById("keyword").value;
   check = document.getElementById("check_edit").value;
   record_id = document.getElementById("record_id").value;
	$.post('search_course.php', { keyword:  keyvalue , check: check , record_id: record_id}, function(data) {
	  $('#show_result').html(data);
	});
}
</script>