<?
include("inc_security.php");

//========== variable json=========//
$msg   = "";
$err 	 = "";
$json  = array();
$fs_errorMsg = "";

//====== get variable question=====//
$ques_id	      = getValue("ques_id","int","POST",0);
$score_ques    = getValue("score_ques","str","POST","");

//=================================//
if($ques_id > 0){
   $myform = new generate_form();
   $myform->add("teque_id","ques_id",1,1,"",0,"",0,"");
   $myform->add("	teque_score","score_ques",1,1,"",0,"",0,"");
   $myform->addTable("test_questions");
   //Check $action for insert new data
   $fs_errorMsg .= $myform->checkdata();
   if($fs_errorMsg == ""){
      $myform->removeHTML(0);
   	$db_update = new db_execute($myform->generate_update_SQL("teque_id", $ques_id));
   	unset($db_update);
      $msg = "Scores Success";
   }else{
      $err = "Error";
   }
   
   //==================
   $json['msg'] = $msg;
   $json['err'] = $err;
   echo json_encode($json);
}
?>