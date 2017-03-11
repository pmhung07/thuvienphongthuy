<?php
require_once("../home/config.php");
//check
//========== variable json=========//
$msg   = "";
$err 	 = "";
$json  = array();
$fs_errorMsg = "";

   
    $class_id = getValue("class_id","int","POST",0);
        $teacher = getValue("teacher","int","POST",0);
            $contentmes = getValue("contentmes","str","POST",0);
        $u_id = getValue("u_id","int","POST",0);
        $mesclass_date = time();
        $mesclass_type = 3;


        $myform = new generate_form();
        $myform->add("mesclass_class" ,"class_id" , 1 , 1 , 0 , 1,"" , 0 , "");
        $myform->add("mesclass_teacher" , "teacher" , 1 , 1 , 0 , 1,"" , 0 , "");
        $myform->add("mesclass_content" , "contentmes" , 0 , 1 , 0 , 1,"" , 0 , "");
        $myform->add("mesclass_date" , "mesclass_date" , 1 , 1 , 0 , 1,"" , 0 , "");
        $myform->add("mes_uid" , "u_id" , 1 , 1 , 0 , 1,"" , 0 , "");
        $myform->add("mesclass_type" , "mesclass_type" , 1 , 1 , 0 , 1,"" , 0 , "");
        if($fs_errorMsg == ""){
            $myform->addTable("mesclass");
            $myform->removeHTML(0);
            $db_insert  = new db_execute_return();
            $last_exe_id = $db_insert->db_execute($myform->generate_insert_SQL());
            $msg = "Thành công";
        }else{
           $err = "Xảy ra lỗi trong quá trình thêm dữ liệu";
        }
    


if($err == ''){
    echo '1';
}else{
    echo '0';
}
?>