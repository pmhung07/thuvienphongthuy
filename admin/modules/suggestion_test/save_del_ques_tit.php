<?
include("inc_security.php");

//========== variable json=========//
$msg   = "";
$err 	 = "";
$json  = array();
$fs_errorMsg = "";

//====== get variable question=====//
$type       = getValue("type","int","POST",0);
$que_id	   = getValue("que_id","int","POST",0);
$que_tit    = getValue("que_tit","str","POST","");

//=================================//
if($type == 2) $que_tit = '';
 
$myform = new generate_form();
$myform->add("sg_ques_id","que_id",1,1,"",0,"",0,"");
$myform->add("sg_ques_title","que_tit",0,1,"",0,"",0,"");
$myform->addTable("sg_test_questions");
//Check $action for insert new data
$fs_errorMsg .= $myform->checkdata();
if($fs_errorMsg == ""){
   $myform->removeHTML(0);
	$db_update = new db_execute($myform->generate_update_SQL("sg_ques_id", $que_id));
	unset($db_update);
   $msg = "Quá trình sửa đổi thành công";
}else{
   $err = "Có lỗi trong quá trính sửa đổi";
}

//==================
$json['msg'] = $msg;
$json['err'] = $err;
echo json_encode($json);
?>