<?php
function lesson_quiz($unit,$unit_num,$unit_name){
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
   
    $sqlCou     = new db_query('SELECT * FROM courses,courses_multi WHERE courses.cou_id = courses_multi.com_cou_id AND courses_multi.com_id = '.$unit);
    $rowCou     = mysql_fetch_assoc($sqlCou->result);
    $iCou       = $rowCou['cou_id'];
    //Lấy thông tin dạng bài học
    $sqlUnitMail = new db_query('SELECT * FROM lesson_details WHERE les_det_type = 3 AND les_com_id ='.$unit);
    $rowUnitMail = mysql_fetch_assoc($sqlUnitMail->result);
    $iUnit       = $rowUnitMail['les_det_id'];
    unset($sqlUnitMail);
    //Lấy nội dung bài học và bài tập
    $sqlQuick   = new db_query('SELECT * FROM exercises WHERE exe_type = 0 AND exe_com_id = '.$unit);

    $type    = "";
    $javaStr = ""; ?>
   <?=$var_head_lib2?>
   <script src="<?=$var_path_js?>jquery.media.js"></script> 
   <script type="text/javascript">                                
      var urlPoint      =   "";
      var baseurl       =  'http://<?=$base_url?>';
      $(document).ready(function(){
           $('a.media').media( { 'backgroundColor' : 'transparent' , width: 300, height: 20 } );
      });
   </script>
   <div class="in_content_v2">
		<h2 class="lesson-content-title" title="Bài <?=$unit_num?>: <?=$unit_name?> - Quiz">
			Bài <?=$unit_num?>: <?=$unit_name?> - Quiz
		</h2>
   	    <div class="lesson-content-right bg-lesson-content-details">
	        <div class="gray-box1">
            <?php
			$in = 0;
			$classinput = "";
			$numA       = array();
		    while($rowQuick  = mysql_fetch_assoc($sqlQuick->result)){
			    $sqlQues     = new db_query("SELECT * FROM questions WHERE que_exe_id = ".$rowQuick['exe_id']." ORDER BY que_type , que_order ASC");
				while($rowQues = mysql_fetch_assoc($sqlQues->result)){                                            
					$in ++;
					$type[$in] = $rowQues['que_type'];
					echo get_media_quiz($rowQues['que_media_id']);
					if($rowQues['que_type']== 1 ){ ?>				
                        <!--  bắt đầu hiển thị nội dung quick dạng chọn câu đúng -->
                        <div>
                            <div class="cau_hoi" style=""><?=$in?>.<?php echo $rowQues['que_content'] =   str_replace ('&&', '<br />', $rowQues['que_content']);  ?></div>	   
                     	    <?php
                     		$sqlAns    = new db_query("SELECT * FROM answers WHERE ans_ques_id = ".$rowQues['que_id']);
                     		$arrayT    = array(1=>'A',2=>'B',3=>'C',4=>'D',5=>'E');
                     		$iA        = 0;
                     		while($rowAns = mysql_fetch_assoc($sqlAns->result)){
                     		$iA ++;
                           	?>                        			   
                                <span class="check_box">
                                    <input id="checke<?=$in?>_<?=$iA?>" name="chec_box<?=$in?>" type="radio" value="<?=$rowAns['ans_id']?>" />
                                    <label for="checke<?=$in?>_<?=$iA?>"><?=$arrayT[$iA]?>. <?=$rowAns['ans_content']?></label>
                                </span>
                                <br/>   
                        	<?php } ?>
                        </div>
				    <?php }elseif($rowQues['que_type']== 2 ){ 
						$arrayCont  =  getMainC($rowQues['que_content']);
						$cArrayCont =  count($arrayCont); ?>
 						<div>
                            <?php
                            $j = 0;
                            for($i=0;$i<$cArrayCont;$i++){
                                if($i%2 != 0) { 
                                   $j ++;
                                   $classinput .= "#editme".$in."_".$j.",";
                                   echo '<span id="editme'.$in.'_'.$j.'" style="color:red;font-weight: bold;">....................</span>';
                                }else{
                                	echo $arrayCont[$i];
                                }     
                            }
                            $numA[$in] = $j;
                            ?>
         				</div>
				    <?php }elseif($rowQues['que_type']== 3 ){ 
    					$arrayAns  = getStringAns($rowQues['que_content']);
    					$result    = count($arrayAns);
    					$rand_keys = array_random($arrayAns, $result); ?>
      						<div>     						
         						<div class="cau_hoi"><?=$in?>. Kéo thả từ thích hợp vào khoảng trống</div>
         						<div class="menu_quiz"> 
         							<?php for($i=0;$i<$result;$i++){ ?>
         								<a href="#"><span><?=$i+1?> .</span> <span id="draggable<?=$in?>_<?=$i+1?>"><?=trim($rand_keys[$i])?></span></a>
         							<?php } ?>
         						</div>
                                <div class="menu_ans_drag"> 
                                    <?php
                                    $arrayCont  =  getMainC($rowQues['que_content']);
                                    $cArrayCont =  count($arrayCont);
                                    $j = 0;
                                    for($i=0;$i<$cArrayCont;$i++){
                                        if($i%2 != 0) { 
                                            $j ++;
                                            echo '<span id="droppable'.$in.'_'.$j.'"><span class="dotset">.................</span></span>';
                                        }else{
                                      	    echo $arrayCont[$i];
                                        }     
                                    }
                                    $numA[$in] = $j; ?>      
                                </div>                                  
      						</div>
						<?php } ?>
			        <?php } ?>
                <?php } ?>
               <div>&nbsp;</div>
               <h2 class="button button-orange pull-right_result">Xem kết quả bài đã làm</h2>
               <div class="clearfix"></div>
            </div>	
   	    </div>     
   	<div class="clearfix"></div>
   </div>
<script type="text/javascript">
$(document).ready(function(){
    $("<?=$classinput?>").editInPlace({
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
<script>                                
$(document).ready(function(){
    <?php
    for($i=1;$i<=$in;$i++){
        if($type[$i] == 3){
            for($idrag=1;$idrag<=$numA[$i];$idrag++){ ?>
            var valueDropDrag<?=$i?> = "";
            var valuePoint<?=$i?> = [];
            $( "#draggable<?=$i?>_<?=$idrag?>" ).draggable({ appendTo: "body",helper: "clone" });    
            $( "#droppable<?=$i?>_<?=$idrag?>" ).droppable({
       	        activeClass: "ui-state-hover",
       	        hoverClass: "ui-state-active",
          	    drop: function( event, ui ) {
             		$( this ).addClass( "ui-state-highlight" );
                    $( this ).find( ".dotset" ).remove();
                    valuedrop<?=$i?>_<?=$idrag?> = ui.draggable.text();
                    str_temp<?=$i?>_<?=$idrag?> = valuedrop<?=$i?>_<?=$idrag?>.replace(/\s+/g, "_");
             		valuePoint<?=$i?>[<?=$idrag?>] = str_temp<?=$i?>_<?=$idrag?>.replace(/\'/g, "");
                    valueDropDrag<?=$i?>   +=  "value<?=$i?>_<?=$idrag?>=" + valuePoint<?=$i?>[<?=$idrag?>] + "&";
                    $( this ).find( ".text-ct" ).remove();
                    $( "<span class='text-ct' style='color:white;'></span>" ).text( ui.draggable.text() ).appendTo( this );
          	    }
            });
         <?php } ?>
   <?php } } ?>
   $(".pull-right_result").click(function(){
       // function xử lý kết quả câu trả lời.
        <?php
        for($i=1;$i<=$in;$i++){
        if($type[$i] == 1){ ?>
            urlPoint += 'type<?=$i?>=1&';
            var varValue<?=$i?> = $('.check_box input[name=chec_box<?=$i?>]:checked').val();
            urlPoint += 'idAns<?=$i?>='+varValue<?=$i?>+'&';
        <?php }elseif($type[$i] == 2){ ?>
            urlPoint += 'type<?=$i?>=2&numAns<?=$i?>=<?=$numA[$i]?>&';
            <?php for($iThree=1;$iThree<=$numA[$i];$iThree++){ ?>
            var str<?=$i?>_<?=$iThree?> = $('#editme<?=$i?>_<?=$iThree?>').text().replace(/\s+/g, '_');
            urlPoint += "value<?=$i?>_<?=$iThree?>=" + str<?=$i?>_<?=$iThree?> + "&";
            <?php } }elseif($type[$i] == 3){ ?>
            urlPoint += 'type<?=$i?>=3&numAns<?=$i?>=<?=$numA[$i]?>&' + valueDropDrag<?=$i?>;
        <?php } } ?>
            $.fancybox({
                'type'   : 'ajax',
                'href'   :  baseurl+ '/ajax/mark_quiz.php?icou=<?=$iCou?>&iunit=<?=$iUnit?>&unit=<?=$unit?>&nAns=<?=$in?>&' + urlPoint,
            });       
    }); 
});

</script> 
<div id="fade" class="black_overlay"></div>
<?php } ?>