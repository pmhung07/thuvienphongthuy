<?
include("inc_security.php");

//========== variable json=========//
$msg   = "";
$err 	 = "";
$json  = array();
$fs_errorMsg = "";

//====== get variable question=====//
$tesr_id	       = getValue("tesr_id","int","POST",0);
$writing_speak    = getValue("writing_speak","str","POST","");

//=================================//
if($tesr_id > 0){
   $myform = new generate_form();
   $myform->add("tesr_id","tesr_id",1,1,"",0,"",0,"");
   $myform->add("tesr_writing","writing_speak",1,1,"",0,"",0,"");
   $myform->addTable("test_result");
   //Check $action for insert new data
   $fs_errorMsg .= $myform->checkdata();
   if($fs_errorMsg == ""){
      $myform->removeHTML(0);
   	$db_update = new db_execute($myform->generate_update_SQL("tesr_id", $tesr_id));
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