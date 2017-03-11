<?
include("../home/config.php");

//========== variable json=========//
$msg   = "";
$err 	 = "";
$json  = array();
$fs_errorMsg = "";
//====== get variable answers=====//
$str_ans = getValue("str_ans","str","POST","");
$rmv_str_ans = removeHTML($str_ans);
$tesr_part_success = 2;
//$myform = new generate_form();  
//$myform->add("ielt_user_listening", "rmv_str_ans", 0, 1, "", 1, "", 0, "");
//$myform->add("ielr_part_success", "tesr_part_success", 1, 1, 2, 1, "", 0, "");
//Add table insert data
//$myform->addTable("ielts_result");
//$db_ex = new db_execute($myform->generate_update_SQL("ielr_id",$_SESSION['ielr_id']));
$msg .= "Chúc mừng bạn đã hoàn thành phần thi Listening !";
//==================
$json['msg'] = $msg;
$json['err'] = $err;
echo json_encode($json);
?>