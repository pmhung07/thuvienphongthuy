<?
$isAdmin = isset($_SESSION["isAdmin"]) ? intval($_SESSION["isAdmin"]) : 0;

?>
<div class="header">
	<table cellpadding="0" cellspacing="0"  width="100%">
		<tr>
			<td style="font-size:14px;color:white!important;">Hệ thống quản trị website</td>
			<td align="right">
				<a href="resource/profile/myprofile.php" target="mainFrame">Hi! <?=getValue("userlogin","str","SESSION","")?></a> 
				&nbsp;|&nbsp;
				<a href="resource/profile/myprofile.php" target="mainFrame"><?=translate_text("Thông tin tài khoản")?></a> 
				&nbsp;|&nbsp;
				<?
				//kiem tra xem neu la o tren localhost thi moi co quyen cau hinh
				$url = $_SERVER['SERVER_NAME'];
				//if($isAdmin==1 && ($url == "localhost" || strpos($url,"192.168.1")!==false)){
				if($isAdmin==1){
				?>
				<a href="resource/configadmin/configmodule.php" target="mainFrame"><?=translate_text("Website Settings")?></a> 
				&nbsp;|&nbsp;
				<?
				}
				?>
				<a href="resource/logout.php"><?=translate_text("Logout")?></a>
			</td>
			<td>&nbsp;</td>
		</tr>
	</table>
</div>