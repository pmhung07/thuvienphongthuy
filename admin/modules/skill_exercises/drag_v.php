<?
include("inc_security.php");

//===== variable json=====//
$msg   = "";
$err 	 = "";
$json  = array();

//====== get variable =====//
$exe_id	   = getValue("exe_id","int","POST",0);
$ans     	= getValue("ans_drag","str","POST","");
$ques       = getValue("ques_drag","str","POST","");
$type_ques  = getValue("type_ques","int","POST",0);
$que_active = 1;
$ans_true   = 1;
//=========================//
$myform = new generate_form();
$myform->add("que_exe_id" , "exe_id" , 1 , 1 , 0 , 1,"" , 0 , "");
$myform->add("que_content" , "ques" , 0 , 1 , "" , 1,"" , 0 , "");
$myform->add("que_type" , "type_ques" , 1 , 1 , "" , 1,"" , 0 , "");
$myform->add("que_active" , "que_active" , 1 , 1 , 1 , 1,"" , 0 , "");
if($fs_errorMsg == ""){
	if($fs_errorMsg == ""){
		$myform->addTable("questions");
		$myform->removeHTML(0);
		$db_insert 	= new db_execute_return();
		$last_exe_id		= $db_insert->db_execute($myform->generate_insert_SQL());
      if($last_exe_id>0){
         $exe_id = $last_exe_id;
            $ans_form = new generate_form();
            $ans_form->add("ans_ques_id" , "exe_id" , 1 , 1 , 0 , 1,"" , 0 , ""); 
            $ans_form->add("ans_content" , "ans" , 0 , 1 , "" , 0,"" , 0 , "");
            $ans_form->add("ans_true" , "ans_true" , 1 , 1 , 1 , 1,"" , 0 , "");
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