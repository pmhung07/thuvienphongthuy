<?php
function lesson_main_edit($unit,$unit_num,$unit_name){
    $var_path_js     = '/themes/js/';
    $var_path_css    = '/themes/css/';
    $var_path_media  = '/mediaplayer/';
    $base_url        =  $_SERVER['HTTP_HOST'];
    $var_head_lib2   = '<link rel="stylesheet" type="text/css" href="'.$var_path_css.'jquery-ui-1.8.16.custom.css" />';
    $var_head_lib2  .= '<script type="text/javascript" src="'.$var_path_js.'jquery.ui.js"></script>';
    $var_head_lib2  .= '<script type="text/javascript" src="'.$var_path_js.'jquery.editinplace.js"></script>';
    $var_head_lib2  .= '<script type="text/javascript" src="'.$var_path_js.'jquery.ui.core.js"></script>';
    $var_head_lib2  .= '<script type="text/javascript" src="'.$var_path_js.'jquery.ui.widget.js"></script>';
    $var_head_lib2  .= '<script type="text/javascript" src="'.$var_path_js.'jquery.ui.mouse.js"></script>';
    $var_head_lib2  .= '<script type="text/javascript" src="'.$var_path_js.'jquery.ui.draggable.js"></script>';
    $var_head_lib2  .= '<script type="text/javascript" src="'.$var_path_js.'jquery.ui.droppable.js"></script>';
    $var_head_lib2  .= '<script type="text/javascript" src="'.$var_path_js.'slimScroll.min.js"></script>';

    $var_head_lib2  .= '<script type="text/javascript" src="'.$var_path_media.'jwplayer.js"></script>';
    $var_head_lib2  .= '<script type="text/javascript">jwplayer.key="IyBF3HN/WxYyCXbdjRCOrUH3C4FJGuzHP9SQ6mz/YQcKlam8eP/Fvm6VM6g=";</script>';

    $iUnit      = getValue("iunit","int","POST","");
    $unit       = getValue("unit","int","POST","");
    $url        = getValue("url","str","POST","");
    $sqlCou     = new db_query("SELECT * FROM courses,courses_multi WHERE courses.cou_id = courses_multi.com_cou_id AND courses_multi.com_id = ".$unit);
    $rowCou     = mysqli_fetch_assoc($sqlCou->result);
    $iCou       = $rowCou['cou_id'];
    $nCou       = $rowCou['cou_name'];
    unset($sqlCou);

    $nAns       = getValue("nAns","int","POST","");
    $urlPoint   = getValue("urlPoint","str","POST","");

    $strAns     = explode("&",$urlPoint);
    $countans   = count($strAns);
    for($j=0;$j < $countans ;$j++){
        $idAns[$j+1] = $strAns[$j];
    }

    $ans        = array();
    if($nAns!=0){
        for($i = 1; $i <= $nAns; $i++){
            $ans[$i]         = 0;
            if($idAns[$i]!= 0){
                $sqlAns          = new db_query('SELECT * FROM answers WHERE ans_id ='.$idAns[$i]);
                while($rowAns    = mysqli_fetch_assoc($sqlAns->result)){
                    $ans[$i]     = $rowAns["ans_true"];
                }
            }
        }
    }
    $sqlIunit         = "";
    $sqlIunit         = new db_query('SELECT * FROM lesson_details WHERE les_det_type = 2 AND les_com_id ='.$unit);
    while($rowIunit   = mysqli_fetch_assoc($sqlIunit->result)){
        $iUnitGram    = $rowIunit['les_det_id'];
    }

    //Lấy thông tin dạng bài học
    $sqlUnitMail = new db_query('SELECT * FROM lesson_details WHERE les_det_type = 1 AND les_com_id ='.$unit);
    $rowUnitMail = mysqli_fetch_assoc($sqlUnitMail->result);
    $iUnit       = $rowUnitMail['les_det_id'];
    unset($sqlUnitMail);
    //Lấy nội dung bài học và bài tập
    $sqlMain    = new db_query('SELECT * FROM main_lesson WHERE main_det_id = '.$iUnit .' ORDER BY main_order');
    $sqlQuick   = new db_query('SELECT * FROM exercises WHERE exe_type = 1 AND exe_type_lesson = 1 AND exe_com_id = '.$unit); ?>
    <?=$var_head_lib2?>
    <div class="in_content_v2">
       	<div class="lesson-content-left">
       		<h2 class="lesson-content-title" title="Bài <?=$unit_num?>: <?=$unit_name?> - Bài chữa">
       			Bài <?=$unit_num?>: <?=$unit_name?> - Bài chữa
       		</h2>
       	</div>
       	<div class="lesson-content-right">
       		<div class="gray-box1" style="">
                <?php
                $in = 0;
                while($rowQuick  = mysqli_fetch_assoc($sqlQuick->result)){
                    $sqlQues     = new db_query('SELECT * FROM questions WHERE que_exe_id = '.$rowQuick["exe_id"]);
                    while($rowQues = mysqli_fetch_assoc($sqlQues->result)){
                        if($rowQues['que_type']== 1 ){
                            $in ++;
                            echo '<div style="overflow: hidden;margin-top: 10px;">'; ?>
                            <h4 class="cau_hoi"><?=$in?>.<?php echo $rowQues['que_content'] =   str_replace ('&&', '<br />', $rowQues['que_content']);  ?></h4>
                            <?php
                            $sqlAns    = new db_query('SELECT * FROM answers WHERE ans_ques_id = '.$rowQues['que_id']);
                            $arrayT    = array(1=>'A',2=>'B',3=>'C',4=>'D',5=>'E');
                            $iA        = 0;
                            while($rowAns = mysqli_fetch_assoc($sqlAns->result)){
                            $iA ++; ?>
                            <span class="check_box" style="float: left;width:100%;margin: 4px 2px;">
                                <input style="float: left;" id="checke<?=$in?>_<?=$iA?>" name="chec_box<?=$in?>" type="radio" value="<?=$rowAns['ans_id']?>" />
                                <label style="float: left;margin: 0 7px; cursor: pointer;<?php if($rowAns['ans_id'] == $idAns[$in]) {echo 'color:red;font-weight: bold;';} if($rowAns['ans_true'] == '1'){ echo 'color:#33B3A6;font-weight: bold;';} ?>" for="checke<?=$in?>_<?=$iA?>"><?=$arrayT[$iA]?>.<?=$rowAns['ans_content']?></label>
                            </span>
                            <?php }
                         echo '</div>';  } ?>
                   <?php }unset($sqlQues); ?>
                <?php }unset($sqlQuick); ?>
       		</div>
       	</div>
        <script>
        $(document).ready(function(){
            $(".icon_quiz_lb_v2").toggle(function(){
            $(".gray-box1").show(200);
            },function(){
                $(".gray-box1").hide(100);
            });
        })
        </script>
        <script type="text/javascript">
        $(document).ready(function() {
            var baseurl =  'http://<?=$base_url?>';
            $('.pull-right').click(function(){
                var urlQuick = "";
                <?php for($ii = 1; $ii<= $in ; $ii ++){ ?>
                    var varValue<?=$ii?> = $('.check_box input[name=chec_box<?=$ii?>]:checked').val();
                    urlQuick += 'idAns<?=$ii?>='+varValue<?=$ii?>+'&';
                <?php } ?>
                $.fancybox({
                   'type'   : 'ajax',
                   'href'   :  baseurl+ '/ajax/ajax_point_main_v2.php?iunit=<?=$iUnit?>&unit=<?=$unit?>&nAns=<?=$in?>&' + urlQuick,
                });
            });
        });
        </script>
    </div>
<?php } ?>