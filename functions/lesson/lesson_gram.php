<?php
function lesson_grammar($unit,$unit_num,$unit_name){
    $myuser          =  new user('','');
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
    $rowUnitMail = mysql_fetch_assoc($sqlUnitMail->result);
    $iUnit       = $rowUnitMail['les_det_id'];
    unset($sqlUnitMail);
    //Lấy nội dung bài học và bài tập
    $sqlGram    = new db_query('SELECT * FROM grammar_lesson WHERE gram_det_id = '.$iUnit.' ORDER BY gram_order ASC');
    $sqlQuick   = new db_query('SELECT * FROM exercises WHERE exe_type = 1 AND exe_type_lesson = 2 AND exe_com_id = '.$unit);

    $type    = "";
    $javaStr = "";
?>
   <?=$var_head_lib2?>
    <div class="in_content_v2">
   	    <div class="lesson-content-left">
       		<h2 class="lesson-content-title" style="" title="Bài <?=$unit_num?>: <?=$unit_name?>">
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
           		    <div class="lesson-content-block">
                        <?php
                        $gram_path = 'http://'.$base_url.'/data/grammar/';
                        while($rowGram  = mysql_fetch_assoc($sqlGram->result)){
                        ?>
                            <div class="gram_title">
                                <?=$rowGram['gram_title']?>
                            </div>
                            <?php if($rowGram['gram_media_url'] != ''){ ?>
                                <div class="main_igm">
                                    <?php if($rowGram['gram_media_type'] == 1){ ?>
                                        <img src="<?=$gram_path?>medium_<?=$rowGram['gram_media_url']?>" alt="<?=$rowGram['gram_title']?>"/>
                                    <?php }else{
                                        echo "<center><embed width='333' height='182' type='application/x-shockwave-flash' src='http://".$base_url."/mediaplayer/player.swf' flashvars='file=". $gram_path.$rowGram['gram_media_url'] ."'</embed></center>";       
                                    }
                                }?>
                                </div>
                            <?php if(trim(removeHTML($rowGram['gram_content_vi'])) != ''){ ?>
                                <div>
                                    <?=$rowGram['gram_content_vi']?>
                                </div>
                            <?php } ?>
                            <?php if(trim(removeHTML($rowGram['gram_exam'])) != ''){ ?>
                                <div>
                                    <?=$rowGram['gram_exam']?>  s                      
                                </div>
                            <?php } ?>
                        <?php } ?>
           		    </div>
           	    </div>
            </div>
            <div class="tab-pane" id="tab2">
           	    <div class="lesson-content-right bg-lesson-content-details">
                    <h2 class="lesson-content-title" style=""> Bài tập </h2>
       		        <div class="gray-box1">
                    <?php
                    $in = 0;
                    while($rowQuick  = mysql_fetch_assoc($sqlQuick->result)){								
       				$sqlQues     = new db_query('SELECT * FROM questions WHERE que_exe_id = '.$rowQuick["exe_id"]);
       				    while($rowQues = mysql_fetch_assoc($sqlQues->result)){
    						$type = $rowQues['que_type'];
    						$in ++;
    						    if($rowQues['que_type']== 3 ){ ?>   	            
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
    						<?php
    						}elseif( $rowQues['que_type']== 1 ){
    						    echo '<div>'; ?>
    						    <!--  bắt đầu hiển thị nội dung quick dạng chọn câu đúng -->
    						    <h4 class="cau_hoi"><?=$in?>.<?php echo $rowQues['que_content'] =   str_replace ('&&', '<br />', $rowQues['que_content']);  ?></h4>
       							<?php
       							$sqlAns    = new db_query("SELECT * FROM answers WHERE ans_ques_id = ".$rowQues['que_id']);
       							$arrayT    = array(1=>'A',2=>'B',3=>'C',4=>'D',5=>'E');
       							$iA        = 0;
       							while($rowAns = mysql_fetch_assoc($sqlAns->result)){
          							$iA ++;	?>							
       						        <span class="check_box">
                                    <input id="checke<?=$in?>_<?=$iA?>" name="chec_box<?=$in?>" type="radio" value="<?=$rowAns['ans_id']?>" />
                                    <label for="checke<?=$in?>_<?=$iA?>"><?=$arrayT[$iA]?>. <?=$rowAns['ans_content']?></label>
                                </span>   
    				            <?php }
    						    echo '</div>';
    						}elseif( $rowQues['que_type']== 2 ){
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
                                    }?>
        						   </div>
    						<?php }
    					}unset($sqlQues);
    			    }unset($sqlQuick); ?>
                    <script type="text/javascript">            
                        $(document).ready(function(){
                            var $urlPoint   =   "";
                            var baseurl     =  'http://<?=$base_url?>';
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
                                <?php } ?>
                            <?php } ?>
                        });
                    </script>         
                    <div class="button button-orange pull-right_result">Xem kết quả bài đã làm</div>      
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
               			<?php	} } ?>
                        
                        /*
                        *Tính điểm 
                        */
                        $(document).ready(function() {
                            var baseurl =  'http://<?=$base_url?>';
                            $('.pull-right_result').click(function(){ 
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
                                    'href'   :  baseurl+ '/ajax/mark_grammar.php?iunit=<?=$iUnit?>&unit=<?=$unit?>&nAns=<?php if ($type == 1) { echo $in; }else{ echo @$j; }?>&type=<?=$type?>&' + $urlPoint,
                                });
                            });      
                        });        
               		});
               		</script>	
        	    </div>
            </div>
        </div>

        <script type="text/javascript">
        $(document).ready(function(){
            $("<?=$javaStr?>").editInPlace({
                saving_animation_color: "#33B3A6",
                value_required        :	true,
                callback: function(idOfEditor, enteredText, orinalHTMLContent, settingsParams, animationCallbacks) {
                   	animationCallbacks.didStartSaving();
                   	setTimeout(animationCallbacks.didEndSaving, 2000);
                   	return enteredText;
                }
            });
        });
        </script>     
          
        <script type="text/javascript">
        function focusFoo(){
            document.getElementById('gray-box1_focus').focus();
        }
        </script> 

   </div>
<div id="fade" class="black_overlay"></div>
<?php } ?>