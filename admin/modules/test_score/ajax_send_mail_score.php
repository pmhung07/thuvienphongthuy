<?
require_once("inc_security.php");
require_once("class.phpmailer.php");
require_once("class.smtp.php");
require_once("send_mail.php");
?>
<?
$tesr_id = getValue("record_id","int","POST",0);
$time = time();
$time_cv =  date("d/m/Y",$time);
$gender = '';
$birth = '';
$level_score_reading = '';
$level_score_reading_abt = '';
$cmt_score_reading = '';
$level_score_listening = '';
$level_score_listening_abt = '';
$cmt_score_listening = '';
$level_score_speaking = '';
$level_score_speaking_abt = '';
$cmt_score_speaking = '';
$level_score_writing = '';
$level_score_writing_abt = '';
$cmt_score_writing = '';
//Lay thong tin cua bai da thi
$sqlUser = new db_query("SELECT * FROM test_result WHERE tesr_id = ".$tesr_id);
if($row_user = mysql_fetch_assoc($sqlUser->result)){
   $user_id          = $row_user['tesr_user_id'];
   $score_reading    = $row_user['tesr_reading'];
   $score_listening  = $row_user['tesr_listening'];
   $score_speaking   = $row_user['tesr_speaking'];
   $score_writing    = $row_user['tesr_writing'];
   $cmt_speaking_1   = $row_user['tesr_cmt_speaking_1'];
   $cmt_speaking_2   = $row_user['tesr_cmt_speaking_2'];
   $cmt_speaking_3   = $row_user['tesr_cmt_speaking_3'];
   $cmt_writing_1    = $row_user['tesr_cmt_writing_1'];
   $cmt_writing_2    = $row_user['tesr_cmt_writing_2'];
}unset($sqlUser);

$score_total = 0;
$score_total = $score_reading + $score_listening + $score_speaking + $score_writing;
//Diem va level
if($score_reading >= 0 && $score_reading <= 13){
   $level_score_reading = "Low";
   $level_score_reading_abt = "(0 - 13)";
   $cmt_score_reading = "You can do better than that, try to improve your reading skills by completing this course http://hochay.vn/courses/15/reading/4/advanced.html";
}elseif($score_reading >= 14 && $score_reading <= 21){
   $level_score_reading = "Intermediate";
   $level_score_reading_abt = "(14 - 21)";
   $cmt_score_reading = " You can do better than that, try to improve your reading skills by completing this course http://hochay.vn/courses/15/reading/4/advanced.html";
}elseif($score_reading >= 22 && $score_reading <= 30){
   $level_score_reading = "High";
   $level_score_reading_abt = "(22 - 30)";
   $cmt_score_reading = "Comment: You did a good job, why don’t you try another test: http://hochay.vn/courses/9/thi-thu-toefl-ibt/1/beginner.html";
}

if($score_listening >= 0 && $score_listening <= 13){
   $level_score_listening = "Low";
   $level_score_listening_abt = "(0 - 13)";
   $cmt_score_listening = "You can do better than that, try to improve your listening skills by completing this course: http://hochay.vn/courses/16/listening/2/intermediate.html";
}elseif($score_listening >= 14 && $score_listening <= 21){
   $level_score_listening = "Intermediate";
   $level_score_listening_abt = "(14 - 21)";
   $cmt_score_listening = " You can do better than that, try to improve your listening skills by completing this course http://hochay.vn/courses/16/listening/4/advanced.html";
}elseif($score_listening >= 22 && $score_listening <= 30){
   $level_score_listening = "High";
   $level_score_listening_abt = "(22 - 30)";
   $cmt_score_listening = "You did a good job, why don’t you try another test: http://hochay.vn/courses/9/thi-thu-toefl-ibt/1/beginner.html";
}

if($score_speaking >= 0 && $score_speaking <= 13){
   $level_score_speaking = "Limited";
   $level_score_speaking_abt = "(1.5 - 2.0)";
}elseif($score_speaking >= 14 && $score_speaking <= 21){
   $level_score_speaking = "Fair";
   $level_score_speaking_abt = "(2.5 - 3.0)";
}elseif($score_speaking >= 22 && $score_speaking <= 30){
   $level_score_speaking = "Good";
   $level_score_speaking_abt = "(3.5 - 40)";
}

if($score_writing >= 0 && $score_writing <= 13){
   $level_score_writing = "Limited";
   $level_score_writing_abt = "(1.5 - 2.0)";
}elseif($score_writing >= 14 && $score_writing <= 21){
   $level_score_writing = "Fair";
   $level_score_writing_abt = "(2.5 - 3.0)";
}elseif($score_writing >= 22 && $score_writing <= 30){
   $level_score_writing = "Good";
   $level_score_writing_abt = "(3.5 - 40)";
}
//Lay thong tin cua user
$sqlInfo = new db_query("SELECT * FROM users WHERE use_id = ".$user_id);
if($row_info = mysql_fetch_assoc($sqlInfo->result)){
  $user_name = $row_info['use_name'];
  $use_gender = $row_info['use_gender'];
  $user_birth = date('d/m/Y',$row_info['use_birthdays']);
  $email = $row_info['use_email'];
  $avatar = $row_info['use_avatar'];
}unset($sqlInfo);

if($use_gender == 1){
   $gender = 'Male';
}else{
   $gender = 'Female';
}
//mail content
$message = '
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"/>
	
<style>
<!--
	table{line-height:20px;//border:1px solid #000000;border-spacing:1px;}
	td{vertical-align:top;}
	*{margin:0px;padding:0px;}
	#zzz td{border:1px solid;}
-->
</style>
</head>

<body style="font-family:Arial;font-size:13px;">
	<table width="960" style="margin:0 auto;">
		<tr>
			<td></td>
		</tr>
		<tr>
			<td>
				<table>
					<tr>
						<td width="720">
							<table width="710" style="border-spacing:0px;">
								<tr>
									<td colspan="3" width="710">
										<img src="http://hochay.vn/themes/images/images_mail/logo.png"/>
									</td>
								</tr>
								<tr>
									<td width="510" colspan="2" rowspan="3">
										<span style="display:block;margin-left:90px;">
											<h2><i>TOEFL</i></h2>
											Internet-based Test Examinee Score Report<br/>
											for the Test of English as a Foreign Language
										</span>
									</td>
									<td width="200" style="border:none;padding-left:10px;height:20px;">
										<!--blank-->
									</td>
								</tr>
								<tr>
									<td style="border:none;padding-left:10px;height:20px;">
										<!--blank-->
									</td>
								</tr>
								<tr>
									<td style="border:1px solid;border-bottom:none;padding-left:10px">
																	
									</td>
								</tr>
								
								<tr>
									<td colspan="2" border="1" style="border:1px solid;border-right:none;border-bottom:none;padding-left:10px;">
										Registration Number: <span style="display:inline-block;background-color:#404040;color:#FFFFFF;padding-left:5px;padding-right:5px;line-height:18px">0000 0000 0000 0000</span>
									</td>
									<td rowspan="4"style="border:1px solid;padding-left:10px">
										1000
									</td>
								</tr>
								<tr>
									<td colspan="2" style="border:1px solid;border-right:none;border-bottom:none;padding-left:10px">Name: <span style="display:inline-block;background-color:#404040;color:#FFFFFF;padding-left:5px;padding-right:5px;line-height:18px;">'.$user_name.'</span></td>
								</tr>
								<tr>
									<td width="215" style="border:1px solid;border-bottom:none;border-right:none;padding-left:10px">
										Gender:'.$gender.'
									</td>
									<td width="290" style="border:1px solid;border-right:none;border-bottom:none;padding-left:10px">
										Native Country: VietNam
									</td>
								</tr>
								<tr>
									<td style="border:1px solid;border-right:none;padding-left:10px">
										Date of Birth: 
											<span style="display:inline-block;background-color:#404040;color:#FFFFFF;padding-left:5px;padding-right:5px;line-height:18px;">'.$user_birth.'</span>
									</td>
									<td style="border:1px solid;border-right:none;padding-left:10px">
										Native Language: VietNam
									</td>
								</tr>
								<tr>
									<td colspan="2"></td>
									<td>000007</td>
								</tr>
							</table>
							<span style="display:block;margin-left:50px;">
								<h3>&nbsp;&nbsp;&nbsp;&nbsp;000000</h3>
								|||||||||||||||<br/>
								|||||||||<br/>
								|||||||||||||||||||||<br/>
								|||||||||||||||||||||||||||||0000<br/>
								VietNam
							</span>
						</td>
						<td>
							<img style="width:230px;" src="http://hochay.vn/pictures/use_avatar/'.$avatar.'"/>
							<table style="margin:0 auto;text-align:center;border:none;margin-top:10px;" border="1" width="235">
								<thead>
									<tr style="background-color:#221E1F;color:#FFFFFF">
										<th style="border-spacing:0px" colspan="3">TOELF SCALED SCORES</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td style="border:1px solid">Reading</td>
										<td style="border:1px solid"><span style="display:inline-block;background-color:#404040;color:#FFFFFF;width:40px;">'.$score_reading.'</span></td>
									</tr>
									<tr>
										<td style="border:1px solid">Listening</td>
										<td style="border:1px solid"><span style="display:inline-block;background-color:#404040;color:#FFFFFF;width:40px;">'.$score_listening.'</span></td>
									</tr>
									<tr>
										<td style="border:1px solid">Speaking</td>
										<td style="border:1px solid"><span style="display:inline-block;background-color:#404040;color:#FFFFFF;width:40px;">'.$score_speaking.'</span></td>
									</tr>
									<tr>
										<td style="border:1px solid">Writing</td>
										<td style="border:1px solid"><span style="display:inline-block;background-color:#404040;color:#FFFFFF;width:40px;">'.$score_writing.'</span></td>
									</tr>
									<tr>
										<td style="border:1px solid">Total Score</td>
										<td style="border:1px solid"><span style="display:inline-block;background-color:#404040;color:#FFFFFF;width:40px;">'.$score_total.'</span></td>
									</tr>
								</tbody>
							</table>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		
		<tr>
			<td style="height:10px;border-bottom:1px dashed">
			</td>
		</tr>
		
		<tr>
			<td style="padding-top:20px;">
				<table width="960" style="line-height:30px;border:1px solid;border-spacing:0px;font-size:15px">
					<tr style="background-color:#221E1F;color:#FFFFFF;text-align:center;">
						<td width="160" style="border-right:1px solid">Reading Skills</td>
						<td width="110">Level</td>
						<td style="border-left:1px solid">Your Performance</td>
					</tr>
					<tr>
						<td style="padding-left:20px">Reading</td>
						<td style="background-color:#929397;color:#FFFFFF;text-align:center">
							'.$level_score_reading.'<br/>
							'.$level_score_reading_abt.'
						</td>
						<td style="padding-left:50px;font-size:13px">'.$cmt_score_reading.'</td>
					</tr>
					<tr style="background-color:#221E1F;color:#FFFFFF;text-align:center;font-size:15px;">
						<td style="border-right:1px solid">Listening Skills</td>
						<td>Level</td>
						<td style="border-left:1px solid">Your Performance</td>
					</tr>
					<tr>
						<td style="padding-left:20px">Listening</td>
						<td style="background-color:#929397;color:#FFFFFF;text-align:center">
							'.$level_score_listening.'<br/>
							'.$level_score_listening_abt.'
						</td>
						<td style="padding-left:50px;font-size:13px">'.$cmt_score_listening.'</td>
					</tr>
				</table>
				
				<br/>
				
				<table width="960" style="line-height:30px;border:1px solid;border-spacing:0px;font-size:15px">
					<thead>
						<tr style="background-color:#221E1F;color:#FFFFFF;text-align:center;">
							<td width="160" style="border-right:1px solid">Reading Skills</td>
							<td width="110" style="border-left:1px solid">Level</td>
							<td style="border-left:1px solid">Your Performance</td>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td style="padding:0 20px;border-bottom:1px solid;">Speaking about Familiar Topics</td>
							<td rowspan="3" style="background-color:#929397;color:#FFFFFF;text-align:center;border-bottom:1px solid #000000">
   							'.$level_score_speaking.'<br/>
   							'.$level_score_speaking_abt.'
							</td>
							<td style="padding-left:50px;border-bottom:1px solid;font-size:13px">'.$cmt_speaking_1.'</td>
						</tr>
						<tr>
							<td style="padding:0 20px;border-bottom:1px solid;">Speaking about Campus Situations</td>
							<td style="padding-left:50px;border-bottom:1px solid;font-size:13px">'.$cmt_speaking_1.'</td>
						</tr>
						<tr>
							<td style="padding:0 20px">Writing based on Academic Course Content</td>
							<td style="padding-left:50px;font-size:13px">'.$cmt_speaking_1.'</td>
						</tr>					
					</tbody>
					<!---->
					<tr style="background-color:#221E1F;color:#FFFFFF;text-align:center;font-size:15px;">
						<td style="border-right:1px solid">Listening Skills</td>
						<td>Level</td>
						<td style="border-left:1px solid">Your Performance</td>
					</tr>
					<tr>
						<td style="padding:0 20px;border-bottom:1px solid">Writing based on Reading and Listening</td>
						<td rowspan="2" style="background-color:#929397;color:#FFFFFF;text-align:center;border-bottom:1px solid #000000">
							'.$level_score_writing.'<br/>
							'.$level_score_writing_abt.'
						</td>
						<td style="padding-left:50px;border-bottom:1px solid;font-size:13px">'.$cmt_writing_1.'</td>
					</tr>
					<tr>
						<td style="padding:0 20px">Writing based on Knowledge and Experience</td>
						<td style="padding-left:50px;font-size:13px">'.$cmt_writing_2.'</td>
					</tr>					
				</table>
				<br/>
			</td>
		</tr>
		<tr>
			<td>
				<table>
					<tr>
						<td width="480">
							Score Legends:
							<table>
								<tr>
									<td width="190">
										<table width="180" style="border-spacing:0px;text-align:center">
											<tr>
												<td colspan="2" style="border:1px solid;border-bottom:none">Reading Skills</td>
											</tr>
											<tr>
												<td width="90" style="background-color:#D1D2D4;border:1px solid;border-bottom:none;border-right:none">Level</td>
												<td width="90" style="background-color:#D1D2D4;border:1px solid;border-bottom:none">Scaled Score Range</td>
											</tr>
											<tr>
												<td style="border:1px solid;border-bottom:none;border-right:none">High</td>
												<td style="border:1px solid;border-bottom:none">22-30</td>
											</tr>
											<tr>
												<td style="border:1px solid;border-bottom:none;border-right:none">Intermediate</td>
												<td style="border:1px solid;border-bottom:none">14-21</td>
											</tr>
											<tr>
												<td style="border:1px solid;border-right:none">Low</td>
												<td style="border:1px solid">0-13</td>
											</tr>
										</table>
									</td>
									<td width="285" style="padding-left:10px">
										<table style="border-spacing:0px;text-align:center;">
											<tr>
												<td colspan="3" style="border:1px solid;border-bottom:none;">Speaking Skills</td>
											</tr>
											<tr>
												<td width="90" style="border:1px solid;background-color:#D1D2D4;border-bottom:none;border-right:none">Level</td>
												<td width="90" style="border:1px solid;background-color:#D1D2D4;border-bottom:none;border-right:none">Task Rating</td>
												<td width="80" style="border:1px solid;background-color:#D1D2D4;border-bottom:none">Scaled Score Range</td>
											</tr>
											<tr>
												<td style="border:1px solid;border-bottom:none;border-right:none">Good</td>
												<td style="border:1px solid;border-bottom:none;border-right:none">3.5-4.0</td>
												<td style="border:1px solid;border-bottom:none">22-30</td>
											</tr>
											<tr>
												<td style="border:1px solid;border-bottom:none;border-right:none">Fair</td>
												<td style="border:1px solid;border-bottom:none;border-right:none">2.5-3.0</td>
												<td style="border:1px solid;border-bottom:none">14-21</td>
											</tr>
											<tr>
												<td style="border:1px solid;border-bottom:none;border-right:none">Limited</td>
												<td style="border:1px solid;border-bottom:none;border-right:none">1.5-2.0</td>
												<td style="border:1px solid;border-bottom:none">0-13</td>
											</tr>
											<tr>
												<td style="border:1px solid;border-right:none">Weak</td>
												<td style="border:1px solid;border-right:none">0-1.0</td>
												<td style="border:1px solid"></td>
											</tr>
										</table>
									</td>
								</tr>
								<tr>
									<td style="padding-top:20px;">
										<table style="border-spacing:0px;text-align:center;">
											<tr>
												<td colspan="2" style="border:1px solid;border-bottom:none">Listening Skills</td>
											</tr>
											<tr>
												<td width="90" style="background-color:#D1D2D4;border:1px solid;border-bottom:none;border-right:none">Level</td>
												<td width="90" style="background-color:#D1D2D4;border:1px solid;border-bottom:none">Scaled Score Range</td>
											</tr>
											<tr>
												<td style="border:1px solid;border-bottom:none;border-right:none">High</td>
												<td style="border:1px solid;border-bottom:none">22-30</td>
											</tr>
											<tr>
												<td style="border:1px solid;border-bottom:none;border-right:none">Intermediate</td>
												<td style="border:1px solid;border-bottom:none">14-21</td>
											</tr>
											<tr>
												<td style="border:1px solid;border-right:none">Low</td>
												<td style="border:1px solid">0-13</td>
											</tr>
										</table>
									</td>
									<td style="padding-top:20px;padding-left:10px">
										<table style="border-spacing:0px;text-align:center;">
											<tr>
												<td colspan="3" style="border:1px solid;border-bottom:none">Writing Skills</td>
											</tr>
											<tr>
												<td width="90" style="border:1px solid;background-color:#D1D2D4;border-bottom:none;border-right:none">Level</td>
												<td width="90" style="border:1px solid;background-color:#D1D2D4;border-bottom:none;border-right:none">Task Rating</td>
												<td width="80" style="border:1px solid;background-color:#D1D2D4;border-bottom:none">Scaled Score Range</td>
											</tr>
											<tr>
												<td style="border:1px solid;border-bottom:none;border-right:none">Good</td>
												<td style="border:1px solid;border-bottom:none;border-right:none">3.5-4.0</td>
												<td style="border:1px solid;border-bottom:none">22-30</td>
											</tr>
											<tr>
												<td style="border:1px solid;border-bottom:none;border-right:none">Fair</td>
												<td style="border:1px solid;border-bottom:none;border-right:none">2.5-3.0</td>
												<td style="border:1px solid;border-bottom:none">14-21</td>
											</tr>
											<tr>
												<td style="border:1px solid;border-bottom:none;border-right:none">Limited</td>
												<td style="border:1px solid;border-bottom:none;border-right:none">1.5-2.0</td>
												<td style="border:1px solid;border-bottom:none">0-13</td>
											</tr>
											<tr>
												<td style="border:1px solid;border-right:none">Weak</td>
												<td style="border:1px solid;border-right:none">0-1.0</td>
												<td style="border:1px solid"></td>
											</tr>
										</table>

									</td>
								</tr>
							</table>
						</td>
						<td width="470" style="padding-left:5px">
							<table width="470" height="190" style="border-spacing:0px;margin-top:20px;margin-bottom:20px">
								<tr height="20">
									<td style="border:1px solid;border-right:none;border-bottom:none;"><span style="margin-left:20px;">DEPT.</span></td>
									<td style="border:1px solid;border-left:none;text-align:center;border-bottom:none;">WHERE THE REPORT WAS SENT</td>
								</tr>
								<tr>
									<td style="border:1px solid;border-right:none"></td>
									<td style="border:1px solid;border-left:none"></td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
</body>
</html>
';
?>
<?
//========== variable json=========//
$msg   = "";
$err 	 = "";
$json  = array();
$fs_errorMsg = "";
//====== get variable answers=====//
if($cmt_speaking_1 != '' && $cmt_speaking_2 != '' && $cmt_speaking_3 != '' && $cmt_writing_1 != '' && $cmt_writing_2 != ''){
   $sendMail = new sendMail();
   $sendMail->init();
   $isSuccess = $sendMail->send($message, $email, 'You');
   $db_ex = new db_execute("UPDATE test_result SET tesr_teach_success = 1 WHERE tesr_id = " . $tesr_id);
   if($isSuccess == true){
      $msg = "Gửi mail thành công";   
   }else{
      $err = "Có lỗi xảy ra trong quá trình gửi mail!";
   }
}else{
   $err = "Bạn chưa chấm điểm hoặc thiếu nhận xét cho bài thi !";
}
//==================
$json['msg'] = $msg;
$json['err'] = $err;
echo json_encode($json);
?>