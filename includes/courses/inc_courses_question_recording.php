<div class="guideques"><?=$valueBlock['com_block_data_name']?></div>
<div class="alert alert-info-speak">
    Giả lập nghe nói với người bản ngữ. Bạn hãy xem Video để nghe câu hỏi & bấm vào nút <img src="http://<?=$base_url?>/themes/img/start_record.jpg" alt="Start record" /> để ghi âm câu trả lời.
</div>
<?php
$in = 0;
$db_query_content_ques = new db_query("SELECT * FROM courses_multi_tab_questions WHERE cou_tab_question_block_id=".$valueBlock['com_block_id']." AND cou_tab_question_type = 'recording' ORDER BY cou_tab_question_order");
$arrContentQues = $db_query_content_ques->resultArray();
foreach($arrContentQues as $keyContentQuest => $valueContentQuest){ $in++;?>

	<?php if($valueContentQuest['cou_tab_question_paragraph'] != " "){ ?>
		<div class="learn_main_content_text">
			<?=$valueContentQuest['cou_tab_question_paragraph']?>
		</div>
	<?php } ?>

	<?php if($valueContentQuest['cou_tab_question_media'] != ""){ ?>
		<div class="learn_main_content_media">
			<?php if($valueContentQuest['cou_tab_question_media_type'] == 1){ ?>
				<?php $mainpart = 'http://'.$base_url.'/data/courses/'; ?>
				<?=get_media_library_v2($mainpart.strtolower($valueContentQuest['cou_tab_question_media']),'')?>
			<?php } ?>

			<?php if($valueContentQuest['cou_tab_question_media_type'] == 2){ ?>
				<?php $mainpart = 'http://'.$base_url.'/data/courses/'; ?>
				<?
            	$urlfile = getURL(1,0,0,0).'data/courses/'.$valueContentQuest['cou_tab_question_media'];
            	$ref = "q".$valueContentQuest['cou_tab_question_id'];
            	$showaudio = showaudio($urlfile,$ref);
            	echo $showaudio;
            	?>
                <a class="media" href="<?=getURL(1,0,0,0)?>/data/courses/<?=$valueContent['cou_tab_cont_media']?>"></a>
			<?php } ?>

			<?php if($valueContentQuest['cou_tab_question_media_type'] == 3){ ?>
				<?php $mainpart = 'http://'.$base_url.'/data/courses/'; ?>
				<img src="<?=$mainpart.$valueContentQuest['cou_tab_question_media']?>">
			<?php } ?>
		</div>
	<?php } ?>

	<?php if($valueContentQuest['cou_tab_question_title'] != " "){ ?>
		<div class="learn_main_content_title">
			<?=removeHTML($valueContentQuest['cou_tab_question_title'])?>
		</div>
	<?php } ?>

	<?php if($valueContentQuest['cou_tab_question_content'] != " "){ ?>
		<div class="learn_main_content_text">
			<?=($valueContentQuest['cou_tab_question_content'])?>
		</div>
	<?php } ?>
	

<?php } ?>

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
    <div class="btn_wr">
        <a class="arecording" onClick="request_recording(<?=$valueContentQuest['cou_tab_question_id']?>)" class="button_hoan_thanh_wr">Hoàn thành</a>
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
            $urlRec = '/data_record/';
        }
    ?>

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
    </script>

    <script type="text/javascript">
        var strname = '';
        function getname() {
            name = randomString();
            //alert(name);
        }
        function record() {            
                strname += name+'.wav'
            num_ques = $(".get_num").text();
                Wami.startRecording('http://<?=$base_url?>/js<?=$urlRec?>record.php?name='+name+'.wav','onRecordStart','onRecordFinish','onError');   
        }
        function play(name_au) {
                Wami.startPlaying("http://<?=$base_url?>/js<?=$urlRec?>"+name_au+".wav","onPlayStart", "onPlayFinish", "onError");
        }
    </script>