<?
include("inc_security.php");

//========== variable json=========//
$msg   = "";
$err 	 = "";
$json  = array();
$fs_errorMsg = "";

//====== get variable question=====//
$que_id	       = getValue("que_id","int","POST",0);
$que_content    = getValue("que_content","str","POST","");

//====== get variable answers=====//
$ans_id	       = getValue("ans_id","int","POST",0);
$ans_content    = getValue("ans_content","str","POST","");

//=================================//
if($que_id > 0){ 
   $myform = new generate_form();
   $myform->add("uque_id","que_id",1,1,"",0,"",0,"");
   $myform->add("uque_ques","que_content",0,1,"",0,"",0,"");
   $myform->addTable("uni_quest");
   //Check $action for insert new data
   $fs_errorMsg .= $myform->checkdata();
   if($fs_errorMsg == ""){
      $myform->removeHTML(0);
   	$db_update = new db_execute($myform->generate_update_SQL("uque_id", $que_id));
   	unset($db_update);
      $msg = "Quá trình sửa đổi thành công";
   }else{
      $err = "Có lỗi trong quá trính sửa đổi";
   }
   
   //==================
   $json['msg'] = $msg;
   $json['err'] = $err;
   echo json_encode($json);
}

//=================================//
if($ans_id > 0){
$myform = new generate_form();
$myform->add("uan_id","ans_id",1,1,"",0,"",0,"");
$myform->add("uan_content","ans_content",0,1,"",0,"",0,"");
$myform->addTable("uni_answers");
//Check $action for insert new data
$fs_errorMsg .= $myform->checkdata();
if($fs_errorMsg == ""){
   $myform->removeHTML(0);
	$db_update = new db_execute($myform->generate_update_SQL("uan_id", $ans_id));
	unset($db_update);
   $msg = "Quá trình sửa đổi thành công";
}else{
   $err = "Có lỗi trong quá trính sửa đổi";
}

//==================
$json['msg'] = $msg;
$json['err'] = $err;
echo json_encode($json);
}
?>