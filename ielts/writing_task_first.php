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
      //redirect_access_part_ielts($tesr_part_success,3,$test_id);
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
                                   WHERE iety_ielt_id	 = ".$test_id." AND iety_type = 4 AND iecon_order = 1");                         
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
               <li class="li_head_part"><a>Reading</a></li>
               <li class="li_head_part li_head_part_active"><a>Writing</a></li>
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
            <div id="maintest_writing_left">
               <div id="left_sheet" style="color: #6A6A6A;">Write at least 150 words :</div>
               <div id="write_answer">
               <textarea id="txta_write_anser"></textarea>
               </div>
            </div>
            <div id="maintest_writing_right">
               <div id="" class="section_writing_content">
                  <div id="content_writing_question">
                     <b style="color: #6A6A6A;">Question <?=$row_cont['iecon_order']?>:</b> <br/> <br/>
                     <span style="color: #6A6A6A;"><?if($row_cont['iecon_content'] != ""){echo $row_cont['iecon_content'];}?></span>
                     <span><?if($row_cont['iecon_image'] != ""){echo "<img style='max-width: 530px;margin-top:10px' src='".getURL(1,0,0,0)."data/ielt_writing/".$row_cont['iecon_image']."'/>";}?></span>
                  </div>
               </div>
               <script>
               $(document).ready(function(){ $(function(){ $('.section_writing_content').slimScroll({ height: '500px' }); }) })
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
   if(confirm("Bạn đã hoàn thành phần thi đầu tiên của Writing ?")){
      txta_write_anser = $("#txta_write_anser").val();
      $.ajax({
         type:'POST',
         dataType:'json',
         data:{
         rmv_str_ans:txta_write_anser,
         part_write:1
         },
         url:'act_writing.php',
         success:function(data){
      	if(data.err == ''){
      		alert(data.msg);	
            window.location = "writing_task_second.php?test_id=<?=$test_id?>";
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
   if(minutes < 10){
      minutes = '0'+minutes;
   }
   if(seconds < 10){
      seconds = '0'+seconds;
   }
   document.getElementById("ap_clock").innerHTML = "<p class='p_remain'>"+minutes+" : "+seconds+"</p>";
   SD=window.setTimeout( "setCountDown()", 1000 );
   if(minutes == '00' && seconds == '00') { seconds = "00"; window.clearTimeout(SD);
      window.location = "writing_task_second.php";
   } 
}
</script>