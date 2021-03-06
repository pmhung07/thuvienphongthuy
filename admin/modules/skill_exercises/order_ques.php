<?
include("inc_security.php");

//========== variable json=========//
$msg   = "";
$err 	 = "";
$json  = array();
$fs_errorMsg = "";

//====== get variable question=====//
$ques_id	      = getValue("ques_id","int","POST",0);
$order_ques    = getValue("order_ques","int","POST","");

//=================================//
if($ques_id > 0){
   $myform = new generate_form();
   $myform->add("que_id","ques_id",1,1,"",0,"",0,"");
   $myform->add("que_order","order_ques",1,1,"",0,"",0,"");
   $myform->addTable("questions");
   //Check $action for insert new data
   $fs_errorMsg .= $myform->checkdata();
   if($fs_errorMsg == ""){
      $myform->removeHTML(0);
   	$db_update = new db_execute($myform->generate_update_SQL("que_id", $ques_id));
   	unset($db_update);
      $msg = "Order Success";
   }else{
      $err = "Error";
   }
   
   //==================
   $json['msg'] = $msg;
   $json['err'] = $err;
   echo json_encode($json);
}
?>