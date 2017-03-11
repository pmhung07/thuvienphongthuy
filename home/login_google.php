<?php
require_once("config.php");
require_once 'google-api-php-client/src/Google/autoload.php';
//require_once 'google-api-php-client/src/Google/Client.php';
//require_once 'google-api-php-client/src/Google/Service/Oauth2.php';

$client = new Google_Client();
$client->setAuthConfigFile('google-api-php-client/client_secrets.json');
$client->addScope(Google_Service_Oauth2::USERINFO_EMAIL);
$client->addScope(Google_Service_Oauth2::USERINFO_PROFILE);

$objOAuthService = new Google_Service_Oauth2($client);

if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
	$client->setAccessToken($_SESSION['access_token']);
	$drive_service = new Google_Service_Oauth2($client);
	$dataResult = $drive_service->userinfo->get();
	$userName = $dataResult['family_name'];
	$userEmail = $dataResult['email'];
	//$myuser->fake_login_openid($userEmail,$userName,$userName);
	$redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . '/home/oauth2callback.php';
	header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
} else {
	$redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . '/home/oauth2callback.php';
	header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
}

?>


