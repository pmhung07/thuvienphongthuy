<?
include("inc_security.php");

//========== variable json=========//
$msg   = "";
$err 	 = "";
$json  = array();
$fs_errorMsg = "";

//====== get variable answers=====//
$ans_check_id	 = getValue("ans_id","int","POST",0);
$change_true	 = getValue("change_true","int","POST",0);

//=================================//

$myform_udp = new generate_form();
if($change_true == 1){
   $ans_last_true = 0;
   $myform_udp ->add("tan_true","ans_last_true",1,1,0,0,"",0,"");
}else{
   $ans_last_true = 1;
   $myform_udp ->add("tan_true","ans_last_true",1,1,1,0,"",0,"");
}
$myform_udp ->addTable("test_answers");
if($fs_errorMsg == ""){
      $myform_udp->removeHTML(0);
   	$db_update = new db_execute($myform_udp->generate_update_SQL("tan_id", $ans_check_id));
   	unset($db_update);
      $msg = "Thao tác thành công";
   }else{
      $err = "Có lỗi trong quá trình sửa đổi";
   }
//==================
$json['msg'] = $msg;
$json['err'] = $err;
echo json_encode($json);
?>