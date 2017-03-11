<?php
    $iUnit       = getValue("iunit","int","GET","");
    $nUnit       = getValue("name","str","GET","");
	$sqlCou     = new db_query("SELECT * FROM courses,courses_multi WHERE courses.cou_id = courses_multi.com_cou_id AND courses_multi.com_id = ".$iUnit);
	$rowCou     = mysql_fetch_assoc($sqlCou->result);
	$iCou       = $rowCou['cou_id'];
	$inum       = $rowCou['com_num_unit'];
	unset($sqlCou);
    $sqlCate    = new db_query("SELECT * FROM courses WHERE cou_id = ".$iCou);
    $rowCourses = mysql_fetch_assoc($sqlCate->result);
	if (!$rowCourses) { redirect("http://".$base_url."/error404.html");}
    $urlcou     = generate_detailCourse($rowCourses['cou_id'],$rowCourses['cou_name']);
    $sqlSub     = "SELECT com_num_unit FROM courses_multi WHERE com_cou_id = ".$iCou." ORDER BY com_num_unit";                   
    $result     = mysql_query($sqlSub);
    $num_rows   = mysql_num_rows($result); unset($sqlSub);
    $time       = time();
    $sqlForm    = new db_query("SELECT * FROM courses WHERE cou_id = ".$iCou);
    if($row_form = mysql_fetch_assoc($sqlForm->result)){
        $cou_form = $row_form['cou_form'];
    }unset($sqlForm);
   
   //======= Course Point =====//
   if($myuser->logged == 1){
	   $db_cpoint = new db_query("SELECT * FROM user_course WHERE usec_use_id = ".$myuser->u_id." AND usec_cou_id = ".$iCou);
	   $row_cpoint = mysql_fetch_assoc($db_cpoint->result);
	   unset($db_cpoint);   
	   $db_sum = new db_query("SELECT COUNT(com_id) AS num_unit FROM courses_multi WHERE com_cou_id = ".$iCou);
	   $row_sum = mysql_fetch_assoc($db_sum->result);
	   unset($db_sum);
	   $sum_point = $row_sum['num_unit']*20;
	   if($sum_point != 0) $percent = intval($row_cpoint['usec_cou_point'] * 100/$sum_point);
	   else $percent = 100; 
   }
   saveIp(getRealIp(),$iCou);
?>
<link rel="stylesheet" type="text/css" href="<?=$var_path_css?>style_tab_2.css"/>
<script src="<?=$var_path_js?>organictabs.jquery.js"></script>
<script>
$(function() {         
   $("#main_courses_learn").organicTabs({
       "speed": 300
   });
});
</script>
<!----- Jquery Lightbox ----->
<!--- jquery scrollbar --->
<script type="text/javascript">
$(document).ready(function() {
   var currentTop = 0;
   $("#various1").click(function(){
   currentTop = $(window).scrollTop();
      $('.container').scrollTop(0);            
   });  
   $("#various1,#learn").fancybox({
      helpers:  {
         overlay : {
            css : {
              'background-color' : '#666'
            },
         },
      },
      'margin'            : '0',
      'transitionIn'	   : 'none',
      'transitionOut'	   : 'none',
      'type'			   : 'ajax',
      'scrolling'         : 'no',
      'autoSize'          : false,
      'autoCenter'        : false,   
      beforeShow          : function(){
         $('.container').addClass('fixed');
      },
      afterClose          : function(){
   		   $('#fancybox-overlay').remove();
		   $('.container').removeClass('fixed');	
		   $('body,html').animate({
				 scrollTop:currentTop
			 },0);
      		$(document)[0].location.reload();
      },
   });
    $.fancybox.close(true);
});
</script>

<div id='fb-root'></div>
<script src='http://connect.facebook.net/en_US/all.js'></script>
<script> 
FB.init({appId: "358128264274593", status: true, cookie: true});

function postToFeed() {

  // calling the API ...
  var obj = {
    method: 'feed',
    link: '<?=generate_detailCourse($rowCourses['cou_id'],$rowCourses['cou_name'])?>',
    picture: 'http://<?=$base_url?>/pictures/courses/<?=$rowCourses['cou_avatar']?>',
    name: '<?=str_replace("'","",removeHTML($rowCourses['cou_name']))?>',	
    description: '<?=removeHTML($rowCourses['cou_info'])?>',
  };

  function callback(response) {
    //document.getElementById('msg').innerHTML = "Post ID: " + response['post_id'];
    if(response !== null && response !== undefined){
      $.ajax({
         type:'POST',
         url:'http://<?=$base_url?>/ajax/ajax_sharesc.php',
      })
    }    
  }

  FB.ui(obj, callback);
}

</script>
<div id="main_courses"><!----- Phần Main ----->

   <div id="title_main_courses">
      <span class="sp_title_main_courses">
	  <?php
      	$cCate = get_cateCourse($iCou);
		echo '<a href="'.generate_sub_cate($cCate['id'],$cCate['name'],1,"beginner").'" >'.$cCate['name'].'</a>';
	  ?>
      </span><span style="margin:0 6px" class="sp_title_main_courses">--</span><span class="sp_title_main_courses"><?=$rowCourses['cou_name']?></span>
   </div>
   <br style="clear:both">
   <div id="content_main_courses">
      <div id="main_courses_info">
         <div id="courses_info_name">
            <a id="like_fb" title="Chia sẻ lên facebook" onclick='postToFeed(); return false;'>&nbsp;</a>
            <span><?=$rowCourses['cou_name']?></span>
         </div>
         <div id="courses_info_img">
            <div id="info_img_gym"></div>
            <? 
            $i = 0;
            $sqlUnitNum    = new db_query("SELECT com_picture,com_id FROM courses_multi WHERE com_cou_id = ".$iCou." ORDER BY com_num_unit");
            while($rowUnitNum   = mysql_fetch_assoc($sqlUnitNum->result)){
            $i++;
            ?>
               <img class="unit_img show_unit_img_<?=$i?>" src="<?=$var_path_unit.$rowUnitNum['com_picture']?>" />               
            <? }unset($sqlUnitNum);?>
         </div>
         <div title="<?=removeHTML($rowCourses['cou_info'])?>" id="courses_info_content" class="contentTooltip">
            <p><?=cut_string(removeHTML($rowCourses['cou_info']),400)?></p>
         </div>
         
         <?php if($myuser->logged == 1){ ?>
         <div id="course_info_level">
            <span id="learn_start"><b>Bắt đầu : </b><?if(isset($row_cpoint['usec_get_time'])) echo date("d/m/Y",$row_cpoint['usec_get_time']);else echo "Chưa bắt đầu";?></span>
            <span id="learn_score"><b>Đạt được : </b><?if(isset($row_cpoint['usec_cou_point'])) echo $row_cpoint['usec_cou_point']."/".$sum_point;else echo "0/".$sum_point;?> điểm</span>
            <div id="level_view_score">
               <div class="cur_point" style="width:<?=$percent?>%;">
                  <div class="cur_point_text"><?if($percent >= 10) echo $percent."%"?></div>
               </div>
            </div>
            <!--<span class="learn_btn_like"><?=checklike($myuser->u_id,$iCou,'courses')?></span>-->
         </div>
         <?php } ?>
      </div>
      <div id="main_courses_learn">
         <div id="tab_unit">
            <ul class="nav_unit" ><!--- nav_tab --->
            <? 
            $i = 0;
            $sqlUnitNum    = new db_query("SELECT com_id,com_num_unit FROM courses_multi WHERE com_cou_id = ".$iCou." ORDER BY com_num_unit");
            while($rowUnitNum   = mysql_fetch_assoc($sqlUnitNum->result)){
            $i++;
            ?>
               <li class="nav-<?=$i?> tab_nav_unit"><a onclick="change_image_unit(<?=$i?>)" href="#bai_<?=$i?>" 
   			   <?php               
               		if($i == $inum){ echo 'class="current"'; } 
   			   ?>                
               >Bài <?=$rowUnitNum['com_num_unit']?></a></li>     
            <? } unset($sqlUnitNum);?>                       
            </ul> 
            <span class="next_tab">next</span>
         </div>
         <script>   
         //load unit
         var first_unit = 1;
         var first_unit_invi = 1;
         var min_unit = 6;
         var total_unit = <?=$i?>;
         $('.nav_unit .tab_nav_unit:gt('+(min_unit - 1)+')').hide();
         $('.next_tab').click(function (){
            if(total_unit > min_unit){
               $('.nav-'+first_unit).hide();
               min_unit = min_unit + 1;
               $('.nav-'+min_unit).show();
               first_unit = first_unit + 1;
               first_unit_invi = first_unit_invi - 1;
            }else{
               first_unit = 1;
               first_unit_invi = 1;
               min_unit = 6;
               $('.nav_unit .tab_nav_unit:gt('+(min_unit - 1)+')').hide();
               $('.nav_unit .tab_nav_unit:lt('+(min_unit - 1)+')').show();
            }        
         });     
         //change image unit
         <?php $numu = $inum ?>
         $('.unit_img').hide();
         $('img.show_unit_img_<?=$numu?>').show();
         $('.learn_speak_wr').hide();
         $('.learn_speak_wr_<?=$numu?>').show();
         function change_image_unit(i){
            $('.unit_img:gt('+(i - 1)+')').hide();
            $('.unit_img:lt('+(i - 1)+')').hide();
            $('.show_unit_img_'+i).show();
            //---            
            $('.learn_speak_wr:gt('+(i - 1)+')').hide();
            $('.learn_speak_wr:lt('+(i - 1)+')').hide();
            $('.learn_speak_wr_'+i).show();
         }
         </script>
         <div class="list-wrap-unit"><!--- content_tab --->
            <? 		
            $j = 0;
            $sqlUnit    = new db_query("SELECT * FROM courses_multi WHERE com_cou_id = ".$iCou." ORDER BY com_num_unit");
            while($rowUnit  = mysql_fetch_assoc($sqlUnit->result)){
            $j++;
            ?>
            <ul id="bai_<?php echo $j; ?>" 
            <?             
            	if($j == $inum){ echo 'class="current"'; }else{ echo 'class="hide"';  }
            ?>       
            ><!--- tab_2 --->
               <div id="courses_learn_name">
                  <p><span>Bài <?=$rowUnit['com_num_unit']?> </span> : <?=cut_string(removeHTML($rowUnit['com_name']),60)?></p>
               </div>
               <?
               //Hiển thị với khóa học thuộc dạng Normal và TOEFL   
               if($cou_form == 1 || $cou_form == 2){?>
               <div title="<?=removeHTML($rowUnit['com_content'])?>" id="course_learn_info" class="content_unit_tooltip">
                  <p><?=cut_string(removeHTML($rowUnit['com_content']),400)?></p>
               </div>
               <div id="course_learn_part">
                  <div class="part_business_letter"><!--- Business letter --->
                     <?
                     $sqlUnitMail = mysql_query("SELECT * FROM lesson_details WHERE les_det_type = 1 AND les_com_id =".$rowUnit['com_id']);
                     $rowUnitMail = mysql_fetch_assoc($sqlUnitMail);
                     ?>
                        <a href="http://<?=$base_url?>/lesson/main/<?=$rowUnit['com_id']?>/<?=removeTitle($rowUnit['com_name'])?>.html">
                       	   <h1 class="images_part_business_letter"></h1>
                           <i class="part_name">Main Lesson</i>
                        </a>
                     <?unset($sqlUnitMail);?>
                  </div> 
                  <div class="part_grammar"><!--- Grammar --->
                     <?
                     $sqlUnitGram = mysql_query("SELECT * FROM lesson_details WHERE les_det_type = 2 AND les_com_id =".$rowUnit['com_id']);
                     $rowUnitGram = mysql_fetch_assoc($sqlUnitGram);
                     ?>
                        <a href="http://<?=$base_url?>/lesson/grammar/<?=$rowUnit['com_id']?>/<?=removeTitle($rowUnit['com_name'])?>.html">
                           <h1 class="images_part_grammar"></h1>
                           <i class="part_name">Grammar</i>
                        </a>
                     <?unset($rowUnitGram);?>  
                  </div>
                    
                  <div class="part_vocabulary"><!--- Vocabulary --->
                     <?
                     $sqlUnitVoca = mysql_query("SELECT * FROM lesson_details WHERE les_det_type = 3 AND les_com_id =".$rowUnit['com_id']);
                     $rowUnitVoca = mysql_fetch_assoc($sqlUnitVoca);
                     ?>
                     <a href="http://<?=$base_url?>/lesson/vocabulary/<?=$rowUnit['com_id']?>/<?=removeTitle($rowUnit['com_name'])?>.html">
                        <h1 class="images_part_vocabulary"></h1>
                        <i class="part_name">Vocabulary</i>
                     </a>
                     <? unset($rowUnitVoca);?>  
                  </div>
                  
                  <div class="part_quiz"><!--- Quiz --->                  
                  <?
                  //Không hiển thị với khóa học dạng TOEFL				  
                  if($cou_form != 2){?>                  
                     <a href="http://<?=$base_url?>/lesson/quiz/<?=$rowUnit['com_id']?>/<?=removeTitle($rowUnit['com_name'])?>.html">
                        <h1 class="images_part_quiz"></h1>
                        <i class="part_name">Quiz</i>
                     </a>                                        
                  <? } ?>
                  </div>
               
                  <!--- speaking --->
                  <div class="part_grammar"><!--- speaking --->
				  <?php if (checkLearn($rowUnit['com_id'],'speaking') == 1) { ?>                  
                  <a href="http://<?=$base_url?>/lesson/speak/<?=$rowUnit['com_id']?>/<?=removeTitle($rowUnit['com_name'])?>.html" >
                       <h1 class="images_part_speaking"></h1>
                       <i class="part_name">Luyện nói</i>
                  </a>
                  <?php } ?>
                  </div>
                  
                  <!--- writing --->
                  <div class="part_grammar"><!--- writing --->
                  <?php if (checkLearn($rowUnit['com_id'],'writing') == 1) { ?>                 
                  <a href="http://<?=$base_url?>/lesson/write/<?=$rowUnit['com_id']?>/<?=removeTitle($rowUnit['com_name'])?>.html" >
                       <h1 class="images_part_writing"></h1>
                       <i class="part_name">Luyện viết</i>
                  </a>           
            	
                   <? }?> 
                   </div> 
                </div>
               <? }elseif($cou_form == 3){?>
               <div title="<?=removeHTML($rowUnit['com_content'])?>" id="course_learn_info" style="height: 195px;" class="content_unit_tooltip">
                  <p><?=cut_string(removeHTML($rowUnit['com_content']),800)?></p>
               </div>
               <div class="part_business_letter"><!--- Business letter --->
                  <?
                  $sqlUnitMail = mysql_query("SELECT * FROM lesson_details WHERE les_det_type = 1 AND les_com_id =".$rowUnit['com_id']);
                  $rowUnitMail = mysql_fetch_assoc($sqlUnitMail);
                  ?> 
                     <?php if(checkUnit_main($rowUnit['com_id']) == 1) { ?>
                     <a href="http://<?=$base_url?>/lesson/strategy/<?=$rowUnit['com_id']?>/<?=removeTitle($rowUnit['com_name'])?>.html">
                    	   <h1 class="images_part_business_letter"></h1>
                        <i class="part_name">Strategy</i>
                     </a>
                     <? }?>
                  <? unset($sqlUnitMail);?>
               </div> 
               <div class="part_quiz"><!--- Quiz --->
                  <a href="http://<?=$base_url?>/lesson/practice/<?=$rowUnit['com_id']?>/<?=removeTitle($rowUnit['com_name'])?>.html">
                     <h1 class="images_part_quiz"></h1>
                     <i class="part_name">Practice</i>
                  </a>   
               </div>
                
               <? }?>
            </ul>
           
            <?
            }unset($sqlUnit);
            unset($sqlCate);
			
            ?>
            
         </div>
      </div>
      <div style="height:30px;float:left;width:100%">&nbsp;
      </div>
   </div>
</div><!----- Hết phần Main ----->