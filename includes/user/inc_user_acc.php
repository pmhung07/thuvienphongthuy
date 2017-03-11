<?php
    $dbthuong = new db_query("SELECT * FROM user_payment_log WHERE upaylog_user_id =".$myuser->u_id);
    $arrthuong = $dbthuong->resultArray();

?>
<div class="user-manager-info">
    <div class="block-content-show-content">
        <div class="listtoolcac" style="margin-top: 10px;background-color: rgb(234, 233, 233);padding: 10px;overflow: hidden;font-size: 13px;">Tài khoản bạn hiện có: <span style="color:red;"><?=format_number($myuser->user_wallet)?></span> vnđ</div>

         <div class="list_student_details" style="margin-top:10px;">
            <div class="list_student_details_head">
                <div class="list_student_details_head_col_1">ID</div>
                <div class="list_student_details_head_col_2" style="background:#961919;width:47.5%;">Nội dung lịch sử giao dịch</div>
                <div class="list_student_details_head_col_3" style="width:47.5%;">Thời gian</div>
            </div>
            <? foreach($arrthuong as $key => $value){ ?>
            <div class="list_student_details_head">
                <div class="list_student_details_head_col_show_1"><?=$i?></div>
                <div class="list_student_details_head_col_show_3">
                    <? 
                        echo $value['upaylog_info_description'];
                    ?>
                </div>
                <div class="list_student_details_head_col_show_4">
                    <? 
                        echo date('d/m/Y h:i:s',$value['upaylog_date']);
                    ?>
                </div>
            </div>
            <?}?>

        </div>

    </div>
</div>