<? require_once("config.php"); ?>

<?
//-----------------------------------------------------------------------------------------------------------------
$test_id = getValue("test_id","int","GET",0); 
//1.Kiem tra xem co ton tai bai thi nay khong
check_isset_ielts($test_id);
//2.Kiem tra cac truong hop user truy cap bai thi
check_access_ielts_other($test_id);
$tesr_part_success = check_access_part_ielts($myuser->u_id);
//-----------------------------------------------------------------------------------------------------------------
$count_speaking_first =  $_SESSION['row_speak_first'];
$count_speaking_third =  $_SESSION['row_speak_third'];
//-----------------------------------------------------------------------------------------------------------------
$str_ans_first = "";
for($i = 1;$i <= $count_speaking_first ; $i++){
   if(!isset($_SESSION["record_first_speak_".$i])){
      $str_ans_first .= "Not record | ";  
   }else{  
      if($_SESSION["record_first_speak_".$i] != ""){
         $str_ans_first .= $_SESSION["record_first_speak_".$i] . " | ";
      }else{
         $str_ans_first .= "Not record | ";  
      }
   }
}
//-----------------------------------------------------------------------------------------------------------------
if(!isset($_SESSION["record_second_speak"])){
   $str_ans_second = "Not record | ";  
}else{  
   if($_SESSION["record_second_speak"] != ""){
      $str_ans_second = $_SESSION["record_second_speak"];
   }else{
      $str_ans_second = "Not record | ";  
   }
}

//-----------------------------------------------------------------------------------------------------------------
$str_ans_third = "";
for($i = 1;$i <= $count_speaking_third ; $i++){
   if(!isset($_SESSION["record_third_speak_".$i])){
      $str_ans_third .= "Not record | ";  
   }else{  
      if($_SESSION["record_third_speak_".$i] != ""){
         $str_ans_third .= $_SESSION["record_third_speak_".$i] . " | ";
      }else{
         $str_ans_first .= "Not record | ";  
      }
   }
}

//-----------------------------------------------------------------------------------------------------------------
$ielr_user_success = 1;
/*$myform = new generate_form();  
$myform->add("ielt_user_speaking_first", "str_ans_first", 0, 1, "", 0, "", 0, "");
$myform->add("ielt_user_speaking_second", "str_ans_second", 0, 1, "", 0, "", 0, "");
$myform->add("ielt_user_speaking_third", "str_ans_third", 0, 1, "", 0, "", 0, "");
$myform->add("ielr_user_success", "ielr_user_success", 1, 1, 1, 0, "", 0, "");
//Add table insert data
$myform->addTable("ielts_result");
$db_ex = new db_execute($myform->generate_update_SQL("ielr_id",$_SESSION['ielr_id']));

//--------------------------------
$use_ielts_complete = 1;
$myform_1 = new generate_form();  
$myform_1->add("use_ielts_complete", "use_ielts_complete", 1, 1, 1, 0, "", 0, "");
//Add table insert data
$myform_1->addTable("users");
$db_ex = new db_execute($myform_1->generate_update_SQL("use_id",($myuser->u_id)));*/
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
<body>
   <div id="maintest">
      <div id="head_maintest">
         <div id="logo_ielts">
            <span>IELTS ™ ONLINE TEST</span>
         </div>
         <div id="head_option">
            <div id="head_option_clock">
               <img src="<?=$var_path_ielt?>clock.png" />
               <span class="hon_clock">00 : 00</span>
            </div>
            <ul id="head_part_ielt">
               <li class="li_head_part"><a>Listening</a></li>
               <li class="li_head_part"><a>Reading</a></li>
               <li class="li_head_part"><a>Writing</a></li>
               <li class="li_head_part"><a>Speaking</a></li>
            </ul>
         </div>
      </div>
      <div id="content_maintest">
         <div style="width: 800px;margin: 0 auto;color:;text-align: justify;margin-top: 90px;">
         <span style="font-size: 20px;color: #8F0801;">IELTS Test Finish:</span><br /><br /><br />
         <b>&bull;</b> &nbsp; Chúc mừng bạn đã hoàn thành phần thi IELTS<br /><br /><br />
         <b>&bull;</b> &nbsp; Kết quả bài thi sẽ được chúng tôi gửi sớm nhất đến bạn<br /><br /><br />
         
         </div>
      </div>
   </div>
</body>
</html>
<script>
setTimeout (function () {
   window.location.href = "http://hochay.vn";
}, 5000);
</script>