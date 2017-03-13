<div class="guideques">
	<?=$valueBlock['com_block_data_name']?>
</div>
<?php
$in = 0;
$db_query_content_ques = new db_query("SELECT * FROM courses_multi_tab_questions WHERE cou_tab_question_block_id=".$valueBlock['com_block_id']." AND cou_tab_question_type = 'multiplechoice' ORDER BY cou_tab_question_order");
$arrContentQues = $db_query_content_ques->resultArray();
$countquesmultiplechoi = count($arrContentQues);
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

	<?php if($valueContentQuest['cou_tab_question_content'] != " "){ ?>
	<div class="wrap_ques_multiplechoice">
		<div class="tip_learn_main_content_title">
			<?=removeHTML($valueContentQuest['cou_tab_question_content'])?>
		</div>
		<div class="result_ques" style="display:none;">
			<span class="sptrue_<?=$valueBlock['com_block_id']?>_<?=$in?>"></span>
		</div>
		<?php
			$sqlAns    = new db_query("SELECT * FROM courses_multi_tab_answers WHERE cou_tab_answer_question_id = ".$valueContentQuest['cou_tab_question_id']);
			$arrayT    = array(1=>'A',2=>'B',3=>'C',4=>'D',5=>'E');
			$iA        = 0;
			while($rowAns = mysqli_fetch_assoc($sqlAns->result)){
				$iA ++;	?>
		            <div class="check_box-muc">
                    <input class="ip_valuecheck_<?=$valueBlock['com_block_id']?>_<?=$in?>_<?=$iA?>" id="checke<?=$in?>_<?=$iA?>" name="chec_box<?=$in?>" type="radio" value="<?=$rowAns['cou_tab_answer_true']?>" />
                    <label class="lb_valuecheck_<?=$valueBlock['com_block_id']?>_<?=$in?>_<?=$iA?>" for="checke<?=$in?>_<?=$iA?>"><?=$arrayT[$iA]?>. <?=$rowAns['cou_tab_answer_content']?></label>
                </div>
        	<?php } ?>
        	<input type="hidden" class="totalansmultiplechoice_<?=$valueBlock['com_block_id']?>_<?=$in?>" value="<?=$iA?>">
		<?php } ?>
	</div>
<?php } ?>
<span onclick="resultquesmultiplechoice(<?=$valueBlock['com_block_id']?>)" class="result_score"> Chữa bài </span>

<script type="text/javascript">
	function resultquesmultiplechoice(block_id){
		$(".result_ques").hide();
		var i = 1;
		var j = 1;
		var totalques = <?=$countquesmultiplechoi?>;
		for(i = 1; i <= totalques; i++){
			var totalansinques = $(".totalansmultiplechoice_"+block_id+"_"+i).val();
			for(j = 1;j<= totalansinques;j++ ){
				$(".lb_valuecheck_"+block_id+"_"+i+"_"+j).css("color","rgb(102, 102, 102)");
				if($(".ip_valuecheck_"+block_id+"_"+i+"_"+j).val() == 1){
					$(".lb_valuecheck_"+block_id+"_"+i+"_"+j).css("color","rgb(9, 199, 179)");
				}
				if($(".ip_valuecheck_"+block_id+"_"+i+"_"+j).prop('checked')){
					var ucheck = $(".ip_valuecheck_"+block_id+"_"+i+"_"+j+":checked").val();
					if(ucheck != 1){
						$(".lb_valuecheck_"+block_id+"_"+i+"_"+j).css("color","rgb(176, 0, 0)");
						$(".result_ques").show();
						$(".sptrue_"+block_id+"_"+i).html("Sai");
					}else{
						$(".lb_valuecheck_"+block_id+"_"+i+"_"+j).css("color","rgb(9, 199, 179)");
						$(".result_ques").show();
						$(".sptrue_"+block_id+"_"+i).html("Đúng");
						$(".sptrue_"+block_id+"_"+i).css("background","rgb(9, 199, 179)");
					}
				}
			}
		}
	}
</script>