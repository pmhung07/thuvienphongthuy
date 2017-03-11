<?
include("inc_security.php");

//===== variable json=====//
$msg   = "";
$err 	 = "";
$json  = array();

//====== get variable =====//
$iPara	   = getValue("iPara","int","POST",0);
$ans_1	   = getValue("ans_1","str","POST","");
$ans_2	   = getValue("ans_2","str","POST","");
$ans_3	   = getValue("ans_3","str","POST","");
$ans_4	   = getValue("ans_4","str","POST","");
$true_drag_1 = getValue("true_drag_1","str","POST","");
$true_drag_2 = getValue("true_drag_2","str","POST","");
$true_drag_3 = getValue("true_drag_3","str","POST","");
$true_drag_4 = getValue("true_drag_4","str","POST","");
$question   = getValue("question","str","POST","");
$arr_ans    = array($ans_1,$ans_2,$ans_3,$ans_4);
$arr_true   = array($true_drag_1,$true_drag_2,$true_drag_3,$true_drag_4);
$teque_type = 1;
$teque_type_sub = 2;
//=========================//
$fs_errorMsg = "";
$myform = new generate_form();
$myform->add("teque_tec_id	" , "iPara" , 1 , 1 , 0 , 1,"" , 0 , "");
$myform->add("teque_content" , "question" , 0 , 1 , "" , 1,"Bạn chưa nhập câu hỏi" , 0 , "");
$myform->add("teque_type" , "teque_type" , 1 , 1 , 1 , 1,"Bạn chưa nhập câu trả lời" , 0 , "");
$myform->add("teque_type_sub" , "teque_type_sub" , 1 , 1 , 2 , 1,"" , 0 , "");
if($fs_errorMsg == ""){
	if($fs_errorMsg == ""){
		$myform->addTable("test_questions");
		$myform->removeHTML(0);
		$db_insert 	= new db_execute_return();
		$last_exe_id		= $db_insert->db_execute($myform->generate_insert_SQL());
      if($last_exe_id>0){
         $exe_id = $last_exe_id;
         for($i=0;$i<4;$i++){
            $ans_form = new generate_form();
            $ans_form->add("tan_teques_id" , "exe_id" , 1 , 1 , 0 , 1,"" , 0 , "");
            $ans = $arr_ans[$i]; 
            $true = $arr_true[$i];
            $ans_form->add("tan_content" , "ans" , 0 , 1 , "" , 1,"Bạn chưa nhập câu trả lời" , 0 , "");
            $ans_form->add("tan_true" , "true" , 1 , 1 , 0 , 1,"Bạn chưa nhập câu trả lời đúng" , 0 , "");
            $ans_form->addTable("test_answers");
      		$ans_form->removeHTML(0);
      		$db_insert_ans 	= new db_execute_return();
      		$last_exe_id = $db_insert_ans->db_execute($ans_form->generate_insert_SQL());
            $msg = "Thêm câu hỏi thành công";
            unset($db_insert_ans);
         }
      }
	}
}else{
   $err = "Xảy ra lỗi trong quá trính nhập dữ liệu";
}
//==================
$json['msg'] = $msg;
$json['err'] = $err;
echo json_encode($json);

?>