<?
if ($_SERVER['SERVER_NAME'] != "localhost"){
	//Đặt session memcached
	//$memcached_host = "198.187.29.43";
	//$memcached_port = "21";
	//$session_save_path = $memcached_host . ":" . $memcached_port; 
	
	//@ini_set('session.save_handler', 'memcache'); 
	//@ini_set('session.save_path', $session_save_path);  
}

@session_start();
?>