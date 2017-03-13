<?php
function lesson_speak($unit,$unit_num,$unit_name){
    $myuser          =  new user('','');
    $var_path_js     = '/themes/js/';
    $var_path_css    = '/themes/css/';
    $var_path_media  = '/mediaplayer/';
    $var_path_libjs  = '/js/';
    $base_url        =  $_SERVER['HTTP_HOST'];
    $var_head_lib2   = '<link rel="stylesheet" type="text/css" href="'.$var_path_css.'jquery-ui-1.8.16.custom.css" />';
    $var_head_lib2   = '<link rel="stylesheet" type="text/css" href="'.$var_path_css.'new_style_skill.css" />';
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
    $var_head_lib2  .= '<script type="text/javascript" src="'.$var_path_js.'lesson_speak.js"></script>';

    //Lấy nội dung bài học và bài tập
    $sqlSpe     = new db_query('SELECT * FROM learn_speaking WHERE learn_unit_id = '.$unit);
    $rowSpe     = mysqli_fetch_assoc($sqlSpe->result);
    if (isset($_SESSION['num_sp'])) { unset($_SESSION['num_sp']); }
    ?>
    <?=$var_head_lib2?>
    <script type="text/javascript" src="<?=$var_path_libjs?>recorder.js"></script>
    <script type="text/javascript" src="<?=$var_path_libjs?>swfobject.js"></script>
    <script type="text/javascript" src="<?=$var_path_libjs?>gui.js"></script>
    <script type="text/javascript" src="http://<?=$base_url?>/mediaplayer/jwplayer.js"></script>
    <script type="text/javascript" src="<?=$var_path_js?>duration_bar.js"></script>
    <!-- GUI code... take it or leave it -->
    <script type="text/javascript">
        $(document).ready(function() {
            var baseurl =  'http://<?=$base_url?>';
            setup();
        });
    </script>
    <div class="in_content_v2">
   	    <div class="lesson-content-left">
       		<h2 class="lesson-content-title" title="Bài tập">
       			Bài tập
       		</h2>
       		<div class="alert alert-info-speak">
                Giả lập nghe nói với người bản ngữ. Bạn hãy xem Video để nghe câu hỏi & bấm vào nút <img src="http://<?=$base_url?>/themes/img/start_record.jpg" alt="Start record" /> để ghi âm câu trả lời.
                Trong mỗi bài có thể có nhiều câu hỏi.Ghi âm xong hãy ấn play để nghe câu hỏi tiếp theo.
            </div>
   	    </div>
       	<div class="lesson-content-left">
       		<div class="lesson-content-block">
            <?php
            $db_count   = new db_query('SELECT count(*) AS count FROM learn_content WHERE lec_learn_id = '.$rowSpe["learn_sp_id"]);
          	$row    = mysqli_fetch_array($db_count->result);
          	unset($db_count);
            $sqlCtSpea  = new db_query('SELECT * FROM learn_content WHERE lec_learn_id = '.$rowSpe['learn_sp_id'].' AND lec_order = 1 ');
            while($rowCtSpea = mysqli_fetch_assoc($sqlCtSpea->result)){
            ?>
                <script type="text/javascript">
                    $(document).ready(function(){ $(".script_btn_wr").click(function(){ $("#text_hint1").show(); }); });
                </script>
                <div class="hide_content_here">
                    <div class="tool_quest_speak">
                        <div id="text_hint1" class="ct_scrip">
                            <div>
                                <b style="float: left;margin: 5px;width: 150px;">
                                    <span class="ques_spk">Question</span>
                                    <span class="view_ques_num get_num">1</span>
                                    <span class="view_ques_sou">/</span>
                                    <span class="view_ques_num"><?=$row['count']?></span>
                                </b>
                            </div><br />
                          	<div>
                                <b>Gợi ý : <?php echo $rowCtSpea['lec_note'];?> </b>
                            </div>
                        </div>
                    </div>

                    <?php
                    $speapart = 'http://'.$base_url.'/data/learn_sp/';
                    if($rowCtSpea['lec_media'] != ''){
                        if($rowCtSpea['lec_media_type'] == 1){ ?>
                            <img src="<?=$speapart.$rowCtSpea['lec_media']?>"/>
                        <?php }elseif($rowCtSpea['lec_media_type'] == 2){ ?>
                            <div class="text-center">
                                <?=get_media_library_v2($speapart.$rowCtSpea["lec_media"],'')?>
                            </div>
                        <?php } ?>
                    <?php } ?>
                </div>
                <!---Load ajax here-->
                <div class="lesson-content-block_load" style="display: none;">

                </div>
                <!---Load ajax here-->
                <div class="guid_record">
                    <div class="guid_step_record"><b>Bước 1</b> : Thiết lập thiết bị thu âm</div>
                    <img src="http://<?=$base_url?>/themes/img/i2.jpg" alt="flash setting" />
                    <div class="guid_step_record"><b>Bước 2</b> : Bấm <img src="http://<?=$base_url?>/themes/img/start_record.jpg" alt="start_record" /> để bắt đầu ghi âm.</div>
                    <div class="guid_step_record"><b>Bước 3</b> : Bấm <img src="http://<?=$base_url?>/themes/img/stop_record.jpg" alt="stop_record" /> để dừng ghi âm.</div>
                    <div class="guid_step_record"><b>Bước 4</b> : Bấm <img src="http://<?=$base_url?>/themes/img/au.png" alt="audio" /> và <img src="http://<?=$base_url?>/themes/img/play_button.jpg"  alt="play"/> để chọn và nghe lại đoạn ghi âm của bạn</div>
                    <div class="guid_step_record"><b>Bước 5</b> : Bấm <img src="http://<?=$base_url?>/themes/img/save_record.png" alt="save_record" /> để chuyển sang đoạn tiêp theo</div>
                    <div class="guid_step_record"><b>Bước 6</b> : <span >Hoàn thành</span> để gửi bài cho giáo viên.</div>
                    <div class="guid_step_record"><b style="color: #D81213;">Lưu ý</b>  : Chỉ nên bấm hoàn thành khi đã trả lời đầy đủ hêt các câu để được số điểm tối đa</div>
                </div>
                <?}unset($sqlCtSpea);?>
       		</div>
       	</div>
       	<div class="lesson-content-right">
            <div class="record_land">
                <div id="wami" style="position: relative; top: -138px;"></div>
                <div class="remain">
                    <div id="loaded" class="loaded"><div class="end"></div></div>
                </div>
                <div class="tool_bar">
                    <div class="tb btn_start_record"></div>
                    <div class="tb btn_stop_record"></div>
                    <div class="tb btn_start_play"></div>
                    <div class="tb btn_stop_play"></div>
                    <div class="tb btn_next"></div>

                    <div class="speaker"></div>
                    <div class="list_au">
                        <div class="au au10">10</div>
                        <div class="au au9">09</div>
                        <div class="au au8">08</div>
                        <div class="au au7">07</div>
                        <div class="au au6">06</div>
                        <div class="au au5">05</div>
                        <div class="au au4">04</div>
                        <div class="au au3">03</div>
                        <div class="au au2 au_selected">02</div>
                        <div class="au au1">01</div>
                   </div>
                </div>
            </div><!-- End .record_land -->
            <div class="lesson-content-block">
                <textarea id="script_spk" class="input-block-level" rows="7" placeholder="Nội dung bài nói của bạn"></textarea>
            </div>
            <img style="display: none;" src="http://<?=$base_url?>/themes_v2/images/load_record.gif" />
            <div class="btn_wr">
                <a class="button_hoan_thanh_wr">Hoàn thành</a>
                <div id="wri_load">&nbsp;</div>
            </div>
        </div>
        <script type="text/javascript">
            //init duration bar
            var B1=new Bar({
            ID:'loaded'
            });
            //================================================//
            <?php
            $urlRec = '/data_record/no_save/';
            if($myuser->logged == 1){
          	    if( $myuser->act == 1 )	 {
          		    $check_learn = check_learn_user($rowSpe['learn_sp_id'],$myuser->u_id,'speak');
          		    if($check_learn == 0) {
          			   $urlRec = '/data_record/';
          		    }
          	    }
            } ?>

            $('.au').click(function(){
                $('.au').removeClass('au_selected');
                $(this).addClass('au_selected');
            });
            var baseurl =  'http://<?=$base_url?>';
            $('.btn_start_record').show();
    		    $(".btn_start_record").click(function(){
    		        <?php if($myuser->logged == 1){ ?>
                        count_rc++;
                        getname();
       			        record();
                    <?php } ?>
    		});

    		$(".btn_stop_record").click(function(){
    			stop();
    		});

            $(".btn_start_play").click(function(){
                var name_audio = $('.au_selected').attr('id');
                if(name_audio){
                    play(name_audio);
                audio_path = 'http://<?=$base_url?>/js<?=$urlRec?>'+name_audio+'.wav';
                $.ajax({
                    type: 'POST',
                    url: 'http://<?=$base_url?>/ajax/ajax_get_duration.php',
                    data: 'audio='+audio_path,
                    success: function(data){
                        B1.Start(data);
                    }
                });
                }else{
                    alert('Bạn chưa chọn đoạn audio ghi âm');
                }
    		});

            $('.btn_stop_play').click(function(){
                stopplay();
            });
            $(".btn_next").click(function(){
                $(this).css("display","none");
                $(".hide_content_here").css("display","none");
    			$(".lesson-content-block_load").show();
                $.ajax({
                    type:"POST",
                    data:{
                        idspea  : '<?=$rowSpe['learn_sp_id']?>',
                    },
                    url: ""+baseurl+"/ajax/ajax_content_speaking_v2.php", //goi toi file ajax.php
                    success:function(data){
                        $('.load_content').css("display","none");
                        var getdata    = $.parseJSON(data);
                        suc   	      = getdata.suc;
                        num_sp         = getdata.num_sp;
                        error          = getdata.error;
                        content        = getdata.content;
                        if (suc == 1){
                   	        $(".lesson-content-block_load").html(content);
                            $('.btn_start_record').show();
                        }
                        if (suc == 0){
                   	        $(".lesson-content-block_load").html(error);
                        }
                    },
            	});
    		});
            </script>

            <script type="text/javascript">
                var strname = '';
                function getname() {
             	    name = randomString();
             	    //alert(name);
                }
                function record() {
          	        strname += name+'.wav | '
                    num_ques = $(".get_num").text();
          	        Wami.startRecording('http://<?=$base_url?>/js<?=$urlRec?>record.php?name='+name+'.wav','onRecordStart','onRecordFinish','onError');
                }
                function play(name_au) {
          	        Wami.startPlaying("http://<?=$base_url?>/js<?=$urlRec?>"+name_au+".wav","onPlayStart", "onPlayFinish", "onError");
                }
            </script>
        <?php
        if($myuser->logged == 1){
            $chk = check_learn_user($rowSpe['learn_sp_id'],$myuser->u_id,'speak');
            if($chk == 1){
                $db_own = new db_query('select * from learn_speak_result WHERE lsr_spe_id = '.$rowSpe["learn_sp_id"].' AND lsr_use_id = '.$myuser->u_id.' LIMIT 1');
                $row_own = mysqli_fetch_assoc($db_own->result);
                unset($db_own);
		        $comment = $row_own['lsr_comment']; ?>
                <div class="lesson-content in_content" id="other-content-area" style="margin-bottom: 25px;">
                    <div class="lesson-content-left">
	                    <div class="lesson-content-other">
                            <div class="lesson-content-left no-border">
       	                        <h2 class="lesson-content-subtitle">Bài làm của bạn</h2>
       	                        <div class="lesson-content-other">
       		                        <div class="gray-box2">
       			                        <div class="container-fluid">
                                            <div class="row-fluid single-item">
                                                <div class="span12 user_summary" id="<?=$myuser->u_id?>">
                                                    <div class="col-name" style="float: left;">
                				                        <div class="bold"><span class="cyan"><?if($myuser->use_name == '') echo $myuser->use_email; else echo $myuser->use_name;?></span></div>
                				                        <div>Level <span class="bold"><?=get_level_user($myuser->use_exp)?></span> - Exp <span class="bold"><?=$myuser->use_exp?></span></div>
                			                        </div>
                                                    <div class="col-stat"><span class="point bold"><?if($row_own['lsr_point'] != 0) echo $row_own['lsr_point']; else echo '0';?></span></div>
                                                    <div class="col-move"></div>
                                                </div>
                		                        <div class="clearfix"></div>
                                                <div class="span12 answer_around" id="aa_<?=$myuser->u_id?>_show">
                                                    <div class="answer user_ans">
                                                        <div class="title_type" style="display: none;">Bài làm</div>
                                                        <div class="content">
                                                        <?php
                  			                            $audio     = explode("|",$row_own['lsr_audio']);
                  			                            $count     = count($audio);
                                                        $num_au    = 0;
                  			                            for($j=0;$j < $count - 1 ;$j++){ ?>
                                                            <div class="block gray-block input_blk dif_user_ans">
                                                                <span>Nghe câu trả lời thứ <?=($j+1)?></span>
                                                                <div class="start_play_<?=$num_au?> start_play_user node" id="<?=trim($audio[$j])?>"></div>
                                                                <div class="stop_play_<?=$num_au?> stop_play_user node" id="<?=$num_au?>"></div>
                                                                <div class="speaker2 node"></div>

                                                                <script type="text/javascript">
                                                                    $('.start_play_<?=$num_au?>').click(function(){
                                                                    var audio = $(this).attr('id');
                                                                    var uniq = $('.stop_play_<?=$num_au?>').attr('id');
                                                                    play_user(audio,uniq);
                                                                    });
                                                                    $('.stop_play_<?=$num_au?>').click(function(){
                                                                        stopplay();
                                                                    });
                                                                </script>
                                                            </div>
                                                        <?php $num_au++;}?>
                                                        </div>
                                                    </div>
                                                    <div class="answer teacher_ans">
                                                        <div class="title_type">Nhận xét của giáo viên</div>
                                                        <div class="content">
                                                            <?php
                                                            $comment = str_replace ('||', '<br />', $comment);
                                                	   		echo $comment;
                                                            ?>
                                                        </div>
                                                    </div>
                                                    <a style="display: none;" class="close" title="Close">x</a>
                                                </div>
                	                        </div>
                                        </div><!-- End .container-fluid -->
       		                        </div><!-- End .gray-box2 -->
       	                        </div>
                            </div>
	                    </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            <?php } ?>
        <?php } ?>
    </div>
   <input type="hidden" value="<?=$rowSpe['learn_sp_id']?>" name="id_sp" id="id_sp" />
   <div class="lesson-content in_content" id="other-content-area">
		<div class="lesson-content-left">
			<div class="lesson-content-other">
    		    <?php
                $type	   = getValue("type","str","GET","write");
                $unit       = getValue("iunit","int","GET","");
                $per_page   = 5;
                switch($type){
             	    case "practice":
             	   		if (checkLearn($unit,'writing') == 1) {
             				$sqlWri     = new db_query('SELECT * FROM learn_writing WHERE learn_unit_id = '.$unit);
             				$row        = mysqli_fetch_assoc($sqlWri->result);
             				$ilesson    = $rowWri['learn_wr_id'];
             				unset($sqlWri);
             				$sql = 'select * from learn_writing_result WHERE lwr_wri_id = '.$ilesson;
             			}
             			if (checkLearn($unit,'speaking') == 1) {
             				$sqlSpe     = new db_query('SELECT * FROM learn_speaking WHERE learn_unit_id = '.$unit);
             				$row        = mysqli_fetch_assoc($sqlSpe->result);
             				$ilesson    = $row['learn_sp_id'];
             				unset($sqlSpe);
             				$sql = 'select * from learn_speak_result WHERE lsr_spe_id = '.$ilesson;
             			}
                    break;
             	    case "write"   :
             	   		$sqlWri      = new db_query('SELECT * FROM learn_writing WHERE learn_unit_id = '.$unit);
            			$row         = mysqli_fetch_assoc($sqlWri->result);
             			$ilesson     = $rowWri['learn_wr_id'];
             			unset($sqlWri);
             			$sql = 'select * from learn_writing_result WHERE lwr_wri_id = '.$ilesson;
         			break;
             		case "speak" :
             			$sqlSpe     = new db_query('SELECT * FROM learn_speaking WHERE learn_unit_id = '.$unit);
             			$row        = mysqli_fetch_assoc($sqlSpe->result);
             			$ilesson    = $row['learn_sp_id'];
             			unset($sqlSpe);
             			$sql = 'select * from learn_speak_result WHERE lsr_spe_id = '.$ilesson;
         			break;
                }
                $rsd = mysql_query($sql);
            	if ($rsd != NULL){
            		$count = mysqli_num_rows($rsd);
            		$pages = ceil($count/$per_page);
            	} ?>

                <script type="text/javascript">
                $(document).ready(function(){
                	$("#paging_button li").click(function(){
                		$("#paging_button li").css({'background-color' : '', 'color' : '#000'});
                		$(this).css({'background-color' : '#006699' , 'color' : '#FFF'});
                		$("#list_other").load("http://<?=$base_url?>/ajax/data_user_lear_v2.php?type=<?=$type?>&ilesson=<?=$ilesson?>&unit=<?=$unit?>&page=" + this.id);
                		return false;
                	});
                	$("#1").css({'background-color' : '#006699' , 'color' : '#FFF'});
                	$("#list_other").load("http://<?=$base_url?>/ajax/data_user_lear_v2.php?type=<?=$type?>&ilesson=<?=$ilesson?>&unit=<?=$unit?>&page=1");
                });
                </script>
			</div>
		</div>
		<div class="clearfix"></div>
	</div>

<script type="text/javascript">
$(document).ready(function() {
    var baseurl =  'http://<?=$base_url?>';
    $('a.button_hoan_thanh_wr').click(function (){
        <?php if($myuser->logged == 1){
            if($check_learn == 0){
        ?>
        $(this).css("display","none");
	    var id_sp = $('#id_sp').attr('value');
	    var input_text = strname;
        var script_spk = $('#script_spk').val();
        $.ajax({
            type : 'POST',
            data : {
                type : "speak",
                id   : id_sp,
                input: input_text,
                script: script_spk,
            },
            url  : 'http://<?=$base_url?>/ajax/ajax_save_learn_v2.php',
            success:function(data){
                var getdata = $.parseJSON(data);
                suc     = getdata.suc;
                error   = getdata.error;
                if (suc == 0){
                    alert(error);
                    window.location.reload();
                }
                if (suc == 1){
                    alert(error);
                    window.location.reload();
                }
            }
        });
        <?php }else{ ?>
            alert('Bạn đã hoàn thành bài học này trước đây, mỗi học viên chỉ được gửi bài một lần');
        <?php } } ?>
    });
});
</script>
<?php } ?>

