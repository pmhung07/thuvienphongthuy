<?
include("inc_security.php");
checkAddEdit("add");

//Khai báo biến khi thêm mới
$after_save_data	= getValue("after_save_data", "str", "POST", "add.php");
$add					= "add.php";
$listing				= "listing.php";
//$add_answer       = "confirmation.php?url=". base64_encode(getURL()). "&exe_id=". $exe_id ."&TB_iframe=true&amp;height=450&amp;width=950";
$fs_title			= "Add New Member";
$fs_action			= getURL();
$fs_redirect		= $after_save_data;
$fs_errorMsg		= "";

//Get course id
$iskill_les          = "";
$iskill_les          = getValue("iskill_les","int","GET",0);
//Get active
$exe_active    	= getValue("exe_active", "int", "POST", 0);
//Set date
$exe_date    	   = time();
//Set_type
$exe_type         = 0;
//Display information of course
if($iskill_les > 0){
   $db_les_select = new db_query("SELECT skl_les_name,cat_name 
                                  FROM skill_lesson INNER JOIN categories_multi 
                                  ON skl_les_cat_id = cat_id WHERE skl_les_id = ". $iskill_les ."");
} 

//Get unit - lesson 
if($iskill_les > 0){
   $sql = "skl_cont_les_id = ". $iskill_les ."";
}else {$sql=1;}
$menu 				= new menu();
//$arrCource 			= $menu->getAllChild("courses_multi","com_id","com_parent_id",0,$sql,"com_name","com_id",0);


//get unit:
$arr_get_content[''] = "[-----Danh mục Content-----]";
if($iskill_les > 0){
   $sql_get_content = new db_query("SELECT skl_cont_id,skl_cont_title,skl_cont_order
                                 FROM skill_content 
                                 WHERE skl_cont_active = 1 AND skl_cont_les_id = ". $iskill_les ." ORDER BY skl_cont_order ASC");
   $count_content = 1;
   while($row_content = mysql_fetch_assoc($sql_get_content->result)){
      if($row_content['skl_cont_title'] != ""){
         $arr_get_content[$row_content["skl_cont_id"]] = $row_content['skl_cont_title'];
      }
      else{
         $arr_get_content[$row_content["skl_cont_id"]] = "Content so ".$row_content['skl_cont_order'];
      }
      $count_content++;
   }unset($sql_get_content);
} 

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
//Call Class generate_form();
$myform = new generate_form();
$myform->add("exe_skl_cont_id","cont_select",1,0,"",1,"Bạn chưa chọn [Content]",0,"");
$myform->add("exe_name","exe_name",0,0,"",1,"Bạn chưa nhập tên [Quiz]",0,"");
$myform->add("exe_type","exe_type",1,1,0,0,"",0,"");
$myform->add("exe_date","exe_date",1,1,0,0,"",0,"");
$myform->add("exe_active","exe_active",1,1,0,0,"",0,"");
$myform->addTable($fs_table);
//Get action variable for add new data
$action				= getValue("action", "str", "POST", "");
//Check $action for insert new data
if($action == "execute"){
   $fs_errorMsg .= $myform->checkdata();
   if($fs_errorMsg == ""){
      $myform->removeHTML(0);
   	$db_insert = new db_execute($myform->generate_insert_SQL());
   	unset($db_insert);
      //Redirect after insert complate
   	if($fs_redirect)
      redirect($fs_redirect);
   }
}
$myform ->addFormname("add_new");
$myform ->evaluate();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<?=$load_header?>
<? 
//add form for javacheck
$myform->checkjavascript(); 
//chuyển các trường thành biến để lấy giá trị thay cho dùng kiểu getValue
$fs_errorMsg .= $myform->strErrorField;
?>
</head>
<body>
<? /*------------------------------------------------------------------------------------------------*/ ?>
<?=template_top($fs_title)?>
<? /*------------------------------------------------------------------------------------------------*/ ?>
   <div class="search">
      <form action="" onsubmit="searchKeyword(); return false;">
         <table>
            <tr>
               <td class="form_name">Tìm kiếm khóa học :</td>
               <td>
            		<div><input type="text" maxlength="255" autocomplete="off" name="keyword" id="keyword" class="form_control ip_search" onblur="searchKeyword()"/>
                  <input type="button" value="Tìm"  class="form_control btn_search" onclick="searchKeyword()" /></div>
                  <input type="hidden" name="check_add" id="check_add" value="check_add"/></div>
                  <p class="p_note">
                     • Chọn Bài học : Tìm theo [Mã bài học] hoặc [Tên bài học] <br/>
                     • Chọn phần thêm Bài tập : Chọn [Content] để thêm bài tập <br/>
                     • Nhập tên [Bài tập] như ví dụ <br/>
                  </p>
               </td>
            </tr>
         </table>
      </form>
      <div style="float: left;" id="show_result"></div>
   <div id="wr_add_course">
      <div <?=($iskill_les <= 0) ? "style='background:#FFFFCC;position: absolute;width:600px;height:100%;opacity:0.6'" : '';?>></div>
     	<?
   	$form = new form();
   	$form->create_form("add", $fs_action, "post", "multipart/form-data",'onsubmit="validateForm(); return false;"');
   	$form->create_table();
      ?>    
         <?=$form->text_note('<strong style="textalign:center;">----------- Thêm mới Quiz --------------</strong>')?>
      	<?=$form->text_note('Những ô có dấu sao (<font class="form_asterisk">*</font>) là bắt buộc phải nhập.')?>
      	<?=$form->errorMsg($fs_errorMsg)?>
         <?
         if($iskill_les > 0){
            if($row_les = mysql_fetch_assoc($db_les_select->result)){?>
               <tr>
                  <td class="form_name">Danh mục :</td>
                  <td class="form_text"><p class="p_name_course"><?=$row_les["cat_name"]?></p></td>
               </tr>    
               <tr>
                  <td class="form_name">Bài học :</td>
                  <td class="form_text"><p class="p_name_course"><?=$row_les["skl_les_name"]?></p></td>
               </tr>  
         <?}unset($db_les_select);}?>
         <?//=$form->select_db_multi("Chọn Unit", "exe_com_id", "exe_com_id", $arrCource, "com_id", "com_name", $exe_com_id, "Danh mục bài học", 0, 256, 1, 0, "", "")?>
         <?=$form->select("Chọn Content","cont_select","cont_select",$arr_get_content,$cont_select,"Chọn [Content] để thêm [Quiz]",1,186,"");?>
         <?=$form->text("Nhập tên Quiz", "exe_name", "exe_name", $exe_name, "Tên [Quiz]", 1, 180, "", 255, "", "", "<span style='color:red;padding-left:5px;'>• Example: Quiz[NumQuiz][Content]</span>")?>
        	<?=$form->checkbox("Kích hoạt", "exe_active", "exe_active", 1, 1, "Kích hoạt", 0, "", "")?>
      	<?=$form->radio("Sau khi lưu dữ liệu", "add_new" . $form->ec . "return_listing", "after_save_data", $add . $form->ec . $listing, $after_save_data, "Thêm mới" . $form->ec . "Quay về danh sách", 0, $form->ec, "");?>
      	<?=$form->button("submit" . $form->ec . "reset", "submit" . $form->ec . "reset", "submit" . $form->ec . "reset", "Cập nhật" . $form->ec . "Làm lại", "Cập nhật" . $form->ec . "Làm lại", 'style="background:url(' . $fs_imagepath . 'button_1.gif) no-repeat"' . $form->ec . 'style="background:url(' . $fs_imagepath . 'button_2.gif)"', "");?>
      	<?=$form->hidden("action", "action", "execute", "");?>
   	<?
   	$form->close_table();
   	$form->close_form();
   	unset($form);
   	?>
   </div>
   
<? /*------------------------------------------------------------------------------------------------*/ ?>
<?=template_bottom() ?>
<? /*------------------------------------------------------------------------------------------------*/ ?>
</body>
</html>
<script>
function searchKeyword(){
	keyvalue = document.getElementById("keyword").value;
   check = document.getElementById("check_add").value;
	$.post('search_course.php', { keyword:  keyvalue , check: check}, function(data) {
	  $('#show_result').html(data);
	});
}
</script>
<style>
.search{margin-top:10px;background:#F5F4F1;width: 600px;float: left;margin-right: 100%;}
.ip_search{width: 175px;float:left;margin-left:12px;}
.btn_search{float:left;padding: 0 5px;height: 18px;line-height:18px;margin-top:2px;cursor:pointer;}
.p_note{color:red;float:left;margin:0 12px;font-size:10px;}
#wr_add_course{position:relative;margin-top: 20px;float: left;width: 600px;}
.p_name_course{padding-left:5px;font-weight:bold;color:#6E7C86;margin:0px;}
</style>