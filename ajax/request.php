<?php
require_once("../home/config.php");
//check
//========== variable json=========//
$msg   = "";
$err 	 = "";
$json  = array();
$fs_errorMsg = "";


$type  = getValue("type","str","POST","");

switch ($type) {
    case "add_student":    
        $class_id = getValue("class_id","int","POST",0);
        $email_student = getValue("email_student","str","POST","");
        if($email_student != ""){
            $db_select_student = new db_query("SELECT * FROM users WHERE use_email='".$email_student."'");
            $arrStudent = $db_select_student->resultArray();
            if(count($arrStudent) > 0 && ($myuser->u_id != $arrStudent[0]['use_id']) && $arrStudent[0]['use_teacher'] != 1){

                $db_select_student_child = new db_query("SELECT * FROM class_user WHERE class_user_uid=".$arrStudent[0]['use_id']." AND class_user_class_id=".$class_id);
                $arrStudent_child = $db_select_student_child->resultArray();
                if(count($arrStudent_child) <= 0){
                    $uid = $arrStudent[0]['use_id'];
                    $class_user_created = time();
                    $myform = new generate_form();
                    $myform->add("class_user_class_id" ,"class_id" , 1 , 1 , 0 , 1,"" , 0 , "");
                    $myform->add("class_user_uid" , "uid" , 1 , 1 , 0 , 1,"" , 0 , "");
                    $myform->add("class_user_created" , "class_user_created" , 1 , 1 , 0 , 1,"" , 0 , "");
                    if($fs_errorMsg == ""){
                        $myform->addTable("class_user");
                        $myform->removeHTML(0);
                        $db_insert  = new db_execute_return();
                        $last_exe_id = $db_insert->db_execute($myform->generate_insert_SQL());
                        $msg = "Thành công";
                    }else{
                       $err = "Xảy ra lỗi trong quá trình thêm dữ liệu";
                    }
                }else{
                    $err = "Xảy ra lỗi trong quá trình thêm dữ liệu";
                }
            }else{
                $err = "Xảy ra lỗi trong quá trình thêm dữ liệu";
            }
        }else{
            $err = "Nội dung không được để trống";
        }
    break;

    case "request_writing":    
        $uid = getValue("uid","int","POST",0);
        $question_id = getValue("question_id","int","POST",0);
        $contentwriting = getValue("contentwriting","str","POST","");
        $check_add = "false";
        $lwr_status = 0;
        $lwr_date  = time();

        $db_select_wri = new db_query("SELECT * FROM learn_writing_result WHERE lwr_wri_id=".$question_id." AND lwr_use_id=".$uid);
        $arrWri = $db_select_wri->resultArray();
        if(count($arrWri) <= 0){
            $check_add = "true";
        }else{
            if($arrWri[0]['lwr_status'] == 1){
                $check_add = "true";
            }else{
                $check_add = "false";
            }
        }

        if($check_add == "true"){
            $myform = new generate_form();
            $myform->add("lwr_use_id" ,"uid" , 1 , 1 , 0 , 1,"" , 0 , "");
            $myform->add("lwr_wri_id" , "question_id" , 1 , 1 , 0 , 1,"" , 0 , "");
            $myform->add("lwr_content" , "contentwriting" , 0 , 1 , 0 , 1,"" , 0 , "");
            $myform->add("lwr_status" , "lwr_status" , 1 , 1 , 0 , 1,"" , 0 , "");
            $myform->add("lwr_date" , "lwr_date" , 1 , 1 , 0 , 1,"" , 0 , "");
            if($fs_errorMsg == ""){
                $myform->addTable("learn_writing_result");
                $myform->removeHTML(0);
                $db_insert  = new db_execute_return();
                $last_exe_id = $db_insert->db_execute($myform->generate_insert_SQL());
                $msg = "Thành công";
            }else{
               $err = "Xảy ra lỗi trong quá trình thêm dữ liệu";
            }
        }else{
            $err = "Xảy ra lỗi trong quá trình thêm dữ liệu";
        }
        
    break;

    case "request_recording":    
        $uid = getValue("uid","int","POST",0);
        $question_id = getValue("question_id","int","POST",0);
        $strname = getValue("strname","str","POST","");
        $check_add = "false";
        $lsp_status = 0;
        $lsp_date  = time();

        $db_select_spk = new db_query("SELECT * FROM learn_speak_result WHERE lsr_spe_id=".$question_id." AND lsr_use_id=".$uid);
        $arrspk = $db_select_spk->resultArray();
        if(count($arrspk) <= 0){
            $check_add = "true";
        }else{
            if($arrspk[0]['lsr_status'] == 1){
                $check_add = "true";
            }else{
                $check_add = "false";
            }
        }

        if($check_add == "true"){
            $myform = new generate_form();
            $myform->add("lsr_use_id" ,"uid" , 1 , 1 , 0 , 1,"" , 0 , "");
            $myform->add("lsr_spe_id" , "question_id" , 1 , 1 , 0 , 1,"" , 0 , "");
            $myform->add("lsr_audio" , "strname" , 0 , 1 , 0 , 1,"" , 0 , "");
            $myform->add("lsr_status" , "lsp_status" , 1 , 1 , 0 , 1,"" , 0 , "");
            $myform->add("lsr_date" , "lsp_date" , 1 , 1 , 0 , 1,"" , 0 , "");
            if($fs_errorMsg == ""){
                $myform->addTable("learn_speak_result");
                $myform->removeHTML(0);
                $db_insert  = new db_execute_return();
                $last_exe_id = $db_insert->db_execute($myform->generate_insert_SQL());
                $msg = "Thành công";
                //if (copy("../js/data_record/".trim($strname),"../js/data_record/record/".trim($strname))) {
                    //unlink("../js/data_record/".trim($strname));
                //}
            }else{
               $err = "Xảy ra lỗi trong quá trình thêm dữ liệu";
            }
        }else{
            $err = "Xảy ra lỗi trong quá trình thêm dữ liệu";
        }
        
    break;

    case "score_speaking":    
        $lsr_id = getValue("lsr_id","int","POST",0);
        $score = getValue("score","int","POST",0);
        $nx = getValue("nx","str","POST","");
        $lsr_status = 1;

        $myform = new generate_form();
        $myform->add("lsr_point" ,"score" , 1 , 1 , 0 , 1,"" , 0 , "");
        $myform->add("lsr_comment" , "nx" , 0 , 1 , 0 , 1,"" , 0 , "");
        $myform->add("lsr_status" , "lsr_status" , 1 , 1 , 0 , 1,"" , 0 , "");
        $myform->addTable("learn_speak_result");
        $myform->removeHTML(0);
        $db_update = new db_execute($myform->generate_update_SQL("lsr_id", $lsr_id));
        unset($db_update);
        $msg = "Update thành công";
    break;

    case "score_writing":    
        $lwr_id = getValue("lwr_id","int","POST",0);
        $score = getValue("score","int","POST",0);
        $nx = getValue("nx","str","POST","");
        $lwr_status = 1;

        $myform = new generate_form();
        $myform->add("lwr_point" ,"score" , 1 , 1 , 0 , 1,"" , 0 , "");
        $myform->add("lwr_comment" , "nx" , 0 , 1 , 0 , 1,"" , 0 , "");
        $myform->add("lwr_status" , "lwr_status" , 1 , 1 , 0 , 1,"" , 0 , "");
        $myform->addTable("learn_writing_result");
        $myform->removeHTML(0);
        $db_update = new db_execute($myform->generate_update_SQL("lwr_id", $lwr_id));
        unset($db_update);
        $msg = "Update thành công";
    break;

    default:
    break;
}

if($err == ''){
    echo '1';
}else{
    echo '0';
}
?>