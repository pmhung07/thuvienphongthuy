<? require_once("config.php"); ?>
<?
if(isset($_SESSION['order_speak'])){unset($_SESSION['order_speak']);}
//-----------------------------------------------------------------------------------------------------------------
   $test_id = getValue("test_id","int","GET",0); 
//1.Kiem tra xem co ton tai bai thi nay khong
   //check_isset_ielts($test_id);
//2.Kiem tra cac truong hop user truy cap bai thi
   //check_access_ielts_other($test_id);
//3.Unset time cu
   if(isset($_SESSION['targetDate_ielts'])) {
      unset($_SESSION['targetDate_ielts']);
   }
//-----------------------------------------------------------------------------------------------------------------
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
	<title>Main Test</title>
</head>
<body background="http://<?=$base_url?>/themes/images/ielts/bg.gif">
   <div id="maintest">
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
               <span class="hon_clock">00 : 00</span>
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
         <div style="width: 700px;margin: 0 auto;color: #8F9CA9;text-align: justify;margin-top: 90px;">
         <span style="font-size: 20px;color: #8F0801;">Speaking:</span><br /><br /><br />
            <b style="color: #8F0801;">&rsaquo;&rsaquo;&rsaquo;</b>&nbsp;&nbsp;This test takes between 11 and 14 minutes and is conducted by a trained examiner.<br /><br /><br />
            <b style="color: #8F0801;">&rsaquo;&rsaquo;&rsaquo;</b>&nbsp;&nbsp;Part 1 : The candidate and the examiner introduce themselves. Candidates then answer general questions about themselves, their home/family, their job/studies, their interests and a wide range of similar familiar topic areas. This part lasts between four and five minutes.<br /><br /><br />
            <b style="color: #8F0801;">&rsaquo;&rsaquo;&rsaquo;</b>&nbsp;&nbsp;Part 2 : The candidate is given a task card with prompts and is asked to talk on a particular topic. The candidate has one minute to prepare and they can make some notes if they wish, before speaking for between one and two minutes.<br /><br /><br />
            <b style="color: #8F0801;">&rsaquo;&rsaquo;&rsaquo;</b>&nbsp;&nbsp;Part 3 : The examiner and the candidate engage in a discussion of more abstract issues which are thematically linked to the topic in Part 2. The discussion lasts between four and five minutes.<br /><br /><br />
      </div>
   </div>
</body>
</html>
<script>
$('#next_test').click(function (){ 
   window.location = "speaking_first.php?test_id=<?=$test_id?>";
});  
</script>