<?php
//======== Hàm tạo tài khoản 
function creat_money_user($user_id){
   //select từ bảng lưu tiền ra xem đã tồn tại record id chưa
	$db_select	=	new db_query("SELECT *
										  FROM user_money
										  WHERE umoney_user_id = " . $user_id
	 									 , __FILE__ . " Line: " . __LINE__);
   //nếu chưa tồn tại tài khoản thì không update
   if(!$row = mysql_fetch_assoc($db_select->result)){
      //bắt đầu insert vào db
      $db_execute	= new db_execute_return();
    	$umoney_return  = $db_execute->db_execute("INSERT IGNORE INTO user_money(umoney_user_id)
   	 									                VALUES(" . $user_id . ")"
                                                 , __FILE__ . " Line: " . __LINE__);   
      unset($db_execute);	
   }unset($db_select);   
}

//======== Hàm lấy ta số tiền trong tk chính
function get_money($user_id){
   //select từ bảng lưu tiền ra xem đã tồn tại record id chưa
   $money = 0;
	$db_select	=	new db_query("SELECT umoney_money
										  FROM user_money
										  WHERE umoney_user_id = " . $user_id);
   //nếu chưa tồn tại tài khoản thì không update
   if($row = mysql_fetch_assoc($db_select->result)){
      $money = $row["umoney_money"];
   } else {
   	creat_money_user($user_id);
		$money = get_money($user_id);
   }
   unset($db_select);   
   return $money;
}

function set_money($user_id,$amount){
	$db_execute = new db_execute(	"UPDATE user_money
											 SET umoney_money = ".$amount."
											 WHERE (umoney_user_id=".$user_id.")");
	unset($db_execute);
}

function substract_money($user_id,$amount){
	$money = get_money($user_id);
	$money = $money - $amount;
	set_money($user_id,$money);
	unset($money);
}

//======== Hàm lấy ta số tiền trong tk chính
function get_money_promotion($user_id){
   //select từ bảng lưu tiền ra xem đã tồn tại record id chưa
   $money = 0;
	$db_select	=	new db_query("SELECT umoney_promotion
										  FROM user_money
										  WHERE umoney_user_id = " . $user_id);
   //nếu chưa tồn tại tài khoản thì không update
   if($row = mysql_fetch_assoc($db_select->result)){
      $money = $row["umoney_promotion"];
   }unset($db_select);   
   return $money;
}
//======== Hàm Update số tiền vào tài khoản chính
function add_user_money($user_id,$money_type,$money_add){
    //money_type = 1 : Nạp tiền vào tk chính , money_type = 2 : Nạp tiền tk khuyến mãi
    if($money_type == 1){
        // Get money
        $db_select = new db_query("SELECT umoney_money FROM user_money WHERE umoney_user_id=".$user_id);
        $row = mysql_fetch_assoc($db_select->result); 
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

//======== Hàm Update Thông Tin Bank
function add_bank_success($order_id,$transaction_id,$total_amount,$comment,$maa_status,$bank_type){
   //bank_type = 1 : ATM - bank_type = 2 : VISA
   if($bank_type == 1){
      $maa_type = 1;
   }else{
      $maa_type = 2;
   }
   // Kiem tra xem co ton tai order trong CSDL khong
   $db_transaction	= new db_query("SELECT maa_id
   								          FROM money_atm_add
   								          WHERE maa_id = " . replaceMQ(str_replace('_kkhh_', '', $order_id)));
   
   // Neu ton tai thi update thong tin thanh toan
   if(mysql_num_rows($db_transaction->result) > 0){					
   	$db_update	= new db_execute("UPDATE money_atm_add
   											SET maa_bk_transaction_id = '" . replaceMQ($transaction_id) . "',
   										       maa_money = " . $total_amount . ",
   										       maa_comment = '" . replaceMQ($comment) . "',
   									          maa_last_update = " . time() . "
   											WHERE maa_id = " . $order_id);
   
   	 
      unset($db_update);
   		
   }// End if(mysql_num_rows($db_transaction->result) == 0)
   unset($db_transaction);
   //xac nhan la da thanh toan thanh cong don hang
   $db_ex	=	new db_execute("UPDATE money_atm_add SET maa_status='". $maa_status . "', maa_type='".$maa_type."' WHERE maa_id=". $order_id);
   unset($db_ex);
}

//======== Hàm Update Thông Tin Bảo Kim
function add_baokim_success($order_id,$transaction_id){
   // Kiem tra xem co ton tai order trong CSDL khong
   $db_transaction	= new db_query("SELECT mbk_id
   								          FROM money_baokim
   								          WHERE mbk_id = ".$order_id);
   
   // Neu ton tai thi update thong tin thanh toan
   if(mysql_num_rows($db_transaction->result) > 0){					
   	$db_update	= new db_execute("UPDATE money_baokim
												SET mbk_transaction_id = '" . replaceMQ($transaction_id) . "'
												WHERE mbk_id = ".$order_id);

		 
      unset($db_update);
			
	}// End if(mysql_num_rows($db_transaction->result) == 0)
	unset($db_transaction);
	//xac nhan la da thanh toan thanh cong don hang
	$db_ex	=	new db_execute("UPDATE money_baokim SET mbk_status = 1 WHERE mbk_id=".$order_id);
	unset($db_ex);
}
//======== Hàm Add gói trọn gói cho học viên
function add_package_full($user_id){
   $db_select = new db_query("SELECT ucp_id,ucp_end_time FROM user_courses_pack WHERE ucp_cou_id = 0 AND ucp_use_id=".$user_id);
   $row = mysql_fetch_assoc($db_select->result); 
   if(!$row) {
      $cur_time = time();
      $ucp_end_time = $cur_time + (60 * 60 * 24 * 365);
      $sql_money = "INSERT INTO user_courses_pack(ucp_use_id,ucp_cou_id,ucp_end_time,ucp_status) VALUES(".$user_id.",0,".$ucp_end_time.",1)";
      $db_money = new db_execute($sql_money);
      unset($db_money); 
   } else {
      $cur_time = time();
      $end_time = $row["ucp_end_time"];
      if($end_time > $cur_time){
         $ucp_end_time = $end_time + (60 * 60 * 24 * 365);
      }else{
         $ucp_end_time = $cur_time + (60 * 60 * 24 * 365);
      }
      //Set money
      $sql_money = "UPDATE user_courses_pack SET ucp_end_time = ".$ucp_end_time.",ucp_status = 1 WHERE ucp_id=".$row["ucp_id"];
      $db_money = new db_execute($sql_money);
      unset($db_money); 
   }
   unset($db_select);
}
//======== Hàm Add gói trọn gói cho học viên tùy biến số ngày
function add_package_num_day($user_id,$day){
   $db_select = new db_query("SELECT ucp_id,ucp_end_time FROM user_courses_pack WHERE ucp_cou_id = 0 AND ucp_use_id=".$user_id);
   $row = mysql_fetch_assoc($db_select->result); 
   if(!$row) {
      $cur_time = time();
      $ucp_end_time = $cur_time + (60 * 60 * 24 * $day);
      $sql_money = "INSERT INTO user_courses_pack(ucp_use_id,ucp_cou_id,ucp_end_time,ucp_status) VALUES(".$user_id.",0,".$ucp_end_time.",1)";
      $db_money = new db_execute($sql_money);
      unset($db_money); 
   } else {
      $cur_time = time();
      $end_time = $row["ucp_end_time"];
      if($end_time > $cur_time){
         $ucp_end_time = $end_time + (60 * 60 * 24 * $day);
      }else{
         $ucp_end_time = $cur_time + (60 * 60 * 24 * $day);
      }
      $sql_money = "UPDATE user_courses_pack SET ucp_end_time = ".$ucp_end_time.",ucp_status = 1 WHERE ucp_id=".$row["ucp_id"];
      $db_money = new db_execute($sql_money);
      unset($db_money); 
   }
   unset($db_select);
}
?>