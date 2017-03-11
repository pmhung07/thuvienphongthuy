<?php
require_once("../home/config.php");
$uid = getValue("uid","int","GET",0);
$dbgetRecording = new db_query("SELECT * FROM learn_speak_result WHERE lsr_use_id =".$uid);
$arrRecording = $dbgetRecording->resultArray();
$dbgetWriting = new db_query("SELECT * FROM learn_writing_result WHERE lwr_use_id =".$uid);
$arrWriting = $dbgetWriting->resultArray();

?>
<div class="listing_quest_result_recording">
	Danh sách câu trả lời phần Ghi âm
</div>
<div class="list_student_details_head">
	<div class="list_student_details_head_col_1">ID</div>
	<div class="list_student_details_head_col_2">Block Câu hỏi</div>
	<div class="list_student_details_head_col_3">Thời gian gửi</div>
	<div class="list_student_details_head_col_4">Chi tiết</div>
</div>
<?php $i = 1; foreach($arrRecording as $key => $value){ ?>
	
	<?php
	$db_selectLink = new db_query("SELECT * FROM courses_multi_tab_questions a,courses_multi_tabs b,courses_multi c
							   WHERE a.cou_tab_question_tabs_id = b.cou_tab_id AND b.cou_tab_com_id = c.com_id 
							   AND cou_tab_question_id =".$value['lsr_spe_id']);
	$arrLink = $db_selectLink->resultArray();
	?>

	<div class="list_student_details_head">
		<div class="list_student_details_head_col_show_1"><?=$i?></div>
		<div class="list_student_details_head_col_show_2">
			<a target="_blank" href="<?=gen_course_lesson($arrLink[0]['com_cou_id'],'REVIEW',$arrLink[0]['com_id'],$arrLink[0]['cou_tab_id'],$arrLink[0]['com_name'])?>">
				URL Bài Học
			</a>
		</div>
		<div class="list_student_details_head_col_show_3"><?=date("d/m/Y h:i:s",$value['lsr_date'])?></div>
		<?php if($value['lsr_status'] == 0){ ?>
		<div class="list_student_details_head_col_show_4">
			<a class="chamdiem" onclick="resultquizdetails(<?=$value["lsr_id"]?>,'speaking','s')">Chấm điểm</a>	
		</div>
		<?php }else{ ?>
		<div class="list_student_details_head_col_show_4">
			<a class="chamdiem">Đã chấm</a>	
		</div>
		<?}?>
	</div>
	<div style="display:none;" class="result_details_ques_mark result_details_ques_mark_s_<?=$value['lsr_id']?>"></div>
<?php $i++;} ?>

<div class="listing_quest_result_writing">
	Danh sách câu trả lời phần Viết bài
</div>
<div class="list_student_details_head">
	<div class="list_student_details_head_col_1">ID</div>
	<div class="list_student_details_head_col_2">Câu hỏi</div>
	<div class="list_student_details_head_col_3">Thời gian gửi</div>
	<div class="list_student_details_head_col_4">Chi tiết</div>
</div>
<?php $i = 1; foreach($arrWriting as $key => $value){ ?>
<?php
	$db_selectLink = new db_query("SELECT * FROM courses_multi_tab_questions a,courses_multi_tabs b,courses_multi c
							   WHERE a.cou_tab_question_tabs_id = b.cou_tab_id AND b.cou_tab_com_id = c.com_id 
							   AND cou_tab_question_id =".$value['lwr_wri_id']);
	$arrLink = $db_selectLink->resultArray();
?>
<div class="list_student_details_head">
	<div class="list_student_details_head_col_show_1"><?=$i?></div>
	<div class="list_student_details_head_col_show_2">
		<a target="_blank" href="<?=gen_course_lesson($arrLink[0]['com_cou_id'],'REVIEW',$arrLink[0]['com_id'],$arrLink[0]['cou_tab_id'],$arrLink[0]['com_name'])?>">
			URL Bài Học
		</a>
	</div>
	<div class="list_student_details_head_col_show_3"><?=date("d/m/Y h:i:s",$value['lwr_date'])?></div>
	<?php if($value['lwr_status'] == 0){ ?>
	<div class="list_student_details_head_col_show_4">
		<a class="chamdiem" onclick="resultquizdetails(<?=$value["lwr_id"]?>,'writing','w')">Chấm điểm</a>	
	</div>
	<?php }else{ ?>
		<div class="list_student_details_head_col_show_4">
			<a class="chamdiem">Đã chấm</a>	
		</div>
	<?}?>
</div>

<div style="display:none;" class="result_details_ques_mark result_details_ques_mark_w_<?=$value['lwr_id']?>"></div>

<?php $i++;} ?>

<script type="text/javascript">
function resultquizdetails(result_id,type,typeans){
	var baseurl = 'http://<?=$base_url?>';
	$(".result_details_ques_mark").empty();

    $(".result_details_ques_mark_"+typeans+"_"+result_id).fadeIn(400);
	$(".result_details_ques_mark_"+typeans+"_"+result_id).load(baseurl+'/ajax/mark_quiz_details.php?result_id='+result_id+'&type='+type);
}
</script>