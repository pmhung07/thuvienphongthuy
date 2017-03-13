<?php
require_once("../home/config.php");

$iTab = getValue('iTab','int','POST',0);
$action = getValue('action','str','POST','');
$faq = getValue('faq','str','POST','',2);
$res = array();
$typetbl = "thanks";
switch($action) {
    case 'add_ques' :
    if($myuser->u_id) {
        $db_last_post  = new db_query('SELECT que_date
                                         FROM faq_questions
                                         WHERE 1 AND que_type LIKE "thanks" AND que_tab_id ='.$iTab.'
                                         ORDER BY que_date DESC
                                         LIMIT 1');
        $last_time = mysqli_fetch_assoc($db_last_post->result);
        $first_time = $last_time['que_date'];
        $check_time = time() - $first_time;
        if($check_time >= 60){
            if(strlen($faq) > 10) {
                    $faq_date = time();
                    $db_faq = new db_execute('INSERT INTO
                                                faq_questions(que_user_id,
                                                        que_tab_id,
                                                        que_content,
                                                        que_date,
                                                        que_type)
                                                 VALUES('.$myuser->u_id.',
                                                        '.$iTab.',
                                                        "'.$faq.'",
                                                        '.$faq_date.',
                                                        "'.$typetbl.'")');
                    if($db_faq->total == 1) {
                        $res['success'] = 1;
                        $res['html'] = '<h3 class="first_content_ques"><span>'.$myuser->use_name.': </span>'.$faq.'</h3>';
                    }else {
                        $res['success'] = 0;
                        $res['html'] = '<script>alert("Có lỗi xảy ra")</script>';
                    }

            }
            else {
                $res['success'] = -1;
                $res['html'] = '<script>alert("Độ dài câu hỏi phải lớn hơn 10 ký tự")</script>';
            }
        }else{
            $res['success'] = -2;
            $res['html'] = '<script type="text/javascript">alert("Hỏi đáp mới phải cách hỏi đáp cũ ít nhất 1 phút")</script>';
        }
    }
    else {
        $res['success'] = -2;
        $res['html'] = '<script type="text/javascript">alert("Bạn chưa đăng nhập, vui lòng đăng nhập để gửi câu hỏi !")</script>';
    }
    echo json_encode($res);
    break;

    // gửi trả lời
    case 'add_ans':
    $ques_id = getValue('ques_id','int','POST',0);
    $ans = getValue('ans','str','POST','',2);
    $user_id = idFaq_rerult($ques_id);
    if($myuser->u_id) {
        if(strlen($ans) > 10) {
            $db_ans = new db_execute_return();
            $last_ans_id = $db_ans->db_execute('INSERT INTO
                                                 faq_answers(ans_user_id,
                                                         ans_question_id,
                                                         ans_content,
                                                         ans_date)
                                                  VALUES('.$myuser->u_id.',
                                                         '.$ques_id.',
                                                         "'.$ans.'",
                                                         '.time().')');
            unset($db_ans);
            if($last_ans_id != 0) {
                $res['success'] = 1;
                $res['html'] = '<h3 class="content_child"><span>'.$myuser->use_name.': </span>'.$ans.' </h3>';

                if($myuser->u_id != $user_id){
                  $db_user = new db_query("SELECT use_id,use_name,use_email FROM users WHERE use_id = ".$user_id);
                  $row_user = mysqli_fetch_assoc($db_user->result);
                  $user_name = $row_user['use_name'];
                  unset($db_user);
                  //==========================//
                }
            }else {
                $res['success'] = 0;
                $res['html'] = '<script>alert("Có lỗi xảy ra")</script>';
            }
        }
        else {
            $res['success'] = -1;
            $res['html'] = '<script>alert("Độ dài câu trả lời phải lớn hơn 10 ký tự")</script>';
        }
    }
    else {
        $res['success'] = -2;
            $res['html'] = '<script type="text/javascript">alert("Bạn chưa đăng nhập, vui lòng đăng nhập để gửi câu trả lời !")</script>';
    }
    echo json_encode($res);
    break;

    // load câu hỏi, phân trang câu hỏi
    case 'control':
    $res['html'] = '';
    $page = getValue('page','int','POST',1);
    $page = ($page >= 2) ? $page : 1;
    $rows_per_page = 8;
    $page_start = ($page - 1) * $rows_per_page;
    $page_end = $page * $rows_per_page;

    $db_ques = new db_query('SELECT que_id,que_user_id,que_content,que_date,que_active,use_id,use_name
                                 FROM faq_questions
                                 LEFT JOIN users ON use_id = que_user_id
                                 WHERE 1 AND que_type LIKE "thanks" AND que_tab_id ='.$iTab.'
                                 ORDER BY  que_date DESC
                                 LIMIT '.$page_start . ', '. $rows_per_page);
    $res_ques = $db_ques->resultArray();
    unset($db_ques);
    foreach($res_ques as $ques) {
        $db_count_ans = new db_count('SELECT count(*) as count FROM faq_answers WHERE ans_question_id = '.$ques['que_id']);
        $count_ans = $db_count_ans->total;
        unset($db_count_ans);
        $ans_class ='';
        if($count_ans > 0) $ans_class = 'load_ans';
        $res['html'] .= '<li data-id="'.$ques["que_id"].'" class="nums_question">
                			<h3 class="first_content_ques"><span>'.$ques["use_name"].': </span>'.$ques["que_content"].'</h3>
                			<div class="det_content_ques">
                				<a class="'.$ans_class.'" data-page="0" href="javascript:void();"><img src="/themes_v2/images/community/icon_comunity.png" alt="icon_comunity"> '.$count_ans.'</a>
                				<span>'.date("H:i - d/m/y",$ques["que_date"]).'</span>
                				<a href="javascript:void();" class="icon_reply"><img src="/themes/img/community/icon_reply.png" alt="icon_reply"></a>
                			</div>
                            <div class="content_reply"></div>
                            <div class="reply_ques">
                				<img src="/themes_v2/images/community/icon_answers.png" style="float: left; margin-top: 10px; margin-left: 6px;" alt="icon_answers">
                				<input type="text" name="content_ans" id="content_ans" class="content_ans" placeholder="Trả lời">
                			</div>
                		</li>';
    }
    echo json_encode($res);
    break;

    // load trả lời
    case 'load_ans':
    $res['html'] = '';
    $ques_id = getValue('ques_id','int','POST',0);
    //$page = getValue('page','int','POST',1);
//    $page = ($page >= 2) ? $page : 1;
//    $rows_per_page = 5;
//    $page_start = ($page - 1) * $rows_per_page;
//    $page_end = $page * $rows_per_page;

    $db_list_ans = new db_query('SELECT ans_id,ans_user_id,ans_question_id,ans_content,ans_date,ans_active,use_id,use_name
                                 FROM faq_answers
                                 LEFT JOIN users ON use_id = ans_user_id
                                 WHERE ans_question_id ='.$ques_id.'
                                 ORDER BY ans_date');
    $list_ans = $db_list_ans->resultArray();
    unset($db_list_ans);
    if(count($list_ans) > 0) {
        foreach($list_ans as $ans) {
            $res['html'] .= '<h3 class="content_child"><span>'.$ans['use_name'].': </span>'.$ans['ans_content'].'</h3>';
        }
    }
    else
        $res['html'] .= '<script>alert("Đã hết bình luận")</script>';
    echo json_encode($res);
    break;

    // load trả lời
    case 'load_ans_pre':
    $res['html'] = '';
    $ques_id = getValue('ques_id','int','POST',0);
    $total_ans = getValue('total_ans','int','POST',0);

    $db_list_ans = new db_query('SELECT ans_id,ans_user_id,ans_question_id,ans_content,ans_date,ans_active,use_id,use_name
                                 FROM faq_answers
                                 LEFT JOIN users ON use_id = ans_user_id
                                 WHERE ans_question_id ='.$ques_id.'
                                 ORDER BY ans_date
                                 LIMIT 2');
    $list_ans = $db_list_ans->resultArray();
    unset($db_list_ans);
    if(count($list_ans) > 0) {
        foreach($list_ans as $ans) {
            $res['html'] .= '<h3 class="content_child"><span>'.$ans['use_name'].': </span>'.$ans['ans_content'].'</h3>';
        }
        if($total_ans > 2) $res['html'] .= '<a href="javascript:void();" style="font-size: 12px; text-align:center;" class="load_ans_next">Xem thêm bình luận</a>';
    }
    else
        $res['html'] .= '<p style="font-size: 11px;">Chưa có bình luận nào !</p>';
    echo json_encode($res);
    break;

    // load trả lời
    case 'load_ans_next':
    $res['html'] = '';
    $ques_id = getValue('ques_id','int','POST',0);

    $db_list_ans = new db_query('SELECT ans_id,ans_user_id,ans_question_id,ans_content,ans_date,ans_active,use_id,use_name
                                 FROM faq_answers
                                 LEFT JOIN users ON use_id = ans_user_id
                                 WHERE ans_question_id ='.$ques_id.'
                                 ORDER BY ans_date
                                 LIMIT 2,100');
    $list_ans = $db_list_ans->resultArray();
    unset($db_list_ans);
    if(count($list_ans) > 0) {
        foreach($list_ans as $ans) {
            $res['html'] .= '<h3 class="content_child"><span>'.$ans['use_name'].': </span>'.$ans['ans_content'].'</h3>';
        }
    }
    else
        $res['html'] .= '<p style="font-size: 11px;">Đã hết bình luận !</p>';
    echo json_encode($res);
    break;
}

?>
