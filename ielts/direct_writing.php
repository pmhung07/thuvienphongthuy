<? require_once("config.php"); ?>
<?
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
      <div id="content_maintest">
         <div style="width: 700px;margin: 0 auto;color: #8F9CA9;text-align: justify;margin-top: 90px;">
            <span style="font-size: 20px;color: #8F0801;">Writing:</span><br /><br /><br />
            <b style="color: #8F0801;">&rsaquo;&rsaquo;&rsaquo;</b>&nbsp;&nbsp;This test consists of two tasks. It is suggested that candidates spend about 20 minutes on Task 1 and 40 minutes on Task 2. Task 2 contributes twice as much as Task 1 to the Writing score.<br /><br /><br />
            <b style="color: #8F0801;">&rsaquo;&rsaquo;&rsaquo;</b>&nbsp;&nbsp;Task 1 requires candidates to look at a diagram or some data (graph, table or chart) and to present the information in their own words. <br /><br /><br />
            <b style="color: #8F0801;">&rsaquo;&rsaquo;&rsaquo;</b>&nbsp;&nbsp;Task 2 candidates are presented with a point of view, argument or problem. <br /><br /><br />
         </div>
      </div>
   </div>
</body>
</html>
<script>
$('#next_test').click(function (){ 
   window.location = "writing_task_first.php?test_id=<?=$test_id?>";
});   
</script>