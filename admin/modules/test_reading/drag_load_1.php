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
$ans_5	   = getValue("ans_5","str","POST","");
$ans_6	   = getValue("ans_6","str","POST","");
$ans_7	   = getValue("ans_7","str","POST","");
$ans_8	   = getValue("ans_8","str","POST","");

$ques_sub_1 = getValue("ques_sub_1","str","POST","");
$ques_sub_2 = getValue("ques_sub_2","str","POST","");

$question     = getValue("question","str","POST","");
$arr_ans_1    = array($ans_1,$ans_2);
$arr_ans_2    = array($ans_3,$ans_4,$ans_5);
$arr_ans_3    = array($ans_6,$ans_7,$ans_8);
$teque_type_sub = 2;
$true = 1;
$false = 0;
//=========================//
$fs_errorMsg = "";
$myform = new generate_form();
$myform->add("teque_tec_id	" , "iPara" , 1 , 1 , 0 , 1,"" , 0 , "");
$myform->add("teque_content" , "question" , 0 , 1 , "" , 1,"Bạn chưa nhập câu hỏi" , 0 , "");
$myform->add("teque_type" , "teque_type" , 1 , 1 , 2 , 1,"Bạn chưa nhập câu hỏi" , 0 , "");
$myform->add("teque_type_sub" , "teque_type_sub" , 1 , 1 , 2 , 0,"" , 0 , "");
if($fs_errorMsg == ""){
	if($fs_errorMsg == ""){
		$myform->addTable("test_questions");
		$myform->removeHTML(0);
		$db_insert 	= new db_execute_return();
		$last_exe_id		= $db_insert->db_execute($myform->generate_insert_SQL());
      if($last_exe_id>0){
         //lấy id của câu hỏi chính sau khi insert
         $ques_id = $last_exe_id;
         
         $quessub_form_1 = new generate_form();           
         $quessub_form_1->add("quesub_teque_id","ques_id",1,1,0,0,"",0,"");
         $quessub_form_1->add("quesub_content","ques_sub_1",0,1,"",0,"",0,"");
         $quessub_form_1->addTable("test_questions_sub");
   		$quessub_form_1->removeHTML(0);
   		$db_insert = new db_execute_return();
   		$last_quesub_id_1 = $db_insert->db_execute($quessub_form_1->generate_insert_SQL());
         unset($db_insert);
         
         $quessub_form_2 = new generate_form();           
         $quessub_form_2->add("quesub_teque_id","ques_id",1,1,0,0,"",0,"");
         $quessub_form_2->add("quesub_content","ques_sub_2",0,1,"",0,"",0,"");
         $quessub_form_2->addTable("test_questions_sub");
   		$quessub_form_2->removeHTML(0);
   		$db_insert = new db_execute_return();
   		$last_quesub_id_2 = $db_insert->db_execute($quessub_form_2->generate_insert_SQL());
         unset($db_insert);
         
         for($i=0;$i<2;$i++){
            $ans_form_1 = new generate_form();
            $ans = $arr_ans_1[$i];
            $msg = $ans;
            $ans_form_1->add("tan_teques_id","ques_id",1,1,0,0,"",0,"");
            $ans_form_1->add("tan_quesub_id","last_quesub_id_1",1,1,0,0,"",0,"");
            $ans_form_1->add("tan_content" , "ans" , 0 , 1 , "" , 1,"Bạn chưa nhập câu trả lời" , 0 , "");
            $ans_form_1->add("tan_true" , "true" , 1 , 1 , 1 , 1,"Bạn chưa nhập câu trả lời đúng" , 0 , "");
            $ans_form_1->addTable("test_answers");
      		$ans_form_1->removeHTML(0);
      		$db_insert_1 = new db_execute_return();
      		$last_exe_id = $db_insert_1->db_execute($ans_form_1->generate_insert_SQL());
            unset($db_insert_1);
         }
         
         for($i=0;$i<3;$i++){
            $ans_form_2 = new generate_form();
            $ans = $arr_ans_2[$i];
            $ans_form_2->add("tan_teques_id","ques_id",1,1,0,0,"",0,"");
            $ans_form_2->add("tan_quesub_id","last_quesub_id_2",1,1,0,0,"",0,"");
            $ans_form_2->add("tan_content" , "ans" , 0 , 1 , "" , 1,"Bạn chưa nhập câu trả lời" , 0 , "");
            $ans_form_2->add("tan_true" , "true" , 1 , 1 , 1 , 1,"Bạn chưa nhập câu trả lời đúng" , 0 , "");
            $ans_form_2->addTable("test_answers");
      		$ans_form_2->removeHTML(0);
      		$db_insert_2 = new db_execute_return();
      		$last_exe_id = $db_insert_2->db_execute($ans_form_2->generate_insert_SQL());
            unset($db_insert_2);
         }
         
         for($i=0;$i<3;$i++){
            $ans_form_3 = new generate_form();
            $ans = $arr_ans_3[$i];
            $ans_form_3->add("tan_teques_id","ques_id",1,1,0,0,"",0,"");
            $ans_form_3->add("tan_content" , "ans" , 0 , 1 , "" , 1,"Bạn chưa nhập câu trả lời" , 0 , "");
            $ans_form_3->add("tan_true" , "false" , 1 , 1 , 0 , 1,"Bạn chưa nhập câu trả lời đúng" , 0 , "");
            $ans_form_3->addTable("test_answers");
      		$ans_form_3->removeHTML(0);
      		$db_insert_3 = new db_execute_return();
      		$last_exe_id = $db_insert_3->db_execute($ans_form_3->generate_insert_SQL());
            unset($db_insert_3);
         }
      }
	}
   $msg = "Thêm dữ liệu thành công";
}else{
   $err = "Xảy ra lỗi trong quá trình thêm dữ liệu";
}
//==================
$json['msg'] = $msg;
$json['err'] = $err;
echo json_encode($json);

?>