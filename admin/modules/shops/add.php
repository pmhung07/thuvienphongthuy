<?
   include("inc_security.php");
   checkAddEdit("add");
   
	$province								= getValue("province","int","GET",0);
   
    $db_provinces = new db_query('SELECT * FROM provinces WHERE 1');
    $listProv = array();
    $listProv[0] = '-- Chọn tỉnh thành --';
    while($prov = mysql_fetch_assoc($db_provinces->result)) {
        $listProv[$prov['id']] = $prov['name'];
    }
    unset($db_provinces);
    
    
    if($province != 0) {
        $db_districts = new db_query('SELECT * FROM districts WHERE province_id = '.$province);
        $listDis = array();
        $listDis[0] = '-- Chọn Quận huyện --';
        while($dis = mysql_fetch_assoc($db_districts->result)) {
            $listDis[$dis['id']] = $dis['name'];
        }
        unset($db_districts);
    }else {
        $listDis = array();
        $listDis[0] = '-- Chọn Quận huyện --';
    }

   $fs_title = $module_name . " | Thêm mới";
   $fs_action = getURL();
   $fs_errorMsg = "";
   $add = "add.php";
   $listing = "listing.php";
     
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
   $sho_date = time();  
   //tạo mới class generate_form 
   $myform = new generate_form();
   
   $myform->add("sho_name","sho_name",0,0,'',1,"Bạn chưa nhập tên cửa hàng",1,""); 
   $myform->add("sho_province","sho_province",1,0,0,1,"Bạn chưa chọn tỉnh thành",0,""); 
   $myform->add("sho_district","sho_district",1,0,0,1,"Bạn chưa chọn quận huyện",0,""); 
   $myform->add("sho_address","sho_address",0,0,'',1,"Bạn chưa nhập địa chỉ",0,"");
   $myform->add("sho_phone","sho_phone",1,0,'',1,"Bạn chưa nhập số điện thoại",0,"");
   $myform->add("sho_date","sho_date",1,1,'',1);
   $myform->add("sho_negative","sho_negative",1,0,0,0,"",0,"");
   $myform->add("sho_active","sho_active",1,0,0,0,"",0,"");
   
   $myform->addTable($fs_table);

   $action			= getValue("action", "str", "POST", ""); 
   if($action == "execute"){
   	 $fs_errorMsg .= $myform->checkdata(); 
         	     
     if($fs_errorMsg == ""){
     	$myform->removeHTML(0);
		$db_insert = new db_execute_return();
		$last_id = $db_insert->db_execute($myform->generate_insert_SQL());
        unset($db_insert);
        //thêm tiền = 0 trong bảng coins cho cửa hàng
        $db_insert = new db_execute('INSERT INTO shop_coins(coi_shop_id,coi_value,coi_promotion) VALUES('.$last_id.',0,0)');
        if($db_insert->total == 1) {
            redirect("listing.php");
        }
     }
   }
   $myform->addFormname("add_new");
   $myform->evaluate();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<?=$load_header?>
<?
$myform->checkjavascript();
$fs_errorMsg .= $myform->strErrorField;
?>
</head>
<body>
<? /*------------------------------------------------------------------------------------------------*/ ?>
<?=template_top($fs_title)?>
<? /*------------------------------------------------------------------------------------------------*/ ?>
	<p align="center" style="padding-left:10px;">
	<?
	$form = new form();
  
	$form->create_form("add", $fs_action, "post", "multipart/form-data",'onsubmit="validateForm(); return false;"');
   $form->create_table();
	?>
   <?=$form->text_note('<strong style="text-align:center;">----------Thêm mới bài viết-----------</strong>')?>
   <?=$form->text_note('Những ô có dấu sao (<font class="form_asterisk">*</font>) là bắt buộc phải nhập.')?>
   <?=$form->errorMsg($fs_errorMsg)?>
   <?=$form->text("Tên cửa hàng", "sho_name", "sho_name", $sho_name, "Tên cửa hàng", 1, 250, "", 255, "", "", "")?>
   <tr> 
		<td align="right" nowrap class="form_name"><font class="form_asterisk">* </font> <?=translate_text("Chọn tỉnh thành")?> :</td>
		<td>
			<select name="sho_province" id="province"  class="form_control" onChange="window.location.href='add.php?province='+this.value">
				<?
				foreach($listProv as $key => $value){
				?>
				<option value="<?=$key?>" <? if($key == $province) echo "selected='selected'";?>><?=$value?></option>
				<? } ?>
			</select>
		</td>
	</tr>	
   <?=$form->select("Quận/Huyện", "sho_district", "sho_district", $listDis, $sho_district, "Chọn quận huyện ", 1, "", "", 0, "", "")?>
   <?=$form->text("Địa chỉ","sho_address","sho_address",$sho_address,"Địa chỉ",1,255,"",255,"","")?>
   <?=$form->text("Điện thoại","sho_phone","sho_phone",$sho_phone,"Điện thoại",1,255,"",255,"","")?>
   <?=$form->checkbox("Cho phép âm tiền", "sho_negative", "sho_negative", 1 ,"sho_negative", "",0, "", "")?>
   <?=$form->checkbox("Kích hoạt", "sho_active", "sho_active", 1 ,"sho_active", "",0, "", "")?>
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