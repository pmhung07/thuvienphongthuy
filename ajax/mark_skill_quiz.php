<?php
require_once("../home/config.php");

$numc           = 0;
$true1          = 0;
$true2          = 0;
$iles           = getValue("iles","int","GET","");
$db_les         = new db_query('SELECT * FROM skill_lesson WHERE skl_les_id = '.$iles.' AND skl_les_active = 1');
$row_les        = mysqli_fetch_assoc($db_les->result);
unset($db_les);

$db_cate = new db_query('SELECT cat_id,cat_name,cat_parent_id FROM categories_multi WHERE cat_id = '.$row_les["skl_les_cat_id"]);
$row_cate = mysqli_fetch_assoc($db_cate->result);
unset($db_cate);

$iCont       = getValue("icont","int","GET","");
$nAns        = getValue("nAns","int","GET","");
$urlPoint    = "";
$value       = array();
$point       = 0;
$total1      = 0;
$total2      = 0;
$total3      = 0;

//=============================================//
for($i = 1 ;$i <= $nAns;$i++){
    $type[$i]    = getValue("type".$i,"int","GET","");
        if($type[$i] == 1){
            $total1++;
            $urlPoint       .= '1&';
            $idAns[$i]       = getValue("idAns".$i,"int","GET","");
            $urlPoint       .= $idAns[$i].'||';
            if($idAns[$i]!=0){
                $sqlAns          = new db_query("SELECT * FROM answers WHERE ans_id =".$idAns[$i]);
                while($rowAns    = mysqli_fetch_assoc($sqlAns->result)){
                    $ans[$i]     = $rowAns["ans_true"];
                    if ($ans[$i] == 1) {
                        $point++;
                    }
                }
            }
        }else{
            $numAns[$i]    = getValue("numAns".$i,"int","GET","");
            $urlPoint     .= $type[$i].'&'.$numAns[$i].'#';
            for($ia = 1; $ia <= $numAns[$i]; $ia++){
                $value[$i][$ia]       = getValue("value".$i."_".$ia,"str","GET","");
                $urlPoint       .= $value[$i][$ia].'$$';
            }
            if($type[$i] == 2) $total2 = $total2 + $numAns[$i];
            else if($type[$i] == 3) $total3 = $total3 + $numAns[$i];

		    $urlPoint     .= '||';
            $sqlQuick    = new db_query('SELECT * FROM exercises WHERE exe_type = 0 AND exe_skl_cont_id = '.$iCont);
            while($rowQuick  = mysqli_fetch_assoc($sqlQuick->result)){
                $sqlQues     = new db_query('SELECT * FROM questions WHERE que_type = '.$type[$i].' AND que_exe_id = '.$rowQuick["exe_id"]);
                while($rowQues = mysqli_fetch_assoc($sqlQues->result)){
                    $arrayAns  = getStringAns($rowQues['que_content']);
                    $result    = count($arrayAns);
                    $j = 1;
				    if ($type[$i] == 2){ $true1  = 0;  }elseif($type[$i] == 3) { $true2  = 0;}
                    for($ib=0;$ib<$result;$ib++){
						    $arrayAns[$ib] = trim($arrayAns[$ib]);
                        $arrayAns[$ib] = str_replace (' ', '_', $arrayAns[$ib]);
						    $arrayAns[$ib] = str_replace("'","",$arrayAns[$ib]);
                        if ($arrayAns[$ib] == strtolower($value[$i][$j])){
                            if ($type[$i] == 2){ $true1++; }elseif($type[$i] == 3) { $true2++;}
                        }$j++;
                    }
                }
            }
        }
    }
    $total = $total1 + $total2 + $total3;
    $total_true = $point + $true1 + $true2;
//=====================================================//
?>

<div id="quiz_box" class="quiz-box-skill">
    <?php
    $db_quiz = new db_query('SELECT * FROM skill_content
                                INNER JOIN exercises ON skl_cont_id = exe_skl_cont_id
                                    WHERE skl_cont_les_id = '.$iles.' AND exe_type = 0 LIMIT 1');
    $num_quiz = mysqli_num_rows($db_quiz->result);
    if($num_quiz > 0){
        $value      = array();
        $ans        = array();

        $strAns     = explode("||",$urlPoint);
      	$countans   = count($strAns);
      	for($j=0;$j < $countans ;$j++){
      	    $str        = explode("&",$strAns[$j]);
      		$counstr    = count($str);
  		    $type[$j]  = $str[0];
  		    if($type[$j] == 1){
  			    $idAns[$j+1] = $str[1];
                $ans[$j+1] = 0;
                $sqlAns = new db_query('SELECT * FROM answers WHERE ans_id ='.$idAns[$j+1]);
                while($rowAns = mysqli_fetch_assoc($sqlAns->result)){
                    $ans[$j+1] = $rowAns["ans_true"];
                }
  			}else{
  				if (isset($str[1])){
  					$strA = explode("#",$str[1]);
  					$counA = count($strA);
  					$numAns[$j+1] = $strA[0];
  					$strB = explode("$$",$strA[1]);
  					$counB = count($strB);
  					for($ib = 1; $ib < $counB; $ib++){
  						$value[$j+1][$ib]       = $strB[$ib-1];
  					}
  				}
  			}
      	}
    ?>

   <?php
    $in = 0;
    $classinput = "";
    $numA       = array();

    echo '<div class="quiz_cont'.$numc.'">';
    while($row_quiz = mysqli_fetch_assoc($db_quiz->result)){
        $sqlQues = new db_query('SELECT * FROM questions WHERE que_exe_id = '.$row_quiz["exe_id"].' ORDER BY que_type , que_order ASC');
        while($rowQues = mysqli_fetch_assoc($sqlQues->result)){
            $in ++;
            if($row_les['skl_les_type'] == 5){
                $sqlMedia    = new db_query("SELECT * FROM media_exercies WHERE media_id = ".$rowQues['que_media_id']);
                $rowMedia = mysqli_fetch_assoc($sqlMedia->result);
                $media_url = 'http://'.$base_url.'/data/skill_exercises/';
                if($rowMedia['media_type'] == 2){
                    echo "<embed width='300' height='24' type='application/x-shockwave-flash' src='http://".$base_url."/mediaplayer/player.swf' flashvars='file=".$media_url.$rowMedia['media_name'] ."'</embed>";
                }else{
                    echo get_media_quiz_skill($rowQues['que_media_id']); //Lay ra media cua cau hoi
                }
            }else{
                echo get_media_quiz_skill($rowQues['que_media_id']); //Lay ra media cua cau hoi
            }
            if($rowQues['que_type']== 1 ){ ?>
            <!--  bắt đầu hiển thị nội dung quick dạng chọn câu đúng -->
                <div>
                    <div>
                        <div class="cau_hoi"><?=$in?>.<?php echo $rowQues['que_content'] =   str_replace ('&&', '<br />', $rowQues['que_content']);  ?></div>
                        <?php
                        $sqlAns    = new db_query("SELECT * FROM answers WHERE ans_ques_id = ".$rowQues['que_id']);
                        $arrayT    = array(1=>'A',2=>'B',3=>'C',4=>'D',5=>'E');
                        $iA        = 0;
                        while($rowAns = mysqli_fetch_assoc($sqlAns->result)){
                            $iA ++; ?>
                            <span class="check_box"><input id="checke<?=$in?>_<?=$iA?>" name="chec_box<?=$in?>" type="radio" /><label style="cursor: pointer;<?php if($rowAns['ans_id'] == $idAns[$in]) {echo 'color:red;font-weight: bold;';} if($rowAns['ans_true'] == '1'){echo 'color:lime;font-weight: bold;';} ?>" for="checke<?=$in?>_<?=$iA?>"><?=$arrayT[$iA]?>. <?=$rowAns['ans_content']?></label></span>
                            <br />
                        <?php } ?>
                    </div>
                </div>
            <?php }elseif($rowQues['que_type']== 2 ){
                $arrayCont  =  getMainC($rowQues['que_content']);
                $cArrayCont =  count($arrayCont); ?>
                <div class="">
                    <div class="cau_hoi"><?=$in?>. Điền từ vào chỗ trống</div>
                    <?php
                    $j = 0;
                    for($i=0;$i<$cArrayCont;$i++){
                        if($i%2 != 0) {
                            $j ++;
                            $value[$in][$j] = str_replace ('_', ' ', $value[$in][$j]);
                            echo '&nbsp;<span style="color:red;font-weight: bold;">'.$value[$in][$j].'</span>&nbsp;<span style="color:lime;font-weight: bold;">('.$arrayCont[$i].')</span>&nbsp;';
                        }else{
                            echo $arrayCont[$i];
                        }
                    } ?>
                </div>
            <?php }elseif($rowQues['que_type']== 3 ){
                $arrayAns  = getStringAns($rowQues['que_content']);
                $result    = count($arrayAns);
                $rand_keys = array_rand($arrayAns, $result); ?>
                <div class="">
                    <div class="cau_hoi"><?=$in?>. Kéo thả từ thích hợp vào khoảng trống</div>
                    <div>*
                        <?php for($i=0;$i<$result;$i++) { ?>
                        	<a href="#"><?=$i+1?> . <span style="color: red;font-weight: bold;"><?=$arrayAns[$rand_keys[$i]]?></span></a>
                        <?php } ?>
                    </div>
                    <?php
                        $arrayCont  =  getMainC($rowQues['que_content']);
                        $cArrayCont =  count($arrayCont);
                        $j = 0;
                        for($i=0;$i<$cArrayCont;$i++){
                            if($i%2 != 0) {
                                $j ++;
   					            if ($value[$in][$j] != NULL){
                            	    $value[$in][$j] = str_replace ('_', ' ', $value[$in][$j]);
   					            }else{
   					 	            $value[$in][$j] = '';
   					            }
                                echo '&nbsp;<span class="ans" style="color:red;font-weight: bold;">'.$value[$in][$j].'</span>..<span class="anstrue" style="color:lime;font-weight: bold;">('.$arrayAns[$j-1].')</span>&nbsp;';
                            }else{
                                echo $arrayCont[$i];
                            }
                        } $numA[$in] = $j;
                    ?>
                </div>
            <?php } ?>
        <?php }unset($sqlQues);
        }unset($db_quiz);
    echo '</div>'; // End quiz land
    }?>
</div><!-- End #quiz_box -->

<div class="pull-left-skill-result">Số câu đúng: <span class="red"><?=$total_true?> / <?=$total?></span></div>