<?
include("inc_security.php");

//========== variable json=========//
$msg   = "";
$err 	 = "";
$json  = array();
$fs_errorMsg = "";

//====== get variable answers=====//
$ans_check_id	 = getValue("ans_id","int","POST",0);
$ans_ques_id	 = getValue("ans_ques_id","int","POST",0);

//=================================//
$ans_first_true = 0;
$ans_last_true = 1;

$db_select_ans  = new db_query("SELECT tan_id FROM test_answers WHERE tan_teques_id = ". $ans_ques_id);
while($row_ans = mysqli_fetch_assoc($db_select_ans->result)){
   $ans_id = $row_ans["tan_id"];
   $myform = new generate_form();
   $myform->add("tan_true","ans_first_true",1,1,0,0,"",0,"");
   $myform->addTable("test_answers");
  	$db_update = new db_execute($myform->generate_update_SQL("tan_id", $ans_id));
  	unset($db_update);
}unset($db_select_ans);

$myform_udp = new generate_form();
$myform_udp ->add("tan_true","ans_last_true",1,1,1,0,"",0,"");
$myform_udp ->addTable("test_answers");
if($fs_errorMsg == ""){
      $myform_udp->removeHTML(0);
   	$db_update = new db_execute($myform_udp->generate_update_SQL("tan_id", $ans_check_id));
   	unset($db_update);
      $msg = "Đã chọn câu trả lời đúng";
   }else{
      $err = "Có lỗi trong quá trình sửa đổi";
   }
//==================
$json['msg'] = $msg;
$json['err'] = $err;
echo json_encode($json);
?>