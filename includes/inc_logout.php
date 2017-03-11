<?php
require_once("config.php");

session_destroy();
setcookie("login_name","",time()-200000);
setcookie("PHPSESS1D","",time()-200000);
setcookie("u_id","",time()-200000);
$myuser->logout();
redirect("http://".$base_url); // Move back to login.php with a logout message
?>