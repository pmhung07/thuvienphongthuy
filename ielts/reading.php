<? require_once("config.php"); ?>
<?
   //-----------------------------------------------------------------------------------------------------------------
   //-----------------------------------------------------------------------------------------------------------------
   $test_id = getValue("test_id","int","GET",0); 
   //1.Kiem tra xem co ton tai bai thi nay khong
      //check_isset_ielts($test_id);
   //2.Kiem tra cac truong hop user truy cap bai thi
      //check_access_ielts_other($test_id);
      $tesr_part_success = check_access_part_ielts($myuser->u_id);
      //redirect_access_part_ielts($tesr_part_success,2,$test_id);
   //-----------------------------------------------------------------------------------------------------------------
   //3.Quy dinh thoi gian thi
   $time_test = 60;
   $time_diff = creat_time_ielts($time_test);
   //4.Tính thời gian thi
   $remainingDay     = floor($time_diff/60/60/24);
   $remainingHour    = floor(($time_diff-($remainingDay*60*60*24))/60/60);
   $remainingMinutes = floor(($time_diff-($remainingDay*60*60*24)-($remainingHour*60*60))/60);
   $remainingSeconds = floor(($time_diff-($remainingDay*60*60*24)-($remainingHour*60*60))-($remainingMinutes*60));
   //------------------------------------------------------------------------------------------------------------------
?>

<?
   // Variable tab - Default tab reading = 2
   $db_select_cont = new db_query("SELECT * FROM ielt_content 
                                   INNER JOIN ielt_type ON(iecon_iety_id = iety_id) 
                                   WHERE iety_ielt_id	 = ".$test_id." AND iety_type = 1 ORDER BY iecon_order");

   // Variable tab - Default tab reading = 2
   $db_select_ques = new db_query("SELECT * FROM ielt_questions 
                                   INNER JOIN ielt_content ON (ieque_iecon_id = iecon_id)
                                   INNER JOIN ielt_type ON(iecon_iety_id = iety_id) 
                                   WHERE iety_ielt_id	 = ".$test_id." AND iety_type = 1 ORDER BY ieque_order");
   
   // Total record of question
   $total_row_ques = mysql_num_rows($db_select_ques->result);                         
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="author" content="HungPham" />
   <title><?=$con_site_title?></title>
   <meta name="keywords" content="<?=$con_meta_keywords?>" />
	<meta name="description" content="<?=$con_meta_description?>" />
   <link rel="stylesheet" type="text/css" href="<?=$var_path_css?>ielts.css" />
   <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
   <script language="javascript" type="text/javascript" src="../themes/js/jquery-1.7.1.js"></script>
   <script language="javascript" type="text/javascript" src="../themes/js/load_slice_page.js"></script>
   <script language="javascript" type="text/javascript" src="../themes/js/ui/jquery.ui.core.js"></script>
   <script language="javascript" type="text/javascript" src="../themes/js/ui/jquery.ui.widget.js"></script>
   <script language="javascript" type="text/javascript" src="../themes/js/ui/jquery.ui.mouse.js"></script>
   <script language="javascript" type="text/javascript" src="../themes/js/ui/jquery.ui.draggable.js"></script>
   <script language="javascript" type="text/javascript" src="../themes/js/ui/jquery.ui.droppable.js"></script>
   <script language="javascript" type="text/javascript" src="../themes/js/slimScroll.min.js"></script>
   <script language="javascript" type="text/javascript" src="../themes/js/jquery.media.js"></script>
	<title>Main Test</title>
</head>
<script type="text/javascript">                                
   $(document).ready(function(){ $('a.media').media( { 'backgroundColor' : 'transparent' , width: 300, height: 20 } ); });
</script>
<body background="http://<?=$base_url?>/themes/images/ielts/bg.gif" onload="setCountDown()">
   <div id="maintest">
      <!--HEADER-->
      <div id="head_maintest">
         <div id="logo_ielts">
            <span>IELTS ™ ONLINE TEST</span>
         </div>
         <div id="head_option">
            <div id="head_option_next">
               <img id="next_test" src="<?=$var_path_ielt?>next.png" />
               <span class="hon_next">Next</span>
            </div>
            <div id="head_option_clock">
               <img src="<?=$var_path_ielt?>clock.png" />
               <span id="ap_clock" class="hon_clock">00 : 00</span>
            </div>
            <div id="head_option_volume">
               <img src="<?=$var_path_ielt?>volume.png" />
               <span class="hon_volume">Volume</span>
            </div>
            <ul id="head_part_ielt">
               <li class="li_head_part"><a>Listening</a></li>
               <li class="li_head_part li_head_part_active"><a>Reading</a></li>
               <li class="li_head_part"><a>Writing</a></li>
               <li class="li_head_part"><a>Speaking</a></li>
            </ul>
         </div>
      </div>
      <!--CONTENT MAIN-->
      <div id="content_maintest">
         <?while($row_cont = mysql_fetch_assoc($db_select_cont->result)){?>
         <div id="maintest_listening"> 
            <div id="listening_main_section">
               <span class="lms_title">SECTION <?=$row_cont['iecon_order']?>:</span>
            </div>
            <div id="maintest_reading_first">
               <div id="section_reading_first_sr_<?=$row_cont['iecon_id']?>" class="section_reading_first">
                  <div style="float: left;width: 320px;">
                  <b style="color: #6A6A6A;">Reading Passage <?=$row_cont['iecon_order']?>:</b> <br/> <br/>
                  <span style="color: #6A6A6A;"><?if($row_cont['iecon_content'] != ""){echo $row_cont['iecon_content'];}?></span>
                  </div>
               </div>
               <script>
               $(document).ready(function(){ $(function(){ $('#section_reading_first_sr_<?=$row_cont['iecon_id']?>').slimScroll({ height: '500px' }); }) })
               </script>
            </div>
            <div id="maintest_reading_right">
               <div id="section_content_sr_<?=$row_cont['iecon_id']?>" class="section_content">
                  <?
                  $db_select_ques_sub = new db_query("SELECT * FROM ielt_questions WHERE ieque_iecon_id = ".$row_cont['iecon_id']." ORDER BY ieque_order");
                  while($row_ques_ord = mysql_fetch_assoc($db_select_ques_sub->result)){
                  ?>
                  <div id="content_read_question">
                     <span style="color: #6A6A6A;"><?if($row_ques_ord['ieque_content'] != ""){echo $row_ques_ord['ieque_content'];}?></span>
                     <span><?if($row_ques_ord['ieque_image'] != ""){echo "<img style='max-width: 390px;margin-top:10px' src='".getURL(1,0,0,0)."data/ielt_reading/".$row_ques_ord['ieque_image']."'/>";}?></span>
                  </div>
                  <div class="dt_ques"></div>
                  <?}unset($db_select_ques_sub)?>
               </div>
               <script>
               $(document).ready(function(){ $(function(){ $('#section_content_sr_<?=$row_cont['iecon_id']?>').slimScroll({ height: '500px' }); }) })
               </script>
            </div>
            <div id="maintest_reading_left">
               <div id="left_sheet">Answer Sheet :</div>
               <div id="left_answer_sr_<?=$row_cont['iecon_id']?>" class="left_answer">
                  <ul class="ul_read_left_answer">
                     <?
                     if($row_cont['iecon_order'] == 1){ $count_start = 1 ; $count_end = 13;} 
                      elseif($row_cont['iecon_order'] == 2){ $count_start = 14 ; $count_end = 26; }
                       elseif($row_cont['iecon_order'] == 3){ $count_start = 27 ; $count_end = 40; }
                        for($i = $count_start;$i <= $count_end;$i++){
                        ?> 
                     <li class="li_left_answer">
                        <span class="num_read_left_ans"><?=$i?>.</span>
                        <input id="ip_user_ans_<?=$i?>" class="ip_left_read_ans" type="text" />
                     </li>
                     <?}?>
                  </ul>
               </div>
               <script>
               $(document).ready(function(){ $(function(){ $('#left_answer_sr_<?=$row_cont['iecon_id']?>').slimScroll({ height: '400px' }); }) })
               </script>
            </div>
         </div>
         <?}unset($db_select_cont);?>
      </div>
      <!--FOOTER-->
      <div id="footer_ielts">
         IELTS ™ ONLINE TEST
      </div>
   </div>
</body>
</html>
<script>

/*********************************************************************************
*Save ans to database
*********************************************************************************/

$('#next_test').click(function (){
   if(confirm("Bạn đã hoàn thành phần thi Reading ?")){
      var str_ans = "";
      for(i = 1;i <= 40 ; i++){
         if($('#ip_user_ans_'+i).val() == ""){
            str_ans += "Answer_"+i+" : Not Answer | ";  
         }else{  
            str_ans += "Answer_"+i+" : "+$('#ip_user_ans_'+i).val()+" | ";
         }
      }
      $.ajax({
         type:'POST',
         dataType:'json',
         data:{
         str_ans:str_ans
         },
         url:'act_reading.php',
         success:function(data){
      	if(data.err == ''){
      		alert(data.msg);	
            window.location = "direct_writing.php?test_id=<?=$test_id?>";
      	}else{
      		alert(data.err);
      	}}
      });
   }return false;
});  

/*********************************************************************************
*Append time 
*********************************************************************************/

var hours = <?=$remainingHour?>  
var minutes = <?=$remainingMinutes?>  
var seconds = <?=$remainingSeconds?> 
function setCountDown ()
{
   seconds--;
   if(seconds < 0){
      minutes--;
      seconds = 59
   }
   if(minutes < 0){
      hours--;
      minutes = 59
   }
   if(hours < 0){
      hours = 23
   }
   if(seconds < 10){
      seconds = '0'+seconds;
   }
   document.getElementById("ap_clock").innerHTML = "<p class='p_remain'>"+minutes+" : "+seconds+"</p>";
   SD=window.setTimeout( "setCountDown()", 1000 );
   if(minutes == '00' && seconds == '00') { seconds = "00"; window.clearTimeout(SD);
      var str_ans = "";
      for(i = 1;i <= 40 ; i++){
         if($('#ip_user_ans_'+i).val() == ""){
            str_ans += "Answer_"+i+" : Not Answer | ";  
         }else{  
            str_ans += "Answer_"+i+" : "+$('#ip_user_ans_'+i).val()+" | ";
         }
      }
      $.ajax({
         type:'POST',
         dataType:'json',
         data:{
         str_ans:str_ans
         },
         url:'act_reading.php',
         success:function(data){
      	if(data.err == ''){
      		alert(data.msg);	
            window.location = "direct_writing.php?test_id=<?=$test_id?>";
      	}else{
      		alert(data.err);
      	}}
      });
      //window.location = "direct_writing.php?test_id=<?//=$test_id?>";
   } 
}
</script>