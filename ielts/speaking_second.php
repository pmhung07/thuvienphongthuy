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
   //redirect_access_part_ielts($tesr_part_success,4,$test_id);
   //7.Lay ten file bat ky luu ghi am
   $name_file   = random();
   //-----------------------------------------------------------------------------------------------------------------
   //3.Quy dinh thoi gian thi
   $time_test = 15;
   $time_diff = creat_time_test($time_test);
   //4.Tính thời gian thi
   $remainingDay     = floor($time_diff/60/60/24);
   $remainingHour    = floor(($time_diff-($remainingDay*60*60*24))/60/60);
   $remainingMinutes = floor(($time_diff-($remainingDay*60*60*24)-($remainingHour*60*60))/60);
   $remainingSeconds = floor(($time_diff-($remainingDay*60*60*24)-($remainingHour*60*60))-($remainingMinutes*60));
   //------------------------------------------------------------------------------------------------------------------
   //echo $_SESSION['order_speak'];
   $db_select_cont   = new db_query("SELECT * FROM ielt_content INNER JOIN ielt_type ON(iecon_iety_id = iety_id) 
                                     WHERE iety_ielt_id = ".$test_id." AND iety_type = 3 AND iecon_part_speak = 2");
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
   <script language="javascript" type="text/javascript" src="<?=$var_path_js?>jquery.min.js"></script>
   <!-- swfobject is a commonly used library to embed Flash content -->
   <script type="text/javascript"  src="js/swfobject.js"></script>
   <!-- Setup the recorder interface -->
   <script type="text/javascript" src="js/recorder.js"></script>
   <!-- GUI code... take it or leave it -->
   <script type="text/javascript" src="js/gui.js"></script>
   <script src="js/ui/jquery-ui-1.8.23.custom.js"></script>
   <script language="javascript" type="text/javascript" src="../themes/js/jquery-1.7.1.js"></script>
   <script language="javascript" type="text/javascript" src="../themes/js/load_slice_page.js"></script>
	<script language="javascript" type="text/javascript" src="../mediaplayer/jwplayer.js"></script>
   <title>Main Test</title>
</head>
<body background="http://<?=$base_url?>/themes/images/ielts/bg.gif" onload="setCountDown()">
   <div id="maintest">
      <div id="head_maintest">
         <div id="logo_ielts">
            <span>IELTS ™ ONLINE TEST</span>
         </div>
         <div id="head_option">
            <div id="head_option_clock">
               <img src="<?=$var_path_ielt?>clock.png" />
               <span id="ap_clock" class="hon_clock">00 : 00</span>
            </div>
            <ul id="head_part_ielt">
               <li class="li_head_part"><a>Listening</a></li>
               <li class="li_head_part"><a>Reading</a></li>
               <li class="li_head_part"><a>Writing</a></li>
               <li class="li_head_part li_head_part_active"><a>Speaking</a></li>
            </ul>
         </div>
      </div>
      <div id="content_maintest">
         <div class="time_record">
            <p id="time_re"></p>
            <div id="status"></div>
            <div id="wami"></div>                      
         </div> 
         <?while($row_speaking = mysql_fetch_assoc($db_select_cont->result)){  ?>
         <div id="speak_record">
            <div id="guide_speak">
               Click <img class="" src="<?=$var_path_ielt?>speak_mic.png" /> để ghi âm câu trả lời. &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Click <img class="" src="<?=$var_path_ielt?>speak_record.png" /> để kết thúc câu trả lời và tự động chuyển câu hỏi.
            </div>
            <div id="btn_speak_video">
               <div id="view_video_speak">
                  <span id="cont_text_part2"><?=$row_speaking['iecon_content']?></span>
               </div>
               <div id="btn_wait_record" style="display: none;">
                  <img class="" src="<?=$var_path_ielt?>wait_record.gif" />
                  <span class="sp_act_recording">Recording..</span>
               </div>
               <div id="btn_speak_record">
                  <img id="start_record" class="img_act_record cl_speak_act" src="<?=$var_path_ielt?>speak_mic.png" />
                  <span class="sp_act_record">Record</span>
               </div>
               <div id="btn_speak_stop">
                  <img id="stop_record" class="img_act_record cl_speak_act" src="<?=$var_path_ielt?>speak_record.png" />
                  <img style="display: none;margin-top: 5px;" id="wait_record" class="img_act_record cl_speak_act" src="<?=$var_path_ielt?>wait_stop.gif" />
                  <span class="sp_act_record">Stop</span>
                  <span style="display: none;" id="af_stop" class="sp_act_record">Waiting..</span>
               </div>   
               <div id="btn_speak_part">
                  <img class="img_act_record" src="<?=$var_path_ielt?>speak_part.png" />
                  <span class="sp_act_record">Part 2 / 3</span>
               </div>    
               <div id="btn_speak_guide">
                  <img class="img_act_record" src="<?=$var_path_ielt?>speak_guide.png" />
                  <span class="sp_act_record">Question 1 / 1</span>
               </div>
            </div>
         </div>
         <?}unset($db_select_cont);?>
      </div>
      <div id="footer_ielts">
         IELTS ™ ONLINE TEST
      </div>
   </div>
</body>
</html>
<script>
/*********************************************************************************
*Start record 
*********************************************************************************/
$(document).ready(function() { 
    window.document.onload = setup();
});

$("#start_record").click(function (){ 
   $("#btn_wait_record").show();
   $("#btn_speak_record").hide();
   window.document.onload = record();
});  
$("#stop_record").click(function (){ 
   window.document.onload = stop();
   $("#btn_speak_record").show();
   $("#btn_wait_record").hide();
   $("#stop_record").hide();
   $("#bf_stop").hide();
   $("#wait_record").show();
   $("#af_stop").show();
   setTimeout (function () {
      window.location = "speaking_third.php?test_id=<?=$test_id?>";
   }, 5000);
});

/*********************************************************************************
*Function ghi am
*********************************************************************************/  

function setup() {
   Wami.setup("wami");
}
function record() { 
   <?
      $_SESSION["record_second_speak"] = $name_file.".wav";
   ?>
   console.log(Wami);
   Wami.startRecording('http://<?=$base_url?>/ielts/js/accessfile.php?name=<?=$name_file?>.wav');                    
}
function stop() {
   Wami.stopRecording();
}

function status(msg) {
   document.getElementById('status').innerHTML = msg;
}

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
   document.getElementById("ap_clock").innerHTML = "<p class='p_remain'>"+"0"+minutes+" : "+seconds+"</p>";
   SD=window.setTimeout( "setCountDown()", 1000 );
   if(minutes == '00' && seconds == '00') { seconds = "00"; window.clearTimeout(SD);
      window.location = "speaking_third.php";
   } 
}
</script>