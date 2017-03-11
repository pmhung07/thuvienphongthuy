<?php
   $type = getValue("type","str","GET","");
   $iUnit = getValue("iunit","int","GET","");
   $med = getValue("med","str","GET","");
   $sqlCou = new db_query("SELECT * FROM courses,courses_multi WHERE courses.cou_id = courses_multi.com_cou_id AND courses_multi.com_id = ".$iUnit);
   $rowCou = mysql_fetch_assoc($sqlCou->result);
   $iCou = $rowCou['cou_id'];
   unset($sqlCou);
	if($act == 0){
		$check = checkUserIP(getRealIp(),$iCou); if($check == 0){$act = 0; }else{ $act = 1; }
	}
	if ($act == 0) { redirect("http://".$base_url."/courses.html"); }
	if ($med == 'edit'){
      switch($type) {
      	case "main" :
      		include_once("../includes/lesson/lesson_main_edit.php"); 
      		break;	
      	case "grammar" :
      		include_once("../includes/lesson/lesson_gram_edit.php");
      		break;	
      	case "vocabulary" :
      		include_once("../includes/lesson/lesson_voca_edit.php");
      		break;	
      	case "quiz" :
      		include_once("../includes/lesson/lesson_quiz_edit.php");
      		break;	
      	default :
      		redirect("http://".$base_url."/error404.html");
      		break;		
      }			
	}else{
		switch($type) {
			case "main" :
				include_once("../includes/lesson/lesson_main.php");
				break;
			case "strategy" :
				include_once("../includes/lesson/lesson_main_toeic.php");
				break;	
			case "practice" :
				if(checkUnit($iUnit) == 1) {
					include_once("../includes/lesson/lesson_quiz.php");
				}
				if (checkLearn($iUnit,'writing') == 1) {
					include_once("../includes/lesson/lesson_write.php");
				}
				if (checkLearn($iUnit,'speaking') == 1) {
					include_once("../includes/lesson/lesson_speak.php");
				}
				break;	
			case "grammar" :
				include_once("../includes/lesson/lesson_gram.php");
				break;	
			case "vocabulary" :
				include_once("../includes/lesson/lesson_voca.php");
				break;	
			case "quiz" :
				include_once("../includes/lesson/lesson_quiz.php");
				break;	
			case "speak" :
				include_once("../includes/lesson/lesson_speak.php");
				break;	
			case "write" :
				include_once("../includes/lesson/lesson_write.php");
				break;	
			default :
				include_once("../includes/lesson/lesson_detail.php"); 
				break;		
		}	
	}
	
?>
