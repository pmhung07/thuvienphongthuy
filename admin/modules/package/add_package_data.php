<?
include("inc_security.php");
checkAddEdit("add");
//khai báo biến
$fs_redirect 	= base64_decode(getValue("url","str","GET",base64_encode("listing.php")));
$record_id 		= getValue("record_id");
$pack_cat_id   = getValue("pack_cat_id");
$fs_errorMsg	= '';
$fs_action			= getURL();
$add					= "add.php";
$listing				= "listing.php";
$db_listAll = new db_query('SELECT cou_id,cou_name
                            FROM courses a, package_data b
                            WHERE a.cou_id = b.padt_data_id
                            AND padt_id = '.$record_id.'
                            ORDER BY padt_id ASC');

$listAll    = $db_listAll->resultArray();

$cat_parent_id	= getValue("cat_parent_id","str","GET","");
$menu = new menu();
$sql = '1';
$listAll = $menu->getAllChild("categories_multi","cat_id","cat_parent_id","0",$sql . " AND lang_id = " . $lang_id . $sqlcategory . " AND cat_type = 1","cat_id,cat_name,cat_order,cat_type,cat_parent_id,cat_has_child","cat_order ASC, cat_name ASC","cat_has_child");

//Call Class generate_form();
if($cat_parent_id != "") $sqlCourse	= new db_query("SELECT cou_id,cou_name,cou_lev_id FROM courses WHERE cou_cat_id = ".$cat_parent_id );
$myform = new generate_form();


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

//====== get variable =====//
$add_couid	   = getValue("add_couid","int","POST","");
//=========================//

   //Get action variable for add new data
   $myform = new generate_form();
   $myform->addTable('package_data');
   $myform->add('padt_data_id','add_couid',1,0,$add_couid,1,'Chưa chọn khóa');
   $myform->add('padt_pack_id','record_id',1,1,0,0,"");
   $action = getValue("action", "str", "POST", "");
   $fs_errorMsg = '';
   if($action == "execute"){
      $db_check_package = new db_query('SELECT count(*) as total_data
                                  FROM package_data
                                  WHERE padt_pack_id ='.$record_id.' AND padt_data_id ='.$add_couid);
      $checkAll = mysqli_fetch_assoc($db_check_package->result);
      $total    = $checkAll['total_data'];
      $fs_errorMsg = $myform->checkdata();
      if($total != 0){
         $fs_errorMsg .="Đã tồn tại khóa học trong gói học này";
      }
      if($fs_errorMsg == ""){
   		$db_insert = new db_execute($myform->generate_insert_SQL());
         unset($db_insert_ans);
      }

   }
$myform->addFormname("add_new");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<?=$load_header?>
<?
$myform->checkjavascript();
$myform->evaluate();
$fs_errorMsg .= $myform->strErrorField;
?>
</head>
<body>
   <?
   $form = new form();
   $form->create_form("add", $_SERVER["REQUEST_URI"], "post", "multipart/form-data",'onsubmit="validateForm(); return false;"');
   $form->create_table();
   ?>
   <tr>
      <td width="120px" class="form_name" colspan="2" style="text-align: center;"><b>Gói học</b></td>
   </tr>
   <?=$form->select_db_multi("Chọn danh mục", "cat_parent_id", "cat_parent_id", $listAll, "cat_id", "cat_name", $cat_parent_id, "Chọn chuyên mục cha", 0, 200, 1, 0, "onChange=\"window.location.href='add_package_data.php?cat_parent_id='+this.value+'&record_id='+$record_id\"", "")?>
   <? //$form->select_db_multi("Chọn Course", "com_cou_id", "com_cou_id", $listCourse, "cou_id", "cou_name", $com_cou_id, "Chọn Course", 1, "", 1, 0, "", "")?>
   <tr>
     <td align="right" nowrap="" class="form_name"><font class="form_asterisk">* </font> <?=translate_text("Chọn Course")?> :</td>
     <td>
         <select name="add_couid" id="add_couid"  class="form_control" style="width: 200px;">
   		<option value="-1">- <?=translate_text("Chọn Course")?> - </option>
   		<?
   		while($row = mysqli_fetch_assoc($sqlCourse->result)){

   		?>
   		<option value="<?=$row['cou_id']?>" ><? echo nameLevel($row['cou_lev_id']).' -- '.$row['cou_name']?></option>
   		<? } ?>
   	</select>
     </td>
   </tr>
   <tr>
      <td colspan="2" style="color: red; text-align: center;"><?=$fs_errorMsg?></td>
   </tr>
   <input type="hidden" name="$record_id" value="<?=$record_id?>" />
	<?=$form->button("submit" . $form->ec . "reset", "submit" . $form->ec . "reset", "submit" . $form->ec . "reset", "Thêm khóa" . $form->ec . "Đóng cửa sổ", "Thêm khóa" . $form->ec . "Đóng cửa sổ", 'style="background:url(' . $fs_imagepath . 'button_1.gif) no-repeat"' . $form->ec . 'style="background:url(' . $fs_imagepath . 'button_2.gif)" onclick="window.parent.tb_remove()"', "");?>
	<?=$form->hidden("action", "action", "execute", "");?>
   <?
   $form->close_table();
   $form->close_form();
   unset($form);
   ?>
   <?//=======================================List ques===============================================?>
   <div id="">
      <table class="table_info_exe">
         <tr style="background-color: #eee;">
            <th width="30">STT</th>
            <th width="500" algin="center">Khóa học</th>
            <th width="50">Xóa</th>
         </tr>
         <?
         $db_ques_select   = new db_query('SELECT cou_id,cou_name,padt_id
                                           FROM courses a, package_data b
                                           WHERE a.cou_id = b.padt_data_id
                                           AND padt_pack_id = '.$record_id.'
                                           ORDER BY padt_id ASC');
         $i = 0;
         while($row_ques = mysqli_fetch_assoc($db_ques_select->result)){
         $i++;
         ?>
         <tr style="">
            <td align="center"><?=$i?></td>
            <td align="center">
               <input type="text" value="<?=$row_ques['cou_name']?>" style="width: 400px;" />
            </td>
            <td align="center">
               <a href=""><img src="<?=$fs_imagepath?>delete.gif" onclick="delete_package(<?=$row_ques['padt_id']?>)"></img></a>
            </td>
         </tr>
         <?}unset($db_ques_select);?>
      </table>
   </div>
</body>
</html>
<style>
.a_detail{padding: 0px 13px;border: solid 1px;background: #EEE;text-decoration: none;margin: 6px 4px;color: #8C99A5;float: left;height: 18px;line-height: 18px;}
#wr_list_answer{float: left;margin:10px 0px 30px 30px;border-right: solid 1px #eee;border: solid 1px #eee;width: 940px;}
#list_title{width: 933px;float: left;padding: 4px 0px 4px 7px;color: #616D76;font-weight: bold;text-align: center;height: 15px;line-height: 15px;}
#wr_detail{width: 100%;height: 100%;}
#detail_title{width: 490px;float: left;background: #eee;color: #616D76;font-weight: bold;height: 23px;line-height: 23px;}
#wr_detail_info{float: left;width: 100%;border-bottom: solid 1px #eee;}
#wr_detail_answer{float: left;margin:10px 0px 0px 12px;border-right: solid 1px #eee;border: solid 1px #eee;width: 490px;}
#wr_detail_media{float: left;margin:10px 0px 0px 11px;border-right: solid 1px #eee;border: solid 1px #eee;width: 495px;}
#wr_detail_left{float: left;width: 420px;}
#detail_content{float: left;width: 406px;padding:5px 0px 5px 4px;border-bottom: dotted 1px #eee;}
#multi_choice{float: left;width: 485px;height:243px;padding:5px 0px 5px 4px;overflow: scroll;}
#drag{float: left;width: 485px;padding: 5px 0px 5px 4px;}
#fill_word{float: left;width: 485px;padding: 5px 0px 5px 4px;height:243px;overflow: scroll;}
#media{float: left;width: 490px;padding:5px 0px 5px 4px;}
#content_multi_choice{float: left;width: 406px;padding-left: 4px;}
#dv_add_action{float: left;width: 100%;}
#im_note{float: left;width: 406px;padding:5px 0px 5px 4px;}
#im_note p{float: left;width: 406px;padding: 5px 0px 0px 4px;color: red;margin: 0px;}
#para_detail{float: left;padding-left: 10px;width: 475px;height: 250px;overflow: scroll;}
.dv_add_action_invi{display: none;}
.p_info{padding:10px 12px;float: left;width: 100%;margin: 0px;}
.b_info{color: red;}
.a_submit{border: solid 1px #5E6C77;padding: 3px 15px;background: #EEE;color: #E27A13;font-weight: bold;margin: 0px 4px;float: left;cursor: pointer;}
.a_close{float:right;color: #64707B;padding-right: 5px;text-decoration: underline;cursor: pointer;}
.btn_add{background-color: #F2F2F2;border: 1px #CCC solid;font-size: 11px;margin-left: 23px;cursor: pointer;}
.btn_add_drag{background-color: #F2F2F2;border: 1px #CCC solid;font-size: 11px;margin-left: 5px;cursor: pointer;}
.table_info_exe{color: #616D76;font-size: 11px;margin-top: 0px;}
.table_info_exe th{border: 1px solid #DDD;line-height: 10px;padding: 7px;vertical-align: top;}
.table_info_exe td{border: 1px solid #DDD;padding: 0px;}
.ans_content{width: 310px;padding: 4px 4px;border: solid #616D76 1px;border-radius: 1px;color: #616D76;margin:2px 0px;}
.ans_edit{padding: 4px 10px;background: #EEE;border: solid 1px;border-radius: 1px;cursor: pointer;}
.ans_del{padding: 4px 6px;background: #EEE;border: solid 1px;border-radius: 1px;cursor: pointer;}
.ans_add{padding: 4px 12px;background: #EEE;border: solid 1px;border-radius: 1px;cursor: pointer;margin-left:0;}
.med_deny{padding: 2px 5px;background: #EEE;border: solid 1px;border-radius: 5px;cursor: pointer;}
.ans_close{padding: 4px 10px;background: #EEE;border: solid 1px;border-radius: 1px;cursor: pointer;}
.media_deny{padding: 4px 9px;background: #EEE;border: solid 1px;border-radius: 5px;cursor: pointer;}
.add_action{background: none repeat scroll 0 0 #EEEEEE;border: 1px solid;border-radius: 1px;cursor: pointer;float: left;height: 18px;line-height: 17px;margin-bottom: 3px;margin-left: 20px;margin-top: 5px;padding: 0 18px;}
.p_dt_title{float: left;padding-left: 10px;margin: 0px;}
.sl_list_media{border: solid 1px #616D76;padding: 2px 2px;border-radius: 4px;margin: 5px 0px;}
.a_score{margin: 7px 0px 5px 0px;text-decoration: no;background: green;height: 18px;color: white;line-height: 18px;padding: 0px 5px;}
</style>
<script>
function check_rdo_true(numtrue){
for(var i=0;i < 5;i++){
   $('#rdo_'+i).attr("value","0");
}
$('#rdo_'+numtrue).attr("value","1");
}
</script>
<?include("ajax.php");?>