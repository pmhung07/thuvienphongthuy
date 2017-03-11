<?
include("inc_security.php");

//===== variable json=====//
$msg   = "";
$err 	 = "";
$json  = array();

//====== get variable =====//
$exe_id	   = getValue("exe_id","int","POST",0);
$ans_1	   = getValue("ans_1","str","POST","");
$ans_2	   = getValue("ans_2","str","POST","");
$ans_3	   = getValue("ans_3","str","POST","");
$ans_4	   = getValue("ans_4","str","POST","");
$true_ans_1 = getValue("true_ans_1","str","POST","");
$true_ans_2 = getValue("true_ans_2","str","POST","");
$true_ans_3 = getValue("true_ans_3","str","POST","");
$true_ans_4 = getValue("true_ans_4","str","POST","");
$ans_true   = getValue("ans_true","int","POST",0);
$question   = getValue("question","str","POST","");
$type_ques  = getValue("type_ques","int","POST",0);
$que_active = 1;
$arr_ans    = array($ans_1,$ans_2,$ans_3,$ans_4);
$arr_true   = array($true_ans_1,$true_ans_2,$true_ans_3,$true_ans_4);
//=========================//
$fs_errorMsg = "";
$myform = new generate_form();
$myform->add("que_exe_id" , "exe_id" , 1 , 1 , 0 , 1,"" , 0 , "");
$myform->add("que_content" , "question" , 0 , 1 , "" , 1,"Bạn chưa nhập câu hỏi" , 0 , "");
$myform->add("que_type" , "type_ques" , 1 , 1 , "" , 1,"" , 0 , "");
$myform->add("que_active" , "que_active" , 1 , 1 , 1 , 1,"" , 0 , "");
if($fs_errorMsg == ""){
	$myform->addTable("questions");
	//$myform->removeHTML(0);
	$db_insert 	= new db_execute_return();
	$last_exe_id		= $db_insert->db_execute($myform->generate_insert_SQL());
   if($last_exe_id>0){
      $exe_id = $last_exe_id;
      for($i=0;$i<4;$i++){
         $ans_form = new generate_form();
         $ans_form->add("ans_ques_id" , "exe_id" , 1 , 1 , 0 , 1,"" , 0 , "");
         $ans = $arr_ans[$i];
         $true = $arr_true[$i]; 
         $ans_form->add("ans_content" , "ans" , 0 , 1 , "" , 1,"Bạn chưa nhập đủ câu trả lời" , 0 , "");
         $ans_form->add("ans_true" , "true" , 1 , 1 , 0 , 1,"Bạn chưa nhập câu trả lời đúng" , 0 , "");
         $ans_form->addTable("answers");
   		$ans_form->removeHTML(0);
   		$db_insert_ans 	= new db_execute_return();
   		$last_exe_id = $db_insert_ans->db_execute($ans_form->generate_insert_SQL());
         $msg = "Thêm câu hỏi thành công";
         unset($db_insert_ans);
      }
   }
}else{
   $err = "Xảy ra lỗi trong quá trình thêm dữ liệu";
}
//==================
$json['msg'] = $msg;
$json['err'] = $err;
echo json_encode($json);

?>