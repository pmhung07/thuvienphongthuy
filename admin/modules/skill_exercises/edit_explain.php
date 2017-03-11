<?
include("inc_security.php");

//========== variable json=========//
$msg   = "";
$err 	 = "";
$json  = array();
$fs_errorMsg = "";

//====== get variable question=====//
$que_id	       = getValue("que_id","int","POST",0);
$que_explain        = getValue("que_exp","str","POST","");

//=================================//
if($que_id > 0){
   $myform = new generate_form();
   $myform->add("que_id","que_id",1,1,"",0,"",0,"");
   $myform->add("que_explain","que_explain",0,1,"",0,"",0,"");
   $myform->addTable("questions");
   //Check $action for insert new data
   $fs_errorMsg .= $myform->checkdata();
   if($fs_errorMsg == ""){
      $myform->removeHTML(0);
   	$db_update = new db_execute($myform->generate_update_SQL("que_id", $que_id));
   	unset($db_update);
      $msg = "Quá trình sửa đổi thành công";
   }else{
      $err = "Có lỗi trong quá trình sửa đổi";
   }
   
   //==================
   $json['msg'] = $msg;
   $json['err'] = $err;
   echo json_encode($json);
}
?>