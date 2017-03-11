<?
include("../home/config.php");

//========== variable json=========//
$msg   = "";
$err 	 = "";
$json  = array();
$fs_errorMsg = "";
//====== get variable answers=====//
$str_ans = getValue("rmv_str_ans","str","POST","");
$part_write = getValue("part_write","int","POST",0);
$rmv_str_ans = removeHTML($str_ans);
/*$myform = new generate_form();  
if($part_write == 1){
   $tesr_part_success = 3;
   $myform->add("ielt_user_writing_first", "rmv_str_ans", 0, 1, "", 1, "", 0, "");
   $myform->add("ielr_part_success", "tesr_part_success", 1, 1, 3, 1, "", 0, "");
}else{
   $tesr_part_success = 4;
   $myform->add("ielt_user_writing_second", "rmv_str_ans", 0, 1, "", 1, "", 0, "");
   $myform->add("ielr_part_success", "tesr_part_success", 1, 1, 4, 1, "", 0, "");
}
//Add table insert data
$myform->addTable("ielts_result");
$db_ex = new db_execute($myform->generate_update_SQL("ielr_id",$_SESSION['ielr_id']));*/
$msg .= "Bạn đã hoàn thành section Writing";
//==================
$json['msg'] = $msg;
$json['err'] = $err;
echo json_encode($json);
?>