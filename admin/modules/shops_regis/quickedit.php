<?
require_once("inc_security.php");
//check quyền them sua xoa
checkAddEdit("edit");
$returnurl = base64_decode(getValue("returnurl","str","GET",base64_encode("listing.php")));

//Khai bao Bien
$errorMsg = "";
$iQuick = getValue("iQuick","str","POST","");
if ($iQuick == 'update'){
	$record_id = getValue("record_id", "arr", "POST", "");
	if($record_id != ""){
       $add_date = getValue('add_date','arr','POST',0);	
       $val_date = getValue('val_date','arr','POST',0);
		for($i=0; $i<count($record_id); $i++){
           if($add_date[$i] != 0) {
                $add_date_val = $add_date[$i]*24*3600;
                $cur_time = time();
                if($val_date[$i] > $cur_time) {
                    $set_end = $val_date[$i] + $add_date_val;
                    $db_update = new db_execute('UPDATE users SET use_date_act_end = '.$set_end.',use_date_act_start = '.$cur_time.',use_status_act = 1 WHERE use_id = '.$record_id[$i]);
                }else {
                    $set_end = $cur_time + $add_date_val;
                    $db_update = new db_execute('UPDATE users SET use_date_act_end = '.$set_end.',use_date_act_start = '.$cur_time.',use_status_act = 1 WHERE use_id = '.$record_id[$i]);
                }
                if($db_update->total >0) {
                    echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">';
                	echo "Đang cập nhật dữ liệu !";
                	redirect($returnurl);
                }
                else {
                    echo "Lỗi cập nhật !";
                }
           }  
		}
       echo "Ngày nhập vào không hợp lệ !";
	   
	}else {
	   var_dump($record_id);
	}
	

}
?>