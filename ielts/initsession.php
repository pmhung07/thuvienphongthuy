<?
@session_start();
if (!isset($_SESSION["alive"])){
	session_regenerate_id(true);
	$_SESSION["alive"] = 1;
}
//echo session_id();
ob_start();
?>