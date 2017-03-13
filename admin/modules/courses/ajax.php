<?php
include("inc_security.php");
//check
//========== variable json=========//
$msg   = "";
$err 	 = "";
$json  = array();
$fs_errorMsg = "";


$type  = getValue("tab_type","str","POST","");

switch ($type) {
    case "add_tabs":
        $com_id = getValue("com_id","int","POST",0);
        $valtab = getValue("valtab","str","POST","");
        if($valtab != ""){
            $myform = new generate_form();
            $myform->add("cou_tab_com_id" ,"com_id" , 1 , 1 , 0 , 1,"" , 0 , "");
            $myform->add("cou_tab_name" , "valtab" , 0 , 1 , "" , 1,"" , 0 , "");
            if($fs_errorMsg == ""){
                $myform->addTable("courses_multi_tabs");
                $myform->removeHTML(0);
                $db_insert  = new db_execute_return();
                $last_exe_id = $db_insert->db_execute($myform->generate_insert_SQL());
                $msg = "Thêm Tabs thành công";
            }else{
               $err = "Xảy ra lỗi trong quá trình thêm dữ liệu";
            }
        }else{
            $err = "Nội dung không được để trống";
        }
    break;

    case "update_unitname":
        $com_id = getValue("com_id","int","POST",0);
        $unitname = getValue("unitname","str","POST","");
        if($unitname != ""){
            $myform_udp = new generate_form();
            $myform_udp ->add("com_name","unitname",0,1,1,0,"",0,"");
            $myform_udp ->addTable("courses_multi");
            if($fs_errorMsg == ""){
                $myform_udp->removeHTML(0);
                $db_update = new db_execute($myform_udp->generate_update_SQL("com_id", $com_id));
                unset($db_update);
                $msg = "Update thành công";
            }else{
                $err = "Có lỗi trong quá trình sửa đổi";
            }
        }else{
            $err = "Nội dung không được để trống";
        }
    break;

    case "update_blockname":
        $cou_block_id = getValue("cou_block_id","int","POST",0);
        $blockname = getValue("blockname","str","POST","");
        if($blockname != ""){
            $myform_udp = new generate_form();
            $myform_udp ->add("com_block_data_name","blockname",0,1,1,0,"",0,"");
            $myform_udp ->addTable("courses_multi_tabs_block");
            if($fs_errorMsg == ""){
                $myform_udp->removeHTML(0);
                $db_update = new db_execute($myform_udp->generate_update_SQL("com_block_id", $cou_block_id));
                unset($db_update);
                $msg = "Update thành công";
            }else{
                $err = "Có lỗi trong quá trình sửa đổi";
            }
        }else{
            $err = "Nội dung không được để trống";
        }
    break;

    case "settrue_answer":
        $ques_id = getValue("ques_id","int","POST",0);
        $ans_id = getValue("ans_id","int","POST",0);
        $ans_first_true = 0;
        $ans_last_true = 1;

        $db_select_ans  = new db_query("SELECT cou_tab_answer_id FROM courses_multi_tab_answers WHERE cou_tab_answer_question_id = ". $ques_id);
        while($row_ans = mysqli_fetch_assoc($db_select_ans->result)){
           $ans_idcec = $row_ans["cou_tab_answer_id"];
           $myform = new generate_form();
           $myform->add("cou_tab_answer_true","ans_first_true",1,1,0,0,"",0,"");
           $myform->addTable("courses_multi_tab_answers");
            $db_update = new db_execute($myform->generate_update_SQL("cou_tab_answer_id", $ans_idcec));
            unset($db_update);
        }unset($db_select_ans);

        $myform_udp = new generate_form();
        $myform_udp ->add("cou_tab_answer_true","ans_last_true",1,1,1,0,"",0,"");
        $myform_udp ->addTable("courses_multi_tab_answers");
        if($fs_errorMsg == ""){
              $myform_udp->removeHTML(0);
            $db_update = new db_execute($myform_udp->generate_update_SQL("cou_tab_answer_id", $ans_id));
            unset($db_update);
              $msg = "Đã chọn câu trả lời đúng";
           }else{
              $err = "Có lỗi trong quá trình sửa đổi";
           }
    break;

    case "update_questname":
        $ques_id = getValue("ques_id","int","POST",0);
        $quesname = getValue("quesname","str","POST","");
        if($quesname != ""){
            $myform_udp = new generate_form();
            $myform_udp ->add("cou_tab_question_content","quesname",0,1,1,0,"",0,"");
            $myform_udp ->addTable("courses_multi_tab_questions");
            if($fs_errorMsg == ""){
                $myform_udp->removeHTML(0);
                $db_update = new db_execute($myform_udp->generate_update_SQL("cou_tab_question_id", $ques_id));
                unset($db_update);
                $msg = "Update thành công";
            }else{
                $err = "Có lỗi trong quá trình sửa đổi";
            }
        }else{
            $err = "Nội dung không được để trống";
        }
    break;

    case "order_questtion":
        $ques_id = getValue("ques_id","int","POST",0);
        $order = getValue("order","int","POST",0);
        if($ques_id > 0){
            $myform_udp = new generate_form();
            $myform_udp ->add("cou_tab_question_order","order",1,1,1,0,"",0,"");
            $myform_udp ->addTable("courses_multi_tab_questions");
            if($fs_errorMsg == ""){
                $myform_udp->removeHTML(0);
                $db_update = new db_execute($myform_udp->generate_update_SQL("cou_tab_question_id", $ques_id));
                unset($db_update);
                $msg = "Update thành công";
            }else{
                $err = "Có lỗi trong quá trình sửa đổi";
            }
        }else{
            $err = "Nội dung không được để trống";
        }
    break;

    case "del_question":
        $ques_id = getValue("ques_id","int","POST",0);
        if($ques_id > 0){
            $db_del = new db_execute("DELETE FROM courses_multi_tab_questions WHERE cou_tab_question_id = " .$ques_id);
            unset($db_del);
            $msg = "Câu hỏi và câu trả lời tương ứng đã được xóa";
        }else{
            $err = "Nội dung không được để trống";
        }
    break;

    case "update_ansname":
        $ans_id = getValue("ans_id","int","POST",0);
        $ansname = getValue("ansname","str","POST","");
        if($ansname != ""){
            $myform_udp = new generate_form();
            $myform_udp ->add("cou_tab_answer_content","ansname",0,1,1,0,"",0,"");
            $myform_udp ->addTable("courses_multi_tab_answers");
            if($fs_errorMsg == ""){
                $myform_udp->removeHTML(0);
                $db_update = new db_execute($myform_udp->generate_update_SQL("cou_tab_answer_id", $ans_id));
                unset($db_update);
                $msg = "Update thành công";
            }else{
                $err = "Có lỗi trong quá trình sửa đổi";
            }
        }else{
            $err = "Nội dung không được để trống";
        }
    break;

    case "update_tabname":
        $cou_tab_id = getValue("cou_tab_id","int","POST",0);
        $tabname = getValue("unitname","str","POST","");
        if($tabname != ""){
            $myform_udp = new generate_form();
            $myform_udp ->add("cou_tab_name","tabname",0,1,1,0,"",0,"");
            $myform_udp ->addTable("courses_multi_tabs");
            if($fs_errorMsg == ""){
                $myform_udp->removeHTML(0);
                $db_update = new db_execute($myform_udp->generate_update_SQL("cou_tab_id", $cou_tab_id));
                unset($db_update);
                $msg = "Update thành công";
            }else{
                $err = "Có lỗi trong quá trình sửa đổi";
            }
        }else{
            $err = "Nội dung không được để trống";
        }
    break;

    case "update_orderunit":
        $order = getValue("order","int","POST",0);
        $com_id = getValue("com_id","int","POST",0);
        if($order != ""){
            $myform_udp = new generate_form();
            $myform_udp ->add("com_num_unit","order",1,1,1,0,"",0,"");
            $myform_udp ->addTable("courses_multi");
            if($fs_errorMsg == ""){
                $myform_udp->removeHTML(0);
                $db_update = new db_execute($myform_udp->generate_update_SQL("com_id", $com_id));
                unset($db_update);
                $msg = "Update thành công";
            }else{
                $err = "Có lỗi trong quá trình sửa đổi";
            }
        }else{
            $err = "Nội dung không được để trống";
        }
    break;

    case "update_orderblockmain":
        $order = getValue("order","int","POST",0);
        $com_id = getValue("com_id","int","POST",0);
        if($order != ""){
            $myform_udp = new generate_form();
            $myform_udp ->add("com_block_data_order","order",1,1,1,0,"",0,"");
            $myform_udp ->addTable("courses_multi_tabs_block");
            if($fs_errorMsg == ""){
                $myform_udp->removeHTML(0);
                $db_update = new db_execute($myform_udp->generate_update_SQL("com_block_id", $com_id));
                unset($db_update);
                $msg = "Update thành công";
            }else{
                $err = "Có lỗi trong quá trình sửa đổi";
            }
        }else{
            $err = "Nội dung không được để trống";
        }
    break;

    case "update_ordertab":
        $order = getValue("order","int","POST",0);
        $com_id = getValue("cou_tab_id","int","POST",0);
        if($order != ""){
            $myform_udp = new generate_form();
            $myform_udp ->add("cou_tab_order","order",1,1,1,0,"",0,"");
            $myform_udp ->addTable("courses_multi_tabs");
            if($fs_errorMsg == ""){
                $myform_udp->removeHTML(0);
                $db_update = new db_execute($myform_udp->generate_update_SQL("cou_tab_id", $com_id));
                unset($db_update);
                $msg = "Update thành công";
            }else{
                $err = "Có lỗi trong quá trình sửa đổi";
            }
        }else{
            $err = "Nội dung không được để trống";
        }
    break;

    case "addblockintab":
        $tab_id = getValue("tab_id","int","POST",0);
        $blockname = getValue("blockname","str","POST",0);
        $com_block_data_type = "content_data";

        if($blockname != ""){
            $myform = new generate_form();
            $myform->add("com_block_tab_id" ,"tab_id" , 1 , 1 , 0 , 1,"" , 0 , "");
            $myform->add("com_block_data_type" , "com_block_data_type" , 0 , 1 , "" , 1,"" , 0 , "");
            $myform->add("com_block_data_name" , "blockname" , 0 , 1 , "" , 1,"" , 0 , "");
            $myform->add("com_block_data_order" , "com_block_data_order" , 0 , 1 , "" , 1,"" , 0 , "");
            if($fs_errorMsg == ""){
                $myform->addTable("courses_multi_tabs_block");
                $myform->removeHTML(0);
                $db_insert  = new db_execute_return();
                $last_exe_id = $db_insert->db_execute($myform->generate_insert_SQL());
                $msg = "Thêm Block thành công";
            }else{
               $err = "Xảy ra lỗi trong quá trình thêm dữ liệu";
            }
        }else{
            $err = "Nội dung không được để trống";
        }
    break;

    case "addblockintabquesmatching":
        $tab_id = getValue("tab_id","int","POST",0);
        $blockname = getValue("blockname","str","POST",0);
        $com_block_data_type = "question_matching";

        if($blockname != ""){
            $myform = new generate_form();
            $myform->add("com_block_tab_id" ,"tab_id" , 1 , 1 , 0 , 1,"" , 0 , "");
            $myform->add("com_block_data_type" , "com_block_data_type" , 0 , 1 , "" , 1,"" , 0 , "");
            $myform->add("com_block_data_name" , "blockname" , 0 , 1 , "" , 1,"" , 0 , "");
            $myform->add("com_block_data_order" , "com_block_data_order" , 0 , 1 , "" , 1,"" , 0 , "");
            if($fs_errorMsg == ""){
                $myform->addTable("courses_multi_tabs_block");
                $myform->removeHTML(0);
                $db_insert  = new db_execute_return();
                $last_exe_id = $db_insert->db_execute($myform->generate_insert_SQL());
                $msg = "Thêm Block thành công";
            }else{
               $err = "Xảy ra lỗi trong quá trình thêm dữ liệu";
            }
        }else{
            $err = "Nội dung không được để trống";
        }
    break;

    case "addblockintabquesrecording":
        $tab_id = getValue("tab_id","int","POST",0);
        $blockname = getValue("blockname","str","POST",0);
        $com_block_data_type = "question_recording";

        if($blockname != ""){
            $myform = new generate_form();
            $myform->add("com_block_tab_id" ,"tab_id" , 1 , 1 , 0 , 1,"" , 0 , "");
            $myform->add("com_block_data_type" , "com_block_data_type" , 0 , 1 , "" , 1,"" , 0 , "");
            $myform->add("com_block_data_name" , "blockname" , 0 , 1 , "" , 1,"" , 0 , "");
            $myform->add("com_block_data_order" , "com_block_data_order" , 0 , 1 , "" , 1,"" , 0 , "");
            if($fs_errorMsg == ""){
                $myform->addTable("courses_multi_tabs_block");
                $myform->removeHTML(0);
                $db_insert  = new db_execute_return();
                $last_exe_id = $db_insert->db_execute($myform->generate_insert_SQL());
                $msg = "Thêm Block thành công";
            }else{
               $err = "Xảy ra lỗi trong quá trình thêm dữ liệu";
            }
        }else{
            $err = "Nội dung không được để trống";
        }
    break;

    case "addblockintabqueswriting":
        $tab_id = getValue("tab_id","int","POST",0);
        $blockname = getValue("blockname","str","POST",0);
        $com_block_data_type = "question_writing";

        if($blockname != ""){
            $myform = new generate_form();
            $myform->add("com_block_tab_id" ,"tab_id" , 1 , 1 , 0 , 1,"" , 0 , "");
            $myform->add("com_block_data_type" , "com_block_data_type" , 0 , 1 , "" , 1,"" , 0 , "");
            $myform->add("com_block_data_name" , "blockname" , 0 , 1 , "" , 1,"" , 0 , "");
            $myform->add("com_block_data_order" , "com_block_data_order" , 0 , 1 , "" , 1,"" , 0 , "");
            if($fs_errorMsg == ""){
                $myform->addTable("courses_multi_tabs_block");
                $myform->removeHTML(0);
                $db_insert  = new db_execute_return();
                $last_exe_id = $db_insert->db_execute($myform->generate_insert_SQL());
                $msg = "Thêm Block thành công";
            }else{
               $err = "Xảy ra lỗi trong quá trình thêm dữ liệu";
            }
        }else{
            $err = "Nội dung không được để trống";
        }
    break;

    case "addblockintabquesmultiplechoice":
        $tab_id = getValue("tab_id","int","POST",0);
        $blockname = getValue("blockname","str","POST",0);
        $com_block_data_type = "question_multiplechoice";

        if($blockname != ""){
            $myform = new generate_form();
            $myform->add("com_block_tab_id" ,"tab_id" , 1 , 1 , 0 , 1,"" , 0 , "");
            $myform->add("com_block_data_type" , "com_block_data_type" , 0 , 1 , "" , 1,"" , 0 , "");
            $myform->add("com_block_data_name" , "blockname" , 0 , 1 , "" , 1,"" , 0 , "");
            $myform->add("com_block_data_order" , "com_block_data_order" , 0 , 1 , "" , 1,"" , 0 , "");
            if($fs_errorMsg == ""){
                $myform->addTable("courses_multi_tabs_block");
                $myform->removeHTML(0);
                $db_insert  = new db_execute_return();
                $last_exe_id = $db_insert->db_execute($myform->generate_insert_SQL());
                $msg = "Thêm Block thành công";
            }else{
               $err = "Xảy ra lỗi trong quá trình thêm dữ liệu";
            }
        }else{
            $err = "Nội dung không được để trống";
        }
    break;

    default:

    break;
}

//$json['msg'] = $msg;
//$json['err'] = $err;
//echo json_encode($json);
if($err == ''){
    echo '1';
}else{
    echo '0';
}
?>