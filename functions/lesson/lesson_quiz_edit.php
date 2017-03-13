<?
function lesson_quiz_edit($unit,$unit_num,$unit_name){
    $var_path_js     =  '/themes_v2/js/';
    $var_path_css    =  '/themes_v2/css/';
    $base_url        =  $_SERVER['HTTP_HOST'];
    $var_head_lib2   = '<link rel="stylesheet" type="text/css" href="'.$var_path_css.'jquery-ui-1.8.16.custom.css" />';
    $var_head_lib2  .= '<script type="text/javascript" src="'.$var_path_js.'a/jquery.ui.js"></script>';
    $var_head_lib2  .= '<script type="text/javascript" src="'.$var_path_js.'a/jquery.editinplace.js"></script>';
    $var_head_lib2  .= '<script type="text/javascript" src="'.$var_path_js.'ui/jquery.ui.core.js"></script>';
    $var_head_lib2  .= '<script type="text/javascript" src="'.$var_path_js.'ui/jquery.ui.widget.js"></script>';
    $var_head_lib2  .= '<script type="text/javascript" src="'.$var_path_js.'ui/jquery.ui.mouse.js"></script>';
    $var_head_lib2  .= '<script type="text/javascript" src="'.$var_path_js.'ui/jquery.ui.draggable.js"></script>';
    $var_head_lib2  .= '<script type="text/javascript" src="'.$var_path_js.'ui/jquery.ui.droppable.js"></script>';
    $var_head_lib2  .= '<script type="text/javascript" src="'.$var_path_js.'slimScroll.min.js"></script>';
    $var_head_lib2  .= '<script type="text/javascript" src="http://'.$base_url.'/mediaplayer/jwplayer.js"></script>';
    $var_head_lib2  .= '<script type="text/javascript" src="'.$var_path_js.'lesson_page.js"></script>';

   $iUnit      = getValue("iunit","int","POST","");
   $unit       = getValue("unit","int","POST","");
   $url        = getValue("url","str","POST","");
   $qui  	   = getValue("type","str","GET","");
   $sqlCou     = new db_query("SELECT * FROM courses,courses_multi WHERE courses.cou_id = courses_multi.com_cou_id AND courses_multi.com_id = ".$unit);
   $rowCou     = mysqli_fetch_assoc($sqlCou->result);
   $iCou       = $rowCou['cou_id'];
   $nCou       = $rowCou['cou_name'];
   unset($sqlCou);

   $num        = getValue("num","int","POST","");
   $nAns       = getValue("nAns","int","POST","");
   $urlPoint   = getValue("urlPoint","str","POST","");
   $value      = array();
   $ans        = array();

	$strAns     = explode("||",$urlPoint);
	$countans   = count($strAns);
	for($j=0;$j < $countans ;$j++){
      $str        = explode("&",$strAns[$j]);
      $counstr    = count($str);
      $type[$j]  = $str[0];
      if($type[$j] == 1){
          $idAns[$j+1]      = $str[1];
             $ans[$j+1]      = 0;
             $sqlAns          = new db_query("SELECT * FROM answers WHERE ans_id =".$idAns[$j+1]);
             while($rowAns    = mysqli_fetch_assoc($sqlAns->result)){
                 $ans[$j+1]     = $rowAns["ans_true"];
             }
      }else{
			if (isset($str[1])){
				$strA        = explode("#",$str[1]);
				$counA       = count($strA);
				$numAns[$j+1]    =$strA[0];
				$strB        = explode("$$",$strA[1]);
				$counB       = count($strB);
				for($ib = 1; $ib < $counB; $ib++){
					$value[$j+1][$ib]       = $strB[$ib-1];
				}
			}
		}
	}


   $sqlQuick   = new db_query("SELECT * FROM exercises WHERE exe_type = 0 AND exe_com_id = ".$unit);
	//Lay thong tin Unit
   $db_unit = new db_query("SELECT * FROM courses_multi WHERE com_id = ".$unit);
   $row_unit = mysqli_fetch_assoc($db_unit->result);
   unset($db_unit);
?>
   <?=$var_head_lib2?>
   <script src="<?=$var_path_js?>jquery.media.js"></script>
   <script type="text/javascript">
      var urlPoint      =   "";
      var baseurl       =  'http://<?=$base_url?>';
      $(document).ready(function(){
           $('a.media').media( { 'backgroundColor' : 'transparent' , width: 300, height: 20 } );
      });
   </script>
   <div class="in_content_v2">
		<h2 class="lesson-content-title" style="padding: 0px 0px 0px 20px;" title="Bài <?=$unit_num?>: <?=$unit_name?> - Quiz">
			Bài <?=$unit_num?>: <?=$unit_name?> - Quiz
		</h2>
      <div class="clearfix"></div>
   	<div class="lesson-content-right" style="width: 980px;">
   		<div class="gray-box1" style="">
            <?php
					$in = 0;
					$classinput = "";
					$numA       = array();
					while($rowQuick  = mysqli_fetch_assoc($sqlQuick->result)){
						$sqlQues     = new db_query("SELECT * FROM questions WHERE que_exe_id = ".$rowQuick['exe_id']." ORDER BY que_type , que_order ASC");
						while($rowQues = mysqli_fetch_assoc($sqlQues->result)){
							$in ++;
							$type[$in] = $rowQues['que_type'];
							echo get_media_quiz($rowQues['que_media_id']);
							if($rowQues['que_type']== 1 ){
                        ?>
                        <!--  bắt đầu hiển thị nội dung quick dạng chọn câu đúng -->
                        <div style="width: 100%;overflow: hidden;">
                        <h1 class="cau_hoi" style=""><?=$in?>.<?php echo $rowQues['que_content'] =   str_replace ('&&', '<br />', $rowQues['que_content']);  ?></h1>
                     	<?php
                     		$sqlAns    = new db_query("SELECT * FROM answers WHERE ans_ques_id = ".$rowQues['que_id']);
                     		$arrayT    = array(1=>'A',2=>'B',3=>'C',4=>'D',5=>'E');
                     		$iA        = 0;
                     		while($rowAns = mysqli_fetch_assoc($sqlAns->result)){
                     		$iA ++;
                           	?>
                              <span class="check_box" style="width: 100%;float: left;">
                                 <input style="float: left;margin: 3px;" id="checke<?=$in?>_<?=$iA?>" name="chec_box<?=$in?>" type="radio" />
                                 <label style="cursor: pointer;font-size: 14px;margin-left: 5px;float: left;<?php if($rowAns['ans_id'] == $idAns[$in]) {echo 'color:red;font-weight: bold;';} if($rowAns['ans_true'] == '1'){echo 'color:#33B3A6;font-weight: bold;';} ?>" for="checke<?=$in?>_<?=$iA?>"><?=$arrayT[$iA]?>. <?=$rowAns['ans_content']?></label>
                              </span>
                              <br/>
                        	<?php } ?>
                        </div>
						   <?php }elseif($rowQues['que_type']== 2 ){
								$arrayCont  =  getMainC($rowQues['que_content']);
								$cArrayCont =  count($arrayCont);
         						?>
         						<div  style="overflow: hidden;">
         						   <h1 class="cau_hoi"><?=$in?>. Điền từ vào chỗ trống</h1>
                                 <?php
                                 $j = 0;
                                 for($i=0;$i<$cArrayCont;$i++){
                                    if($i%2 != 0) {
                                       $j ++;
                                       $classinput .= "#editme".$in."_".$j.",";
                                       echo '&nbsp;<span style="color:red;font-weight: bold;">'.$value[$in][$j].'</span>&nbsp;<span style="color:#33B3A6;font-weight: bold;">('.$arrayCont[$i].')</span>&nbsp;';
                                    }else{
                                    	echo $arrayCont[$i];
                                    }
                                 }
                                 $numA[$in] = $j;
                                 ?>
         						</div>
						   <?php }elseif($rowQues['que_type']== 3 ){
								$arrayAns  = getStringAns($rowQues['que_content']);
								$result    = count($arrayAns);
								$rand_keys = array_random($arrayAns, $result);
					 	      ?>
      						<div style="overflow: hidden;" >
         						<h1 class="cau_hoi"><?=$in?>. Kéo thả từ thích hợp vào khoảng trống</h1>
         						<div style="margin: 5px 20px;float: left;border: 2px dotted #E0E0E0;background-color: #FBFBFC;width: 100%;margin-bottom: 20px;margin-right: 10px;margin-left: 0px;">
         							<?php for($i=0;$i<$result;$i++){ ?>
                                 <a href="#" ><?=$i+1?>.<span id="draggable<?=$i+1?>"><?=trim($rand_keys[$i])?></span></a>
                              <?php } ?>
         						</div>
                           <?php
                           $arrayCont  =  getMainC($rowQues['que_content']);
                           $cArrayCont =  count($arrayCont);
                           $j = 0;
                           for($i=0;$i<$cArrayCont;$i++){
                              if($i%2 != 0) {
                                 $j ++;
                                 echo '&nbsp;<span class="ans">'.$value[$in][$j].'</span>..<span class="anstrue">('.$arrayAns[$j-1].')</span>&nbsp;';
                              }else{
                              	echo $arrayCont[$i];
                              }
                           }
                           $numA[$in] = $j;
                           ?>
      						</div>
						   <?php } ?>
			         <?php } } ?>
               <div style="height:30px;">&nbsp;</div>
            </div>
   	    </div>
   	<div class="clearfix"></div>
   </div>
<script type="text/javascript">
$(document).ready(function(){
    $("<?=$classinput?>").editInPlace({
		saving_animation_color: "lime",
        value_required        :	true,
		callback: function(idOfEditor, enteredText, orinalHTMLContent, settingsParams, animationCallbacks) {
			animationCallbacks.didStartSaving();
			setTimeout(animationCallbacks.didEndSaving, 2000);
			return enteredText;
		}
	});
});
</script>
<script>
$(document).ready(function(){
   <?php
   for($i=1;$i<=$in;$i++){
     if($type[$i] == 3){
         for($idrag=1;$idrag<=$numA[$i];$idrag++){
         ?>
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
   $(".button_tinh_diem_v1").click(function(){
       // function xử lý kết quả câu trả lời.
      <?php
      for($i=1;$i<=$in;$i++){
      if($type[$i] == 1){
      ?>
         urlPoint += 'type<?=$i?>=1&';
         var varValue<?=$i?> = $('.check_box input[name=chec_box<?=$i?>]:checked').val();
         urlPoint += 'idAns<?=$i?>='+varValue<?=$i?>+'&';
      <?php
      }elseif($type[$i] == 2){
         ?>
         urlPoint += 'type<?=$i?>=2&numAns<?=$i?>=<?=$numA[$i]?>&';
         <?php
             for($iThree=1;$iThree<=$numA[$i];$iThree++){
         ?>
         var str<?=$i?>_<?=$iThree?> = $('#editme<?=$i?>_<?=$iThree?>').text().replace(/\s+/g, '_');
         urlPoint += "value<?=$i?>_<?=$iThree?>=" + str<?=$i?>_<?=$iThree?> + "&";
      <?php } }elseif($type[$i] == 3){ ?>
         urlPoint += 'type<?=$i?>=3&numAns<?=$i?>=<?=$numA[$i]?>&' + valueDropDrag<?=$i?>;
      <?php } } ?>
     // Chuyển light box khi bấm tính điểm
      $.fancybox({
         'type'   : 'ajax',
         'href'   :  baseurl+ '/ajax/ajax_point_quick_v2.php?icou=<?=$iCou?>&iunit=<?=$iUnit?>&unit=<?=$unit?>&nAns=<?=$in?>&' + urlPoint,
      });
 });
});
</script>
<div id="b_notice" class="white_content" style="height: 400px;">
<div id="b_content" class="support" style="text-align: center;">
   <!--Append phan thong bao nhan badge vao day-->
</div>
</div>
<div id="fade" class="black_overlay"></div>
<style>
.bot_left_vocabulary .voc_detail {margin-left:10px;width: 100%;float: left;border-bottom: dashed 1px #E0E0E0;margin-top: 20px;padding-bottom: 20px;}
.bot_left_vocabulary .voc_content {float: left;width: 270px;}
.tt_box_left_lb {float: left;font-size: 16px;font-family: HelveticaNeueVOBold;}
.bot_left_vocabulary .voc_detail .phonetic {float: left;color: #4D8DB0;width: 270px;margin-top: 10px;margin-bottom: 10px;}
.bot_left_vocabulary .voc_eg {float: left;width: 270px;}
.bot_left_vocabulary .voc_img {float: right;margin-right: 10px;}
.menu_quiz {float: left;border: 2px dotted #E0E0E0;background-color: #FBFBFC;width: 410px;margin-bottom: 20px;margin-right: 10px;margin-left: 0px;}
.menu_quiz a {color: #666;float: left;font-size: 14px;padding-top: 10px;padding-bottom: 10px;padding-left: 16px;font-weight: bold;}
span.dotset {border: 1px dotted #999;width: 70px;}
.cau_hoi{font-size: 15px;}
.ans {color: red;}
.anstrue {font-weight: bold;color: #33B3A6;}
</style>
<?}?>