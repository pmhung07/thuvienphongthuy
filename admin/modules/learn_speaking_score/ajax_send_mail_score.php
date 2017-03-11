<?
require_once("inc_security.php");
require_once("class.phpmailer.php");
require_once("class.smtp.php");
require_once("send_mail.php");
?>
<?
$tesr_id = getValue("record_id","int","POST",0);
$time      = time();
$time_cv   =  date("d/m/Y",$time);
$gender    = '';
$birth     = '';
$wri_id    = '';
$comment   = '';
$content   = '';
$point     = '';
$date_lear = '';
//Lay thong tin cua bai da thi
$sqlUser = new db_query("SELECT * FROM learn_speak_result WHERE lsr_id = ".$tesr_id);
if($row_user = mysql_fetch_assoc($sqlUser->result)){
   $user_id          = $row_user['lsr_use_id'];
   $spe_id           = $row_user['lsr_spe_id'];
   $comment          = $row_user['lsr_comment'];
   $point            = $row_user['lsr_point'];
   $date_lear        = date('d/m/Y',$row_user['lsr_date']);
}unset($sqlUser);

// Lấy thông tin của khóa học
$db_listing 	= new db_query("SELECT * FROM learn_speaking 
                               INNER JOIN courses_multi ON learn_speaking.learn_unit_id=courses_multi.com_id
                               INNER JOIN courses ON courses_multi.com_cou_id = courses.cou_id
							   INNER JOIN categories_multi ON courses.cou_cat_id = categories_multi.cat_id
							   WHERE learn_speaking.learn_sp_id =".$spe_id);
if($row_cate	=	mysql_fetch_assoc($db_listing->result)){
	$name_lesson  =   $row_cate['com_name'];
	$id_lesson    =   $row_cate['com_id'];
}unset($db_listing);							   
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
											<h2><i>SPEAKING</i></h2>
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
									<td style="border:1px solid;border-right:none;padding-left:10px">
										Day : 
											<span style="display:inline-block;background-color:#404040;color:#FFFFFF;padding-left:5px;padding-right:5px;line-height:18px;">'.$date_lear.'</span>
									</td>
									<td style="border:1px solid;border-right:none;padding-left:10px">Home page :  <a href="http://hochay.vn">www.hochay.vn</a></td>
								</tr>
								<tr>
									<td colspan="2"></td>
									<td></td>
								</tr>
							</table>
						</td>
						<td>			
				
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
						<td width="260" style="border-right:1px solid">Speaking Skills</td>
						<td width="110">Course</td>
						<td style="border-left:1px solid">Comment</td>
                        <td style="border-left:1px solid" width="110">Point</td>
					</tr>
					<tr>
						<td style="padding-left:20px"></td>
						<td style="background-color:#929397;color:#FFFFFF;text-align:center">
							'.$name_lesson.'<br/>
						</td>
						<td style="padding-left:50px;font-size:13px">'.$comment.'</td>
                        <td style="background-color:#929397;color:#FFFFFF;text-align:center">'.$point.'</td>
					</tr>
				</table>
				
				<br/>
				
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
if($point  != '0'){
   $sendMail = new sendMail();
   $sendMail->init();
   $isSuccess = $sendMail->send($message, $email, 'You');
  
   if($isSuccess == true){
	  $db_ex = new db_execute("UPDATE learn_speak_result SET lsr_smail = 1 WHERE lsr_id = " . $tesr_id);
      $msg = "Gửi mail thành công";  
	  $err = 1; 
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