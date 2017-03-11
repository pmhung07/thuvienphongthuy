<?php
    $dbthuong = new db_query("SELECT * FROM listarm");
    $arrthuong = $dbthuong->resultArray();

?>
<div class="user-manager-info">
    <div class="block-content-show-content">
        <div class="list_student_details" style="float:none;">
            <div class="list_student_details_head">
                <div class="list_student_details_head_col_1">ID</div>
                <div class="list_student_details_head_col_2">Các cấp huy hiệu trên ham học</div>
                <div class="list_student_details_head_col_3">Tên</div>
                <div class="list_student_details_head_col_4">Exp</div>
            </div>
            <?php
            $i = 1;
            foreach($arrthuong as $keyu => $valu){
            ?>
            <div class="list_student_details_head">
                <div class="list_student_details_head_col_show_1"><?=$i?></div>

                <div class="list_student_details_head_col_show_2" style="height:30px;">
                    <img style="width:30px;height:30px;" src="http://<?=$base_url?>/pictures/arm/<?=$valu['listarm_img']?>">
                </div>

                <div class="list_student_details_head_col_show_3">
                    <? 
                        echo $valu['listarm_name'];
                    ?>
                </div>
                <div class="list_student_details_head_col_show_4">
                    <? 
                        echo $valu['listarm_exp'];
                    ?>
                </div>
            </div>
            <?php $i++;} ?>
        </div>
        <div class="listtoolcac" style="margin-top: 10px;
  background-color: rgb(245, 217, 200);
  padding: 10px;
  overflow: hidden;font-size: 13px;">Điểm kinh nghiệm của bạn: <?=$myuser->use_ex?></div>
        <?php
        $choosearm = 0;
        $armname = '';
        $armimg = '';
        $db_listarm = new db_query("SELECT * FROM listarm WHERE listarm_exp < ".$myuser->use_ex);
        $arr_listarm = $db_listarm->resultArray();

        if(count($arr_listarm) > 0){
            foreach($arr_listarm as $keyarm => $valuearm){
                if($valuearm['listarm_exp'] > $choosearm){
                    $choosearm = $valuearm['listarm_exp'];
                    $armname = $valuearm['listarm_name'];
                    $armimg = $valuearm['listarm_img'];
                }elseif($valuearm['listarm_exp'] < $choosearm || $valuearm['listarm_exp'] == 0){
                    $armname = 'Chưa có huy hiệu';
                }
            }
        }else{
            $armname = 'Chưa có huy hiệu';
        }
        ?>
        <div class="listtoolcac" style=" margin-top: 10px;
  background-color: rgb(99, 206, 215);
  padding: 10px;
  overflow: hidden;font-size: 13px;">Huy hiệu của bạn: <?=$armname?></div>

         <div class="list_student_details" style="margin-top:10px;">
            <div class="list_student_details_head">
                <div class="list_student_details_head_col_1">ID</div>
                <div class="list_student_details_head_col_2" style="background:#961919;">Lịch sử cộng điểm</div>
                <div class="list_student_details_head_col_3">Thời gian</div>
                <div class="list_student_details_head_col_4">Exp</div>
            </div>
        </div>

    </div>
</div>