<?php
require_once("../home/config.php");
$var_path_js     = '/themes/js/';
$result_id = getValue("result_id","int","GET",0);
$type = getValue("type","str","GET","");

if($type == "speaking"){

$dbgetRecording = new db_query("SELECT * FROM learn_speak_result WHERE lsr_id =".$result_id." AND lsr_status = 0");
$arrRecording = $dbgetRecording->resultArray();
$urlfile = "http://".$base_url."/js/data_record/".$arrRecording[0]['lsr_audio'];
?>


<link href="<?=$var_path_js?>/jplayer/skin/blue.monday/jplayer.blue.monday.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?=$var_path_js?>/jplayer/jquery.jplayer.min.js"></script>
<script type="text/javascript">                                
   $(document).ready(function(){ $('a.media').media( { 'backgroundColor' : 'transparent' , width: 300, height: 20 } ); });
</script>

<script type='text/javascript'>
	$(document).ready(function(){
	$('#result').jPlayer({
		ready: function (event) {
			$(this).jPlayer('setMedia', {
				wav:'<?=$urlfile?>',
			});
		},
		cssSelectorAncestor: '#playcon',
		swfPath: 'js',
		supplied: 'wav',
		wmode: 'window'
	});
});
</script>
	<div id="result" class="jp-jplayer"></div>
	<div id="playcon" class="jp-audio">
		<div class="jp-type-single">
			<div class="jp-gui jp-interface">
				<ul class="jp-controls">
					<li><a href="javascript:;" class="jp-play" tabindex="1">play</a></li>
					<li><a href="javascript:;" class="jp-pause" tabindex="1">pause</a></li>
					<li><a href="javascript:;" class="jp-stop" tabindex="1">stop</a></li>
					<li><a href="javascript:;" class="jp-mute" tabindex="1" title="mute">mute</a></li>
					<li><a href="javascript:;" class="jp-unmute" tabindex="1" title="unmute">unmute</a></li>
					<li><a href="javascript:;" class="jp-volume-max" tabindex="1" title="max volume">max volume</a></li>
				</ul>
				<div class="jp-progress">
					<div class="jp-seek-bar">
						<div class="jp-play-bar"></div>
					</div>
				</div>
				<div class="jp-volume-bar">
					<div class="jp-volume-bar-value"></div>
				</div>
				<div class="jp-time-holder">
					<div class="jp-current-time"></div>
					<div class="jp-duration"></div>

					<ul class="jp-toggles">
						<li><a href="javascript:;" class="jp-repeat" tabindex="1" title="repeat">repeat</a></li>
						<li><a href="javascript:;" class="jp-repeat-off" tabindex="1" title="repeat off">repeat off</a></li>
					</ul>
				</div>
			</div>
			<div class="jp-no-solution">
				<span>Update Required</span>
				To play the media you will need to either update your browser to a recent version or update your <a href="http://get.adobe.com/flashplayer/" target="_blank">Flash plugin</a>.
			</div>
		</div>
	</div>

	<div class="giaovienchamdiem">
		<input class="ipgiaodienchamdiem ipgiaodienchamdiem_<?=$result_id?>" placeholder="Số điểm">
		<textarea class="txtgiaovienchamdiem txtgiaovienchamdiem_<?=$result_id?>" placeholder="Nhận xét"></textarea>
		<span class="requestsendscore" onclick="request_score_speaking(<?=$result_id?>)">
			Chấm điểm
		</span>
	</div>

<?
}else{
	$dbgetWriting = new db_query("SELECT * FROM learn_writing_result WHERE lwr_id =".$result_id." AND lwr_status = 0");
	$arrWriting = $dbgetWriting->resultArray();
	?>
		<textarea class="txtgiaovienchamdiem">
			<?=$arrWriting[0]['lwr_content']?>
		</textarea>
		<div class="giaovienchamdiem">
			<input class="ipgiaodienchamdiem ipgiaodienchamdiemviet_<?=$result_id?>" placeholder="Số điểm">
			<textarea class="txtgiaovienchamdiem txtgiaovienchamdiemviet_<?=$result_id?>" placeholder="Nhận xét"></textarea>
			<span class="requestsendscore" onclick="request_score_writing(<?=$result_id?>)">
				Chấm điểm
			</span>
		</div>
<? } ?>

<script type="text/javascript">
	function request_score_speaking(lsr_id){
        var baseurl =  'http://<?=$base_url?>';
	    var score = $(".ipgiaodienchamdiem_"+lsr_id).val();
	    var nx  = $(".txtgiaovienchamdiem_"+lsr_id).val();
        $.ajax({
            type : 'POST',            		  
            data : {
                type : "score_speaking", 
                score : score, 
                nx : nx,
                lsr_id:lsr_id
            },
            url  : 'http://<?=$base_url?>/ajax/request.php',
            success:function(data){
				if($.trim(data) == 1){
					alert('Chấm bài thành công');	
				}else{
					alert('Xảy ra lỗi trong quá trình xử lý');
				}
	      	}
        });		  
    }          

    function request_score_writing(lwr_id){
        var baseurl =  'http://<?=$base_url?>';
	    var score = $(".ipgiaodienchamdiemviet_"+lwr_id).val();
	    var nx  = $(".txtgiaovienchamdiemviet_"+lwr_id).val();
        $.ajax({
            type : 'POST',            		  
            data : {
                type : "score_writing", 
                score : score, 
                nx : nx,
                lwr_id:lwr_id
            },
            url  : 'http://<?=$base_url?>/ajax/request.php',
            success:function(data){
				if($.trim(data) == 1){
					alert('Chấm bài thành công');	
				}else{
					alert('Xảy ra lỗi trong quá trình xử lý');
				}
	      	}
        });		  
    }          
</script>