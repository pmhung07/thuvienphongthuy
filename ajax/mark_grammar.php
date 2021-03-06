<?php
require_once("../home/config.php");

$iUnit       = getValue("iunit","int","GET","");
$unit        = getValue("unit","int","GET","");
$sqlUnit     = new db_query('SELECT b.cou_name,a.com_cou_id,a.com_id,a.com_name,a.com_num_unit
                                  FROM courses_multi a,courses b
                                 WHERE a.com_cou_id = b.cou_id AND com_id = '.$unit);

while($rowUnit = mysqli_fetch_assoc($sqlUnit->result)){
    $nUnit       = $rowUnit['com_name'];
    $iCou        = $rowUnit['com_cou_id'];
    $nCou        = $rowUnit['cou_name'];
}

unset($sqlUnit);
$num         = getValue("num","int","GET","");
$type        = getValue("type","int","GET","");
$nAns        = getValue("nAns","int","GET","");
$urlPoint    = "";
$point       = 0;
$in          = 0;
$iUnitGram   = "";
//===============================================//
if($type == 1){
    if($nAns!=0){
        for($i = 1; $i <= $nAns; $i++){
            $idAns[$i]       = getValue("idAns".$i,"int","GET","");
            $urlPoint       .= $idAns[$i].'&';
            if($idAns[$i]!=0){
                $sqlAns          = new db_query('SELECT * FROM answers WHERE ans_id ='.$idAns[$i]);
                while($rowAns    = mysqli_fetch_assoc($sqlAns->result)){
                    $ans[$i]     = $rowAns["ans_true"];
                    if ($ans[$i] == 1) $point++;
                }
            }
        }
    }

}else{
    $sqlQuick    = new db_query('SELECT * FROM exercises WHERE exe_type = 1 AND exe_type_lesson = 2 AND exe_com_id = '.$unit);
    if($nAns!=0){
        for($i = 1; $i <= $nAns; $i++){
            $value[$i]       = getValue("value".$i,"str","GET","");
            $value[$i]       = strtolower($value[$i]);
		    $strVl[$i]       = str_replace("\'","",$value[$i]);
            $urlPoint       .= $strVl[$i].'&&';
        }
    }
    while($rowQuick  = mysqli_fetch_assoc($sqlQuick->result)){

        $sqlQues = new db_query('SELECT * FROM questions WHERE que_exe_id = '.$rowQuick["exe_id"]);
        while($rowQues = mysqli_fetch_assoc($sqlQues->result)){
            $in ++;
            if(($rowQues['que_type']== 3) || ($rowQues['que_type']== 2)){
                $arrayAns  = getStringAns($rowQues['que_content']);
                $result    = count($arrayAns);
                $j = 1;
                for($i=0;$i<$result;$i++) {
    				$arrayAns[$i] = trim($arrayAns[$i]);
                    $arrayAns[$i] = str_replace (' ', '_', $arrayAns[$i]);
    				$arrayAns[$i] = str_replace("'","",$arrayAns[$i]);
                    if ($arrayAns[$i] == $value[$j]){
                        $point ++;
                    }$j++;
                }
            }
        }
    }
}?>

<script src="<?=$var_path_js?>/jquery-1.7.2.js"></script>
<script type="text/javascript" src="<?=$var_path_js?>jquery.fancybox.pack.js"></script>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="<?=$var_path_css?>lightbox.css"/>
<title>Kết quả</title>
<script type="text/javascript">
$(document).ready(function() {
	$(".show").click(function(){
		$('#frm').submit();
	});
});
</script>
</head>

<body>
<div id="result_lb">
    <div class="lb_top">Kết quả bài đã làm</div>
    <div class="middle_cont">
        <div class="line">
            <span class="section">Bạn đã trả lời đúng</span> : <span class="result"> <?=$point?> / <?=$nAns?> câu .</span>
        </div>
    </div><!-- End .middle_cont -->
    <form name="frm" id="frm" action="<?=gen_course_details_edit($nCou,$iCou,$unit,"grammar")?>" method="post">
        <input type="hidden" name="iunit" value="<?=$iUnit?>" />
        <input type="hidden" name="unit"  value="<?=$unit?>" />
        <input type="hidden" name="num"  value="<?=$num?>" />
        <input type="hidden" name="nAns" value="<?=$nAns?>" />
        <input type="hidden" name="url" value="<?=gen_course_details(0,$unit)?>?>" />
        <input type="hidden" name="urlPoint" value="<?=$urlPoint?>"/>
    </form>
    <div class="bottom_cont" id="skill">
        <div class="around">
            <a class="back act_button" href="<?=gen_course_details(0,$unit)?>">&lt;  Làm lại</a>
            <a class="show act_button">Xem bài chữa  &gt;</a>
        </div>
    </div>
</div><!-- End #result_lb -->
</body>
</html>