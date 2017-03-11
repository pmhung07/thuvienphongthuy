<? require_once("config.php"); ?>

<?
   //-----------------------------------------------------------------------------------------------------------------
      $test_id = getValue("test_id","int","GET",0); 
   //1.Kiem tra xem co ton tai bai thi nay khong
      //check_isset_ielts($test_id);
   //2.Kiem tra cac truong hop user truy cap bai thi
      //check_access_ielts_other($test_id);
   //-----------------------------------------------------------------------------------------------------------------
   //3.Kiem tra xem user dang lam phan nao
      //$tesr_part_success = check_access_part_ielts($myuser->u_id);
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
   <script language="javascript" type="text/javascript" src="../themes/js/deny_operations.js"></script>
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
            <!--<div id="head_option_volume">
               <img src="<?//=$var_path_ielt?>volume.png" />
               <span class="hon_volume">Volume</span>
            </div>-->
            <ul id="head_part_ielt">
               <li class="li_head_part"><a>Listening</a></li>
               <li class="li_head_part"><a>Reading</a></li>
               <li class="li_head_part"><a>Writing</a></li>
               <li class="li_head_part"><a>Speaking</a></li>
            </ul>
         </div>
      </div>
      <div id="content_maintest">
         <div style="width: 800px;margin: 0 auto;color:;text-align: justify;margin-top: 50px;">
         <span style="font-size: 20px;color: #8F0801;">IELTS Test Structure:</span><br /><br />

         <b style="color: #8F0801;">&rsaquo;&rsaquo;&rsaquo;</b> Candidates are tested in listening, reading, writing and speaking. All candidates take the same Listening and Speaking Modules. There is a choice between Academic and General Training in the Reading and Writing Modules. The General Training Reading and Writing Modules emphasise basic survival skills in a broad social and educational context.<br /><br /><br /> 
         
         <b>&bull;</b> &nbsp; Listening module (4 sections, 40 questions) ---> duration 30 minutes<br /><br /><br />
         <b>&bull;</b> &nbsp; Academic reading/general training reading module (3 sections, 40 questions) ---> duration 60 minutes<br /><br /><br />
         <b>&bull;</b> &nbsp; Academic writing/general training writing (2 tasks, 150 and 250 words) ---> duration 60 minutes<br /><br /><br />
         <b>&bull;</b> &nbsp; Speaking module (a face-to-face interview) ---> duration 11 - 14 minutes <br /><br /><br />
         
         <b style="color: #8F0801;">&rsaquo;&rsaquo;&rsaquo;</b> The first three modules - Listening, Reading and Writing - must be completed in one day. There is no break between the modules. The Speaking Module may be taken, at the discretion of the test centre, in the period seven days before or after the other modules. <br /><br />
         
         <b style="color: #8F0801;">&rsaquo;&rsaquo;&rsaquo;</b> A computerised version of IELTS Listening, Reading and Writing Modules (CBIELTS) is available at selected centres, but all centres will continue to offer paper-based IELTS and candidates will be given the choice of the medium in which they wish to take the test.<br /><br />
         </div>
      </div>
   </div>
</body>
</html>
<script>
tesr_part_success = 0 <?//=$tesr_part_success?>;
$('#next_test').click(function (){ 
   if(tesr_part_success == 0){
      window.location = "direct_listening.php?test_id=<?=$test_id?>";
   }
   if(tesr_part_success == 1){
      if(confirm("Bạn có muốn tiếp tục làm phần Listening?")){
         window.location = "direct_listening.php?test_id=<?=$test_id?>";
      }
   }
   if(tesr_part_success == 2){
      if(confirm("Bạn có muốn tiếp tục làm phần Reading?")){
         window.location = "direct_reading.php?test_id=<?=$test_id?>";
      }
   }
   if(tesr_part_success == 3){
      if(confirm("Bạn có muốn tiếp tục làm phần Writing?")){
         window.location = "direct_writing.php?test_id=<?=$test_id?>";
      }
   }
   if(tesr_part_success == 4){
      if(confirm("Bạn có muốn tiếp tục làm phần Speaking?")){
         window.location = "direct_speaking.php?test_id=<?=$test_id?>";
      }
   }
});  
</script>
