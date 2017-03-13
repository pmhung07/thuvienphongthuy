<?
function lesson_grammar_edit($unit,$unit_num,$unit_name){
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


    //Lấy thông tin dạng bài học
    $sqlUnitMail = new db_query('SELECT * FROM lesson_details WHERE les_det_type = 2 AND les_com_id ='.$unit);
    $rowUnitMail = mysqli_fetch_assoc($sqlUnitMail->result);
    $iUnit       = $rowUnitMail['les_det_id'];
    unset($sqlUnitMail);

    $type    = "";
    $javaStr = "";

    $iUnit      = getValue("iunit","int","POST","");
    $unit       = getValue("unit","int","POST","");
    $url        = getValue("url","str","POST","");

    $sqlCou     = new db_query("SELECT * FROM courses,courses_multi WHERE courses.cou_id = courses_multi.com_cou_id AND courses_multi.com_id = ".$unit);
    $rowCou     = mysqli_fetch_assoc($sqlCou->result);
    $iCou       = $rowCou['cou_id'];
    $nCou       = $rowCou['cou_name'];
    unset($sqlCou);

    $num        = getValue("num","int","POST","");
    $nAns       = getValue("nAns","int","POST","");
    $type       = getValue("type","int","POST","");
    $urlPoint   = getValue("urlPoint","str","POST","");
    $ans        = array();
    if($type == 1){
        if($nAns!=0){
           	$strAns     = explode("&",$urlPoint);
           	$countans   = count($strAns);
            for($j=0;$j < $countans ;$j++){
           	   $idAns[$j+1] = $strAns[$j];
           	}
            for($i = 1; $i <= $nAns; $i++){
                $ans[$i]         = 0;
                if($idAns[$i]!=0){
                    $sqlAns          = new db_query("SELECT * FROM answers WHERE ans_id =".$idAns[$i]);
                    while($rowAns    = mysqli_fetch_assoc($sqlAns->result)){
                        $ans[$i]     = $rowAns["ans_true"];
                    }
                }
            }
        }
    }else{
        $strAns     = explode("&&",$urlPoint);
        $countans   = count($strAns);
        for($j=0;$j < $countans ;$j++){
            $value[$j+1] = $strAns[$j];
        }
    }
   $sqlGram    = new db_query('SELECT * FROM grammar_lesson WHERE gram_det_id = '.$iUnit.' ORDER BY gram_order ASC');
   $sqlQuick   = new db_query('SELECT * FROM exercises WHERE exe_type = 1 AND exe_type_lesson = 2 AND exe_com_id = '.$unit); ?>
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
                echo '<form name="quiz" id="frm_quiz">';
                $sqlQues     = new db_query('SELECT * FROM questions WHERE que_exe_id = '.$rowQuick["exe_id"]);
                if($nAns!=0){
               	    $strAns     = explode("&",$urlPoint);
               	    $countans   = count($strAns);
                    for($j=0;$j < $countans ;$j++){
               	        $idAns[$j+1] = $strAns[$j];
               	    }
                    for($i = 1; $i <= $nAns; $i++){
                        $ans[$i]         = 0;
                        if($idAns[$i]!=0){
                            $sqlAns          = new db_query('SELECT * FROM answers WHERE ans_id ='.$idAns[$i]);
                            while($rowAns    = mysqli_fetch_assoc($sqlAns->result)){
                                $ans[$i]     = $rowAns["ans_true"];
                            }
                        }
                    }
                }
                while($rowQues = mysqli_fetch_assoc($sqlQues->result)){
                    $type = $rowQues['que_type'];
                    $in ++;
                    if($rowQues['que_type']== 1 ){
                        echo '<div>'; ?>
                        <h4 class="cau_hoi"><?=$in?>.<?php echo $rowQues['que_content'] =   str_replace ('&&', '<br />', $rowQues['que_content']);  ?></h4>
                        <?php
                        $sqlAns    = new db_query('SELECT * FROM answers WHERE ans_ques_id = '.$rowQues["que_id"]);
                        $arrayT    = array(1=>'A',2=>'B',3=>'C',4=>'D',5=>'E');
                        $iA        = 0;
                        while($rowAns = mysqli_fetch_assoc($sqlAns->result)){
                        $iA ++; ?>
                        <span class="check_box">
                            <input id="checke<?=$in?>_<?=$iA?>" name="chec_box<?=$in?>" type="radio" value="<?=$rowAns['ans_id']?>" />
                            <label style="<?php if($rowAns['ans_id'] == $idAns[$in]) {echo 'color:red;font-weight: bold;';} if($rowAns['ans_true'] == '1'){ echo 'color:#33B3A6;font-weight: bold;';} ?>" for="checke<?=$in?>_<?=$iA?>"><?=$arrayT[$iA]?>.<?=$rowAns['ans_content']?></label>
                        </span>
                        <?php } echo '</div>';
                    }elseif ($rowQues['que_type']== 3){ ?>
						<?php
						$arrayAns  = getStringAns($rowQues['que_content']);
						$result    = count($arrayAns);
						$rand_keys = array_random($arrayAns, $result); ?>
						&nbsp;
						<ul class="menu_quiz">
							<?php for($i=0;$i<$result;$i++){?>
                            <a href="#" ><?=$i+1?>.<span id="draggable<?=$i+1?>"><?=trim($rand_keys[$i])?></span></a>
							<?php } ?>
						</ul>
					    <p class="text_content_lightbox">
					    <?php
                        $arrayCont  =  getMainC($rowQues['que_content']);
                        $cArrayCont =  count($arrayCont);
                        $j = 0;
                        for($i=0;$i<$cArrayCont;$i++){
                            if($i%2 != 0) {
                                $j ++;
                                $value[$j] = str_replace ('_', ' ', $value[$j]);
                                echo '<span id="droppable'.@$j.'"><span class="ans">'.$value[$j].'</span>..<span class="anstrue">('.$arrayAns[$j-1].')</span></span>';
                            }else{
                                echo $arrayCont[$i];
                            }
                        } ?>
						</p>
                    <?php }elseif( $rowQues['que_type']== 2 ){
                        $arrayCont  =  getMainC($rowQues['que_content']);
						$cArrayCont =  count($arrayCont); ?>
                        <!--  bắt đầu hiển thị nội dung quick dạng điền từ -->
                        <div class="text_bot_right_vocabulary">
                            <h4 class="cau_hoi"><?=$in?>. Điền từ vào chỗ trống</h4>
                            <br />
                            <?php
                            $j = 0;
                            for($i=0;$i<$cArrayCont;$i++){
                                if($i%2 != 0) {
                                    $j ++;
                                    $value[$j] = str_replace ('_', ' ', $value[$j]);
                                    echo '&nbsp;<span style="color:red;font-weight: bold;">'.$value[$j].'</span>&nbsp;&nbsp;<span style="color:#33B3A6;font-weight: bold;">('.$arrayCont[$i].')</span>&nbsp;&nbsp;';
                                }else{
                                    echo $arrayCont[$i];
                                }
                            } ?>
                        </div>
                    <?php } ?>
                <?php }unset($sqlQues); ?>
            <?php echo '</form>'; ?>
        <?php }unset($sqlQuick); ?>
   		</div>
        <script type="text/javascript">
   		$(document).ready(function(){
   		   var $urlPoint = "";
   		   var baseurl = 'http://<?=$base_url?>';
   		   <?php
   			if($type == 3){
   				for($i=1;$i<=$j;$i++){ ?>
      			var valuePoint= [];
      			$( "#draggable<?=$i?>" ).draggable({  appendTo: "body",helper: "clone"});
      			$( "#droppable<?=$i?>" ).droppable({
      				activeClass: "ui-state-hover",
      				hoverClass: "ui-state-active",
      				drop: function( event, ui ) {
      					$( this ).addClass( "ui-state-highlight" );
      					$( this ).find( ".dotset" ).remove();
      					valuedrop<?=$i?> = ui.draggable.text();
      					valuePoint[<?=$i?>] = valuedrop<?=$i?>.replace(/\s+/g, '_');
      					$urlPoint   +=  "value<?=$i?>=" + valuePoint[<?=$i?>] + "&";
      					$( this ).find( ".text-ct" ).remove();
      					$( "<span class='text-ct' style='padding: 2px 5px;border: 1px dotted #999;color:red;font-weight: bold;'></span>" ).text( ui.draggable.text() ).appendTo( this );
      				}
      			});
   			<?php } } ?>

            <?php
			if($type == 1){
				for($ii = 1; $ii<= $in ; $ii ++){ ?>
				var varValue<?=$ii?> = $('.check_box input[name=chec_box<?=$ii?>]:checked').val();
				$urlPoint += 'idAns<?=$ii?>='+varValue<?=$ii?>+'&';
			    <?php } ?>
			<?php }elseif($type == 2){
				for($i=1;$i<=$j;$i++){
				$javaStr .= '#editme'.$i.','; ?>
				var str<?=$i?>    = $('#editme<?=$i?>').text().replace(/\s+/g, '_');
				$urlPoint += "value<?=$i?>=" + str<?=$i?> + "&";
			<?php } } ?>

            $(document).ready(function() {
                var baseurl =  'http://<?=$base_url?>';
                $('.pull-right').click(function(){
                    <?php
      				if($type == 1){
      					 for($ii = 1; $ii<= $in ; $ii ++){ ?>
      					 var varValue<?=$ii?> = $('.check_box input[name=chec_box<?=$ii?>]:checked').val();
      					 $urlPoint += 'idAns<?=$ii?>='+varValue<?=$ii?>+'&';
      				<?php }
      				}elseif($type == 2){
      					 for($i=1;$i<=$j;$i++){
      					 $javaStr .= '#editme'.$i.','; ?>
      					 var str<?=$i?>    = $('#editme<?=$i?>').text().replace(/\s+/g, '_');
      					 $urlPoint += "value<?=$i?>=" + str<?=$i?> + "&";
      				<?php } } ?>
                    $.fancybox({
                        'type'   : 'ajax',
                        'href'   :  baseurl+ '/ajax/ajax_point_gram_v2.php?iunit=<?=$iUnit?>&unit=<?=$unit?>&nAns=<?php if ($type == 1) { echo $in; }else{ echo @$j; }?>&type=<?=$type?>&' + $urlPoint,
                    });
                });
            });
   		});
   		</script>
   	</div>
    <?php if ($type == 2 ){ ?>
        <script type="text/javascript">
        $(document).ready(function(){
            $("<?=$javaStr?>").editInPlace({
                saving_animation_color: "lime",
                value_required        :	true,
                callback: function(idOfEditor, enteredText, orinalHTMLContent, settingsParams, animationCallbacks) {
               	    animationCallbacks.didStartSaving();
               	    setTimeout(animationCallbacks.didEndSaving, 2000);
               	    return enteredText;
                }
         	});
        });
        </script>
    <?php } ?>
</div>
<div id="fade" class="black_overlay"></div>
<?php } ?>