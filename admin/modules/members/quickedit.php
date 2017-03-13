<?
require_once("inc_security.php");
//check quyền them sua xoa
checkAddEdit("edit");
$returnurl = base64_decode(getValue("returnurl","str","GET",base64_encode("listing.php")));

function add_package_num_day($user_id,$day){
   $db_select = new db_query("SELECT ucp_id,ucp_end_time FROM user_courses_pack WHERE ucp_cou_id = 0 AND ucp_use_id=".$user_id);
   $row = mysqli_fetch_assoc($db_select->result);
   if(!$row) {
      $cur_time = time();
      $ucp_end_time = $cur_time + (60 * 60 * 24 * $day);
      $sql_money = "INSERT INTO user_courses_pack(ucp_use_id,ucp_cou_id,ucp_end_time,ucp_status) VALUES(".$user_id.",0,".$ucp_end_time.",1)";
      $db_money = new db_execute($sql_money);
      unset($db_money);
   } else {
      $end_time = $row["ucp_end_time"];
      $ucp_end_time = $end_time + (60 * 60 * 24 * $day);
      //Set money
      $sql_money = "UPDATE user_courses_pack SET ucp_end_time = ".$ucp_end_time.",ucp_status = 1 WHERE ucp_id=".$row["ucp_id"];
      $db_money = new db_execute($sql_money);
      unset($db_money);
   }
   unset($db_select);
}
// --
function sub_package_num_day($user_id,$day){
   $db_select = new db_query("SELECT ucp_id,ucp_end_time FROM user_courses_pack WHERE ucp_cou_id = 0 AND ucp_use_id=".$user_id);
   $row = mysqli_fetch_assoc($db_select->result);
   if(!$row) {
      $cur_time = time();
      $ucp_end_time = $cur_time - (60 * 60 * 24 * $day);
      $sql_money = "INSERT INTO user_courses_pack(ucp_use_id,ucp_cou_id,ucp_end_time,ucp_status) VALUES(".$user_id.",0,".$ucp_end_time.",1)";
      $db_money = new db_execute($sql_money);
      unset($db_money);
   } else {
      $end_time = $row["ucp_end_time"];
      $ucp_end_time = $end_time - (60 * 60 * 24 * $day);
      //Set money
      $sql_money = "UPDATE user_courses_pack SET ucp_end_time = ".$ucp_end_time.",ucp_status = 1 WHERE ucp_id=".$row["ucp_id"];
      $db_money = new db_execute($sql_money);
      unset($db_money);
   }
   unset($db_select);
}

//======== Hàm Update số tiền vào tài khoản chính
function add_user_money($user_id,$money_type,$money_add){
    //money_type = 1 : Nạp tiền vào tk chính , money_type = 2 : Nạp tiền tk khuyến mãi
    if($money_type == 1){
        // Get money
        $db_select = new db_query("SELECT umoney_money FROM user_money WHERE umoney_user_id=".$user_id);
        $row = mysqli_fetch_assoc($db_select->result);
        if(!$row) {
            $sql_money = "INSERT INTO user_money(umoney_user_id,umoney_money,umoney_promotion) VALUES(".$user_id.",".$money_add.",0)";
            $db_money = new db_execute($sql_money);
            unset($db_money);
        } else {
            $cur_money = $row["umoney_money"];
            // Add money
            $user_money = $cur_money + $money_add;
            //Set money
            $sql_money = "UPDATE user_money SET umoney_money = ".$user_money." WHERE umoney_user_id=".$user_id;
            $db_money = new db_execute($sql_money);
            unset($db_money);
        }
        unset($db_select);
      }
}

function sub_user_money($user_id,$money_type,$money_add){
    //money_type = 1 : Nạp tiền vào tk chính , money_type = 2 : Nạp tiền tk khuyến mãi
    if($money_type == 1){
        // Get money
        $db_select = new db_query("SELECT umoney_money FROM user_money WHERE umoney_user_id=".$user_id);
        $row = mysqli_fetch_assoc($db_select->result);
        if(!$row) {
            $sql_money = "INSERT INTO user_money(umoney_user_id,umoney_money,umoney_promotion) VALUES(".$user_id.",".$money_add.",0)";
            $db_money = new db_execute($sql_money);
            unset($db_money);
        } else {
            $cur_money = $row["umoney_money"];
            // Add money
            $user_money = $cur_money - $money_add;
            //Set money
            $sql_money = "UPDATE user_money SET umoney_money = ".$user_money." WHERE umoney_user_id=".$user_id;
            $db_money = new db_execute($sql_money);
            unset($db_money);
        }
        unset($db_select);
      }
}
//Khai bao Bien
$errorMsg = "";
$iQuick = getValue("iQuick","str","POST","");
if ($iQuick == 'update'){
	$record_id = getValue("record_id", "arr", "POST", "");
	if($record_id != ""){
      $add_date = getValue('add_date','arr','POST',0);
      $val_date = getValue('val_date','arr','POST',0);
      //=============//
      $add_money = getValue('add_money','arr','POST',0);
      $val_money = getValue('val_money','arr','POST',0);
      //=============//
      $sub_date = getValue('sub_date','arr','POST',0);
      $sub_val_date = getValue('sub_val_date','arr','POST',0);
      //=============//
      $sub_money = getValue('sub_money','arr','POST',0);
      $sub_val_money = getValue('sub_val_money','arr','POST',0);
      // Lấy ra khóa trọn gói của user
      //-----------------------------------

      for($i=0; $i<count($record_id); $i++){
         if(@$add_date[$i] != 0) {
          $add_date_val = $add_date[$i];
          add_package_num_day($record_id[$i],$add_date_val);
         }
         if(@$sub_date[$i] != 0) {
          $sub_val_date = $sub_date[$i];
          sub_package_num_day($record_id[$i],$sub_val_date);
         }
         //Cong tien tai khoan chinh
         if(@$add_money[$i] != 0){
            add_user_money($record_id[$i],1,$add_money[$i]);
            redirect($returnurl);
         }
         //Tru tien tai khoan chinh
         if(@$sub_money[$i] != 0){
            sub_user_money($record_id[$i],1,$sub_money[$i]);
            redirect($returnurl);
         }
      }
	}else {
	   var_dump($record_id);
	}
}
?>