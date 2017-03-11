<?
require_once("inc_security.php");
//check quyền them sua xoa
checkAddEdit("edit");

//Khai bao Bien
$errorMsg		=	"";
$errorMsgAll	=	"";
$iQuick = getValue("iQuick","str","POST","");
$record_id = getValue("record_id", "arr", "POST", "");

//Bien quick edit tu danh sach cac tin ko lay duoc anh
$updateimage	=	getValue("updateimage", "str", "POST", "");

if($iQuick == 'update'){
	$total_record	=	count($record_id);
	if($total_record > 0){
		for($i = 0; $i < $total_record; $i++){
			//Call Class generate_form();
			$myform = new generate_form();
			//Loại bỏ chuc nang thay the Tag Html
			$myform->removeHTML(0);
			$myform->add('use_name', "use_name" . $record_id[$i], 0, 0, '', 0, '.', 0, '');	
			$myform->add('use_email', "use_email" . $record_id[$i], 0, 0, '', 0, '.', 0, '');	
			$myform->add('use_fullname', "use_fullname" . $record_id[$i], 0, 0, '', 0, '.', 0, '');	
			$myform->add('use_phone', "use_phone" . $record_id[$i], 0, 0, '', 0, '.', 0, '');
            $myform->add('use_shop_id', "use_shop_id" . $record_id[$i], 1, 0, 0, 0, '.', 0, '');
            $myform->add('use_role', "use_role" . $record_id[$i], 1, 0, 0, 0, '.', 0, '');
			//Add table
			$myform->addTable($fs_table);
            		
			$errorMsg .= $myform->checkdata($id_field, $record_id[$i]);
			
			if($errorMsg == ""){
				$db_ex = new db_execute($myform->generate_update_SQL($id_field, $record_id[$i]));
				//echo $myform->generate_update_SQL($id_field, $record_id[$i]) . "<br>";die();
                //var_dump($_POST);die();
				unset($db_ex);
				//echo $errorMsg;
			}else{
				echo $record_id[$i] . " : " . $errorMsg . "</br>";
			}
			unset($myform);
		}
	}
	echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">';
	echo "Đang cập nhật dữ liệu !";
	if($errorMsgAll == ""){
		redirect('listing.php');
	}
}
?>