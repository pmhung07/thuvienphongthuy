<?php
function lesson_main($unit,$unit_num,$unit_name){
    $myuser          = new user('','');
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
    $sqlUnitMail = new db_query('SELECT * FROM lesson_details WHERE les_det_type = 1 AND les_com_id ='.$unit);
    $rowUnitMail = mysql_fetch_assoc($sqlUnitMail->result);
    $iUnit       = $rowUnitMail['les_det_id'];
    unset($sqlUnitMail);
    //Lấy nội dung bài học và bài tập
    $sqlMain    = new db_query('SELECT * FROM main_lesson WHERE main_det_id = '.$iUnit .' ORDER BY main_order');
    $sqlQuick   = new db_query('SELECT * FROM exercises WHERE exe_type = 1 AND exe_type_lesson = 1 AND exe_com_id = '.$unit);
?>
    <?=$var_head_lib2?>
    <div class="in_content_v2">
       	<div class="lesson-content-left">
       		<h2 class="lesson-content-title" title="Bài <?=$unit_num?>: <?=$unit_name?>">
       			Bài <?=$unit_num?>: <?=$unit_name?>
       		</h2>
       	</div>
        <div class="clearfix"></div>
        <ul class="nav nav-tabs">
            <li class="active" class="li1"><a href="#tab1" data-toggle="tab">Nội dung bài học</a></li>
            <li class="li2"><a href="#tab2" data-toggle="tab">Bài tập</a></li>
        </ul><!-- End .nav-tabs -->
        <div class="tab-content">
            <div class="tab-pane active" id="tab1">
           	    <div class="lesson-content-left bg-lesson-content-details">
                    <?php
            		$i = 0; 
            		while($rowMain = mysql_fetch_assoc($sqlMain->result)){
            		$i++;
            		$mainpart = 'http://'.$base_url.'/data/main_content/';
            	    ?>
           		        <div class="lesson-content-block">
                            <div class="lesson_main_video">
                                <?php if($rowMain['main_media_type'] == 1){ ?>
                                    <img style="" src="<?=$mainpart?>medium_<?=$rowMain['main_media_url1']?>" />
                                <?php }else if($rowMain['main_media_type'] == 2){ ?>	
                                    <div>
                                        <?=get_media_library_v2($mainpart.strtolower($rowMain['main_media_url1']),'')?>
                                    </div>
                                <?php }elseif($rowMain['main_media_type'] == 3){
                                    echo "<object width='491' height='400'><embed src='". $mainpart.$rowMain['main_media_url1']."' width='491' height='400' quality='high' pluginspage='http://www.macromedia.com/go/getflashplayer' type='application/x-shockwave-flash' menu='false' wmode='transparent'></embed></object>";
                                }?>
                                <a class="icon_nd_lb_v2 icon_nd_act_<?=$i?>" href="javascript:;">Nội dung bài học</a>
                            </div>
                            <div class="bot_left_lightbox bot_left_change_<?=$i?> lesson_main_content">
                                <?php if($rowMain['main_type'] != 1){ ?>
                                    <div class="p_script_<?=$i?> lesson_main_content_detail">
                                        <div class="lib-tool-translate">
                                            <span class="tool-translate-trans">Xem bản dịch</span>
                                        </div>
                                        <div class="lib-trans">
                                            <?=getMainCTran($rowMain['main_content_en'],$rowMain['main_content_vi'])?>
                                        </div>     
                                    </div>
                                <?php }else{ ?>
                                <div class="p_script_<?=$i?> lesson_main_content_detail">
                                    <div class="lib-tool-translate">
                                        <span class="tool-translate-trans">Xem bản dịch</span>
                                    </div>
                                    <div class="lib-trans">
                                        <?=getMainCTran($rowMain['main_content_en'],$rowMain['main_content_vi'])?>
                                    </div>     
                                </div>
                                <?php } ?>
                            </div>
           		        </div>
                    <?php }unset($sqlMain) ?>
           	    </div>
            </div><!-- End #tab1 -->
            <div class="tab-pane" id="tab2">
           	    <div class="lesson-content-right bg-lesson-content-details">
                    <h2 class="lesson-content-title" title="Bài <?=$unit_num?>: <?=$unit_name?> - Bài chữa">
           			    Bài tập
        		    </h2>      
           		    <div class="gray-box1" id="gray-box1_focus" tabindex="-1" style="">
                        <?php
                        $in = 0;
                        while($rowQuick  = mysql_fetch_assoc($sqlQuick->result)){ 
                            echo '<form name="quiz" id="frm_quiz">';
                            $sqlQues   = new db_query('SELECT * FROM questions WHERE que_exe_id = '.$rowQuick['exe_id']);
                                while($rowQues = mysql_fetch_assoc($sqlQues->result)){
                                    $type = $rowQues['que_type'];
                                    $in ++;
                                    if($rowQues['que_type']== 1 ){ 
                                        echo '<div>'; ?>                                   
                                            <h4 class="cau_hoi"><?=$in?>.<?php echo $rowQues['que_content'] =   str_replace ('&&', '<br />', $rowQues['que_content']);  ?></h4>
                                            <?php
                                            $sqlAns    = new db_query('SELECT * FROM answers WHERE ans_ques_id = '.$rowQues["que_id"]);
                                            $arrayT    = array(1=>'A',2=>'B',3=>'C',4=>'D',5=>'E');
                                            $iA        = 0;
                                            while($rowAns = mysql_fetch_assoc($sqlAns->result)){
                                            $iA ++; ?>  
                                                <span class="check_box">
                                                    <input id="checke<?=$in?>_<?=$iA?>" name="chec_box<?=$in?>" type="radio" value="<?=$rowAns['ans_id']?>" />
                                                    <label for="checke<?=$in?>_<?=$iA?>"><?=$arrayT[$iA]?>. <?=$rowAns['ans_content']?></label>
                                                </span>
                                        <?php } echo '</div>'; 
                                    }elseif ($rowQues['que_type']== 3){ ?>        	            
            							<?php
            							$arrayAns  = getStringAns($rowQues['que_content']);
            							$result    = count($arrayAns);
            							$rand_keys = array_random($arrayAns, $result);                                
            							?>
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
                                                    echo '<span id="droppable'.@$j.'"><span class="dotset">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></span>';
                                                }else{
                                   	                echo $arrayCont[$i];
                                                }     
        							        }
        						        ?>						   
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
                                                echo '&nbsp;<span id="editme'.$j.'" style="color:red;font-weight: bold;">....................</span>&nbsp;&nbsp;';
                                            }else{
                                        	   echo $arrayCont[$i];
                                            }     
                                        } ?>
                                        </div>
                                    <?}?>    
                                <?php }unset($sqlQues);
                            echo '</form>';     
                        }unset($sqlQuick); ?>   
                        <div class="button button-orange pull-right_result">Xem kết quả bài đã làm</div>
                        <div class="clearfix"></div>         
           		    </div>
                    <script type="text/javascript">                                
           		    $(document).ready(function(){
           		        var $urlPoint = "";
           		        var baseurl = 'http://<?=$base_url?>';
           		        <?php
                        if($type == 3){
                        	for($i=1;$i<=$j;$i++){                                        
                           ?>                                                             
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
                        <?php	} } ?>
                    
                        <?php
                        if($type == 1){
                        	for($ii = 1; $ii<= $in ; $ii ++){ ?>
                        	var varValue<?=$ii?> = $('.check_box input[name=chec_box<?=$ii?>]:checked').val();
                        	$urlPoint += 'idAns<?=$ii?>='+varValue<?=$ii?>+'&';
                        <?php } }elseif($type == 2){
                        	for($i=1;$i<=$j;$i++){
                        	$javaStr .= '#editme'.$i.','; ?>
                        	var str<?=$i?>    = $('#editme<?=$i?>').text().replace(/\s+/g, '_');	
                        	$urlPoint += "value<?=$i?>=" + str<?=$i?> + "&";
                        <?php } } ?>
           		    });
           		    </script>	
           	    </div>
            </div><!-- End #tab2 -->
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
        <script type="text/javascript">
        $(document).ready(function() {
            var baseurl =  'http://<?=$base_url?>';
            $('.pull-right_result').click(function(){
                var urlQuick = "";
                <?php for($ii = 1; $ii<= $in ; $ii ++){ ?>
                    var varValue<?=$ii?> = $('.check_box input[name=chec_box<?=$ii?>]:checked').val();
                    urlQuick += 'idAns<?=$ii?>='+varValue<?=$ii?>+'&';
                <?php } ?>       
                $.fancybox({
                   'type'   : 'ajax',
                   'href'   :  baseurl+ '/ajax/mark_main.php?iunit=<?=$iUnit?>&unit=<?=$unit?>&nAns=<?=$in?>&' + urlQuick,
                });
            });      
        });
    
        </script>
   	    <div class="clearfix"></div>
    </div>
    <script type="text/javascript">
    function focusFoo(){
        document.getElementById('gray-box1_focus').focus();
    }
    </script> 
<?php } ?>