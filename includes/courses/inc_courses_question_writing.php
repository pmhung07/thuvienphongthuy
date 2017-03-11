<div class="guideques"><?=$valueBlock['com_block_data_name']?></div>
<?php
$in = 0;
$db_query_content_ques = new db_query("SELECT * FROM courses_multi_tab_questions WHERE cou_tab_question_block_id=".$valueBlock['com_block_id']." AND cou_tab_question_type = 'writing' ORDER BY cou_tab_question_order");
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
	<div class="sendwriteuserdetails">
		<textarea class="sendwriteuser sendwritinguser_<?=$valueContentQuest['cou_tab_question_id']?>">

		</textarea>
		<span class="requestsendwrite" onclick="sendwriting(<?=$valueContentQuest['cou_tab_question_id']?>)">
			Gửi bài
		</span>
	</div>
<?php } ?>
