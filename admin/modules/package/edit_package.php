<?
include("inc_security.php");
checkAddEdit("add");
//khai báo biến
$fs_redirect 	= base64_decode(getValue("url","str","GET",base64_encode("listing.php")));
$record_id 		= getValue("record_id");
$pack_cat_id   = getValue("pack_cat_id");
$padt_data_id  = getValue("padt_data_id");
$fs_errorMsg	= '';
$fs_action			= getURL();
$add					= "add.php";
$listing				= "listing.php";
$db_listAll = new db_query('SELECT cou_id,cou_name
                           FROM courses
                           WHERE cou_cat_id = '.$pack_cat_id.'
                           ORDER BY cou_time ASC');

$listAll    = $db_listAll->resultArray();
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
         //echo $myform->generate_update_SQL('padt_id',$record_id);
   		$db_insert   =  new db_execute($myform->generate_update_SQL('padt_id',$record_id));
         unset($db_insert);
         redirect($fs_redirect);
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
   $form->create_form("add", $fs_action, "post", "multipart/form-data",'onsubmit="validateForm(); return false;"');
   $form->create_table();
   ?>
   <tr>
      <td width="120px" class="form_name" colspan="2" style="text-align: center;"><b>Sửa gói học</b></td>
   </tr>
   <tr>
      <td colspan="2" style="color: red; text-align: center;"><?=$fs_errorMsg?></td>
   </tr>
   <tr>

      <td width="120px" class="form_name">Chọn khóa học :</td>
      <td>
         <select name="add_couid" id="add_couid">
            <?foreach ($listAll as $key=>$value) {?>
               <option value="<?=$value['cou_id']?>" <?=($value['cou_id'] == $padt_data_id)?'selected = "selected"':''?>><?=$value['cou_name']?></option>
            <?}?>
         </select>
      </td>
   </tr>
	<?=$form->button("submit" . $form->ec . "reset", "submit" . $form->ec . "reset", "submit" . $form->ec . "reset", "Sửa khóa" . $form->ec . "Đóng cửa sổ", "Thêm khóa" . $form->ec . "Đóng cửa sổ", 'style="background:url(' . $fs_imagepath . 'button_1.gif) no-repeat"' . $form->ec . 'style="background:url(' . $fs_imagepath . 'button_2.gif)" onclick="window.parent.tb_remove()"', "");?>
	<?=$form->hidden("action", "action", "execute", "");?>
   <?
   $form->close_table();
   $form->close_form();
   unset($form);
   ?>