<?
include("inc_security.php");

//===== variable json=====//
$msg   = "";
$err 	 = "";
$json  = array();

//=====
$fs_errorMsg = "";

//====== get variable =====//
$teque_id         = getValue("teque_id","int","POST",0);
$add_ans_content  = getValue("add_ans_content","str","POST","");
$ans_true         = 0;
$que_active       = 1;

//=========================//
$myform = new generate_form();
$myform->add("tan_teques_id" , "teque_id" , 1 , 1 , 0 , 1,"" , 0 , "");
$myform->add("tan_quesub_id" , "quesub_id" , 1 , 1 , 0 , 1,"" , 0 , "");
$myform->add("tan_true" , "ans_true" , 1 , 1 , 0 , 1,"" , 0 , "");
$myform->add("tan_content" , "add_ans_content" , 0 , 1 , "" , 1,"" , 0 , "");
if($fs_errorMsg == ""){
	if($fs_errorMsg == ""){
		$myform->addTable("test_answers");
		$myform->removeHTML(0);
		$db_insert 	= new db_execute_return();
		$last_exe_id = $db_insert->db_execute($myform->generate_insert_SQL());
      $msg = "Thêm câu tra lời thành công";
	}
}else{
   $err = "Xảy ra lỗi trong quá trình thêm dữ liệu";
}
//==================
$json['msg'] = $msg;
$json['err'] = $err;
echo json_encode($json);

?>
