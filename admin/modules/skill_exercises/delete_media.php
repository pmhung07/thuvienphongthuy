<?
include("inc_security.php");

//========== variable json=========//
$msg   = "";
$err 	 = "";
$json  = array();

$fs_filepath_med = "../../../data/skill_exercises/";
$fs_table_med    = "media_exercies";
$id_field_med    = "media_id";
$id_select_med   = "media_name";

//====== get variable question=====//
$media_id = getValue("media_id","int","POST",0);
$media_name = getValue("media_name","str","POST","");
//=================================//
if($media_id > 0){
   delete_file($fs_table_med,$id_field_med,$media_id,$id_select_med,$fs_filepath_med);
   $db_del_med = new db_execute("DELETE FROM media_exercies WHERE media_id = " .$media_id);
   unset($db_del_med);
   //Update lại question:
   $db_sl_que = new db_query("SELECT que_id FROM questions WHERE que_media_id = ". $media_id);
   while($row_ques = mysqli_fetch_assoc($db_sl_que->result)){
      $med_id = $row_ques['que_id'];
      $myform = new generate_form();
      $myform->add("que_media_id",0,1,1,"",0,"",0,"");
      $myform->addTable("questions");
      $db_update = new db_execute($myform->generate_update_SQL("que_id", $med_id));
   	unset($db_update);
   }unset($db_sl_que);
   $msg = "Câu hỏi và câu trả lời tương ứng đã được xóa";
   //==================
   $json['msg'] = $msg;
   $json['err'] = $err;
   echo json_encode($json);
}
?>