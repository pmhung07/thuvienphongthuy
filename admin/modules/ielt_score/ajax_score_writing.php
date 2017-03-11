<?
include("inc_security.php");

//========== variable json=========//
$msg   = "";
$err 	 = "";
$json  = array();
$fs_errorMsg = "";

//====== get variable question=====//
$tesr_id	 = getValue("tesr_id","int","POST",0);
$score    = getValue("score","int","POST","");
$comment = getValue("comment","str","POST","");
$type = getValue("tesr_id","int","POST",0);
//=================================//

$myform = new generate_form();
$myform->add("ielr_point_writing","score",1,1,"",0,"",0,"");
$myform->add("ielr_cmt_writing","comment",0,1,"",0,"",0,"");
$myform->addTable("ielts_result");
//Check $action for insert new data
$fs_errorMsg .= $myform->checkdata();
if($fs_errorMsg == ""){
$myform->removeHTML(0);
$db_update = new db_execute($myform->generate_update_SQL("ielr_id", $tesr_id));
unset($db_update);
$msg = "Scores Success";
}else{
$err = "Error";
}

//==================
$json['msg'] = $msg;
$json['err'] = $err;
echo json_encode($json);

?>