<?php
	require_once("../home/config.php");
    $json = array();
    $json['error'] = "";
    $type        = $_REQUEST['type'];
    $id          = $_REQUEST['id'];
    $input       = $_REQUEST['input'];
    @$script      = $_REQUEST['script'];  
	$db_execute		  = new db_execute_return();
	if ($type == "write"){
        if($input !=""){
            $check_user_write = check_user_write($myuser->u_id,$id);
            if($check_user_write == 0){
            $r_id = $db_execute->db_execute("INSERT INTO learn_writing_result(lwr_use_id,lwr_wri_id,lwr_content,lwr_date)
                                             VALUES(
                                              " . $myuser->u_id . "
                                             ," . $id . "
                                             ,'" . $input . "'
                                             ,'" . time() . "'
                                             )", __FILE__ . " Line: " . __LINE__);
            //Cong diem cho user khi hoan thanh lesson                            
            }else{
                $json['error']  .= "Bạn đã hoàn thành bài viêt này ! Giáo viên sẽ chấm điểm cho bạn trong thời gian sớm nhất. Xin chân thành cảm ơn";
		        $json['suc']     = "0";
            }
        }else{
            $json['error']  .= "Bài làm không được để trống!";
		    $json['suc']     = "0";
        }
	}elseif($type == "speak"){
	    $check_user_speak = check_user_speak($myuser->u_id,$id);
        if($check_user_speak == 0){
       		$r_id	          = $db_execute->db_execute("INSERT INTO learn_speak_result(lsr_use_id,lsr_spe_id,lsr_audio,lsr_date,lsr_user_script)
       																   VALUES(
       																	 " . $myuser->u_id . "
       																	," . $id . "
       																	,'" . $input . "'
       																	,'" . time() . "'
                                                                        ,'" .$script. "'
       																	)", __FILE__ . " Line: " . __LINE__);
       		$audio     = explode("|",$input);
       		$count     = count($audio);
            //Cong diem cho user khi hoan thanh lesson
        }else{
            $json['error']  .= "Bạn đã hoàn thành bài nói này ! Hãy xem kết quả ở bên dưới.";
	        $json['suc']     = "0";
        }
		for($i=0;$i < $count - 1 ;$i++){  															
			if (copy("../js/data_record/".trim($audio[$i]),"../js/data_record/record/".trim($audio[$i]))) {
			    unlink("../js/data_record/".trim($audio[$i]));
			}
		}
	}
    unset($db_execute);
	if(@$r_id	 > 0){
		//không có lỗi sảy ra
		$json['suc']     = "1";
		$json['error']  .= "Chúc mừng bạn đã gửi bài thành công.Kết quả của bạn sẽ được chúng tôi gửi lại sớm nhất.";
	}
	echo json_encode($json);
?>
