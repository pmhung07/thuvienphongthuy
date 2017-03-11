<div class="guideques"><?=$valueBlock['com_block_data_name']?></div>
<?php 
$db_query_content_ques = new db_query("SELECT * FROM courses_multi_tab_questions WHERE cou_tab_question_block_id=".$valueBlock['com_block_id']." AND cou_tab_question_type = 'matching' ORDER BY cou_tab_question_order");
$arrContentQues = $db_query_content_ques->resultArray();
foreach($arrContentQues as $keyContentQuest => $valueContentQuest){ ?>

	<?php if($valueContentQuest['cou_tab_question_paragraph'] != ""){ ?>
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
			<?php } ?>

			<?php if($valueContentQuest['cou_tab_question_media_type'] == 3){ ?>
				<?php $mainpart = 'http://'.$base_url.'/data/courses/'; ?>
				<img src="<?=$mainpart.$valueContentQuest['cou_tab_question_media']?>">
			<?php } ?>
		</div>
	<?php } ?>

	<?php if($valueContentQuest['cou_tab_question_title'] != ""){ ?>
		<div class="learn_main_content_title">
			<?=removeHTML($valueContentQuest['cou_tab_question_title'])?>
		</div>
	<?php } ?>

	<?php if($valueContentQuest['cou_tab_question_content'] != ""){ ?>
		<div class="learn_main_content_text">
			<?
			$arrayCont  =  getMainC($valueContentQuest['cou_tab_question_content']);
				$cArrayCont =  count($arrayCont);
			?>
			<div class="ques_matching">
			<?php
            $j = 0;
            for($i=0;$i<$cArrayCont;$i++){
                if($i%2 != 0) { 
                    $j ++;
                    echo '<input type=text value=""/> <span class="matchingtrue" style="display:none;">( '.$arrayCont[$i].' )</span>';
                }else{
       	            echo $arrayCont[$i];
                }                 
            } ?>
            </div>

		</div>
	<?php } ?>
<?php } ?>	

<?php 
$db_query_content_ques = new db_query("SELECT * FROM courses_multi_tab_questions WHERE cou_tab_question_block_id=".$valueBlock['com_block_id']." AND cou_tab_question_type = 'draganddrop' ORDER BY cou_tab_question_order");
$arrContentQues = $db_query_content_ques->resultArray();
foreach($arrContentQues as $keyContentQuest => $valueContentQuest){ ?>

	<?php if($valueContentQuest['cou_tab_question_paragraph'] != ""){ ?>
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
			<?php } ?>

			<?php if($valueContentQuest['cou_tab_question_media_type'] == 3){ ?>
				<?php $mainpart = 'http://'.$base_url.'/data/courses/'; ?>
				<img src="<?=$mainpart.$valueContentQuest['cou_tab_question_media']?>">
			<?php } ?>
		</div>
	<?php } ?>

	<?php if($valueContentQuest['cou_tab_question_title'] != ""){ ?>
		<div class="learn_main_content_title">
			<?=removeHTML($valueContentQuest['cou_tab_question_title'])?>
		</div>
	<?php } ?>

	<?php if($valueContentQuest['cou_tab_question_content'] != ""){ ?>

	<?php
	$arrayAns  = getStringAns(removeHTML($valueContentQuest['cou_tab_question_content']));
	$result    = count($arrayAns);
	$rand_keys = array_random($arrayAns, $result);                                
	?>
	&nbsp;
	<ul class="menu_quiz">
		<?php for($i=0;$i<$result;$i++){?>
			<a><?=$i+1?>.<span id="draggable<?=$i+1?>"><?=trim($rand_keys[$i])?></span></a>
		<?php } ?>   
	</ul>
	<div class="tip_learn_main_content_title">
		Chọn đáp án thich hợp ở trên và điền vào chỗ trống
	</div>
    <div class="learn_main_content_text">
		<?
		$arrayCont  =  getMainC($valueContentQuest['cou_tab_question_content']);
			$cArrayCont =  count($arrayCont);
		?>
		<div class="ques_matching">
		<?php
        $j = 0;
        for($i=0;$i<$cArrayCont;$i++){
            if($i%2 != 0) { 
                $j ++;
                echo '<input type=text value=""/> <span class="matchingtrue" style="display:none;"> ( '.$arrayCont[$i].' ) </span>';
            }else{
   	            echo $arrayCont[$i];
            }                 
        } ?>
        </div>

	</div>
	<?php } ?>
<?php } ?>

<span onclick="resultquesmatching(<?=$valueBlock['com_block_id']?>)" class="result_score"> Chữa bài </span>
<script type="text/javascript">
	function resultquesmatching(block_id){
		$(".matchingtrue").show();
		$(".matchingtrue").css('color','rgb(176, 0, 0)');
	}
</script>