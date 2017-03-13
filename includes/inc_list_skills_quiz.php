<?php
// $arrSkill : ARRAY SAVE INFO skill_lesson table
// $iLes       = $arrSkill[0]['skl_les_id'];
?>
<div id="quiz_area">
    <div id="quiz_box">
    <?
    $dbQuiz = new db_query('SELECT * FROM skill_content
                               INNER JOIN exercises ON skl_cont_id = exe_skl_cont_id
                                    WHERE skl_cont_les_id = '.$iLes.' AND exe_type = 0 LIMIT 1');
    $numQuiz = mysqli_num_rows($dbQuiz->result);
    if($numQuiz > 0){
        $type       = array();
       	$in         = 0;
       	$classinput = "";
       	$numA       = array();

        echo '<div class="quiz_cont">';

   	    while($rowQuiz  = mysqli_fetch_assoc($dbQuiz->result)){
   	        $icont      = $rowQuiz['skl_cont_id'];
   			$sqlQues    = new db_query('SELECT * FROM questions WHERE que_exe_id = '.$rowQuiz["exe_id"].' ORDER BY que_type , que_order ASC');
   			while($rowQues = mysqli_fetch_assoc($sqlQues->result)){
                $in ++;
                $type[$in] = $rowQues['que_type'];

                if($arrSkill[0]['skl_les_type'] == 5){
                    $sqlMedia       =    new db_query('SELECT * FROM media_exercies WHERE media_id = '.$rowQues["que_media_id"]);
                    $rowMedia       =    mysqli_fetch_assoc($sqlMedia->result);
                    $mediaUrl       =    'http://'.$base_url.'/data/skill_exercises/';

                    if($rowMedia['media_type'] == 2){
                        echo "<embed width='300' height='24' type='application/x-shockwave-flash' src='http://".$base_url."/mediaplayer/player.swf' flashvars='file=".$mediaUrl.$rowMedia['media_name'] ."'</embed>";
                    }
                    else{
                        echo get_media_quiz_skill($rowQues['que_media_id']); //Lay ra media cua cau hoi
                    }
                }else {
                    echo get_media_quiz_skill($rowQues['que_media_id']); //Lay ra media cua cau hoi
                }

   				if($rowQues['que_type']== 1 ){
                ?>
               	    <!--  bắt đầu hiển thị nội dung quiz dạng chọn câu đúng -->
               		<div style="width: 100%;overflow: hidden;">
               		<div class="cau_hoi"><?=$in?>.<?php echo $rowQues['que_content'] =   str_replace ('&&', '<br />', $rowQues['que_content']);  ?></div>
           			<?php
       				$sqlAns    = new db_query("SELECT * FROM answers WHERE ans_ques_id = ".$rowQues['que_id']);
       				$arrayT    = array(1=>'A',2=>'B',3=>'C',4=>'D',5=>'E');
       				$iA        = 0; //Chi so cua cau tra loi
       				while($rowAns = mysqli_fetch_assoc($sqlAns->result)){
       				$iA ++;
           			?>
    		               <span class="check_box"><input id="checke<?=$in?>_<?=$iA?>" name="chec_box<?=$in?>" type="radio" value="<?=$rowAns['ans_id']?>" /><label style="cursor: pointer;" for="checke<?=$in?>_<?=$iA?>"><?=$arrayT[$iA]?>. <?=$rowAns['ans_content']?></label></span>
    			        <?php } ?>
       		        </div>
   			    <?php }elseif($rowQues['que_type']== 2 ){
   					$arrayCont  =  getMainC($rowQues['que_content']);
   					$cArrayCont =  count($arrayCont);
   			        ?>
   			            <div >
   			                <div class="cau_hoi"><?=$in?>. Điền từ vào chỗ trống</div>
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
   				            }$numA[$in] = $j; ?>
   			            </div>
   			    <?php }elseif($rowQues['que_type']== 3 ){
   					$arrayAns  = getStringAns($rowQues['que_content']);
   					$result    = count($arrayAns);
   					$rand_keys = array_random($arrayAns, $result); ?>
   			        <div style="overflow: hidden;" >
   			            <div class="cau_hoi"><?=$in?>. Kéo thả từ thích hợp vào khoảng trống</div>
               			<div class="content-wrap-ques-drag">
               				<?php
               					for($i=0;$i<$result;$i++)
               					{
               				?>
               					<a class="text-ques-drag" href="#" style="margin: 0 10px;" ><?=$i+1?> . <span id="draggable<?=$in?>_<?=$i+1?>" style="color: red;font-weight: bold;"><?=trim($rand_keys[$i])?></span></a>
               				<?php } ?>
               			</div>
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
   				        }$numA[$in] = $j; ?>
   			        </div>
   			<?php }
   	    }   }unset($dbQuiz);
        echo '</div>'; // End quiz cont
   }    ?>

   </div><!-- End #quiz_box -->

   <div class="pull-left button button-orange show_result">Kiểm tra kết quả</div>
   <div class="clearfix"></div>
</div><!-- End #quiz_area -->

<script type="text/javascript">
    var urlPoint      =   "";
    var baseurl       =  'http://<?=$base_url?>';
    $(document).ready(function(){

        //===========================================================//
        $("<?=$classinput?>").editInPlace({
       		saving_animation_color: "lime",
                value_required   :	true,
       		    callback: function(idOfEditor, enteredText, orinalHTMLContent, settingsParams, animationCallbacks) {
       			animationCallbacks.didStartSaving();
       			setTimeout(animationCallbacks.didEndSaving, 2000);
       			return enteredText;
       		}
     	});
        //===========================================================//
        <?php
        for($i=1;$i<=$in;$i++){
            if($type[$i] == 3){
                for($idrag=1;$idrag<=$numA[$i];$idrag++){  ?>
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
                    $( "<span class='text-ct' style='color:red;font-weight: bold;'></span>" ).text( ui.draggable.text() ).appendTo( this );
   			    }
   		    });
           <?php } ?>
       <?php } } ?>
       //==========================================================//
       $(".show_result").click(function(){
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

            if(confirm('Xem kết quả bài đã làm?')){
                $('#quiz_area').load(baseurl+'/ajax/mark_skill_quiz.php?iles=<?=$iLes?>&icont=<?=$icont?>&nAns=<?=$in?>&'+urlPoint);
            }

       });
   })
</script>