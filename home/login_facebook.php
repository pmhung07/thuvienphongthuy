<?php
require_once("config.php");
$app_id = "783590098395911";
$app_secret = "9d7d613cdb798fc4958ec0748c50b98c";
$my_url = "http://".$base_url."/home/login_facebook.php";

$code = @$_REQUEST["code"];

if(empty($code)) {
    $dialog_url = "https://www.facebook.com/dialog/oauth?client_id=" . $app_id . "&redirect_uri=" . urlencode($my_url) . "&scope=user_about_me,email";
    echo("<script>window.parent.location.href='"  . $dialog_url ."';</script>");
}

$token_url = "https://graph.facebook.com/oauth/access_token?" . "client_id=" . $app_id . "&redirect_uri=" . urlencode($my_url) . "&client_secret=" . $app_secret . "&code=" . $code;

$response = file_get_contents($token_url);
$params = null;
parse_str($response, $params);

$graph_url = "https://graph.facebook.com/me?fields=picture,id,email,name&access_token=" 
. $params['access_token'];

$user = json_decode(file_get_contents($graph_url));
$user_id = $user->id;
$user_email = $user->email;
$user_name = 'Tân Binh';
//$user_name = $user->name;

$myuser->fake_login_openid($user_email,$user_name,"");

redirect("http://".$base_url."/khoa-hoc/2/tieng-anh-giao-tiep.html");

?>