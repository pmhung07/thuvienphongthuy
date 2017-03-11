<?php
require_once("config.php");
require_once 'google-api-php-client/src/Google/autoload.php';
//require_once 'google-api-php-client/src/Google/Client.php';
//require_once 'google-api-php-client/src/Google/Service/Oauth2.php';
session_start();

$client = new Google_Client();
$client->setAuthConfigFile('google-api-php-client/client_secrets.json');
$client->setRedirectUri('http://' . $_SERVER['HTTP_HOST'] . '/home/oauth2callback.php');
$client->addScope(Google_Service_Oauth2::USERINFO_EMAIL);
$client->addScope(Google_Service_Oauth2::USERINFO_PROFILE);
if (! isset($_GET['code'])) {
	$auth_url = $client->createAuthUrl();
	header('Location: ' . filter_var($auth_url, FILTER_SANITIZE_URL));
} else {
	$client->authenticate($_GET['code']);
	$_SESSION['access_token'] = $client->getAccessToken();
	$redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . '/khoa-hoc/2/tieng-anh-giao-tiep.html';
	$oauth2Service = new Google_Service_Oauth2($client);
	$dataResult = $oauth2Service->userinfo->get();
	$userName = $dataResult['family_name'];
	$userEmail = $dataResult['email'];
	$myuser->fake_login_openid($userEmail,$userName,$userName);
	header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
}