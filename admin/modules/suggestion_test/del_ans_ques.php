<?
include("inc_security.php");

//========== variable json=========//
$msg   = "";
$err 	 = "";
$json  = array();

//====== get variable question=====//
$que_id	       = getValue("que_id","int","POST",0);

//====== get variable answers=====//
$ans_id	       = getValue("ans_id","int","POST",0);

//=================================//
if($que_id > 0){
   $db_del = new db_execute("DELETE FROM sg_test_questions WHERE sg_ques_id = " .$que_id);
   unset($db_del);
   $db_del_ans = new db_execute("DELETE FROM sg_test_answers WHERE sg_ans_id = " .$que_id);
   unset($db_del_ans);
   $msg = "Câu hỏi và câu trả lời tương ứng đã được xóa";
   //==================
   $json['msg'] = $msg;
   $json['err'] = $err;
   echo json_encode($json);
}

//=================================//
if($ans_id > 0){
   $db_del = new db_execute("DELETE FROM sg_test_answers WHERE sg_ans_id = " . $ans_id);
   unset($db_del);
   $msg = "Câu trả lời đã được xóa";
   //==================
   $json['msg'] = $msg;
   $json['err'] = $err;
   echo json_encode($json);
}

?>