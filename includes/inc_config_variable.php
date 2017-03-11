<?php

$base_url                     	=  $_SERVER['HTTP_HOST'];

$path_root                    	=  '/home/';
$var_path_img                 	=  '/themes/img/';
$var_path_js                  	=  '/themes/js/';
$var_path_css                 	=  '/themes/css/';
$var_path_media_player_js		=  '/mediaplayer/';

$var_path_course        		=  '/pictures/courses/';
$var_path_course_medium        	=  '/pictures/courses/medium_';
$var_path_course_small        	=  '/pictures/courses/small_';

$var_path_cv        		    =  '/pictures/cover_letters/';
$var_path_cv_medium        		=  '/pictures/cover_letters/medium_';
$var_path_cv_small        		=  '/pictures/cover_letters/small_';

$var_path_news        		    =  '/pictures/posts/';
$var_path_news_medium        	=  '/pictures/posts/medium_';
$var_path_news_small        	=  '/pictures/posts/small_';

$var_general_css    			= '';
$var_general_css   	   		   .= '<link type="text/css" rel="stylesheet" href="' . $var_path_css . 'bootstrap.min.css"/>';
$var_general_css   		  	   .= '<link type="text/css" rel="stylesheet" href="' . $var_path_css . 'style.css"/>';
$var_general_css   			   .= '<link type="text/css" rel="stylesheet" href="' . $var_path_css . 'style_tab.css"/>';
$var_general_css   	   		   .= '<link type="text/css" rel="stylesheet" href="' . $var_path_css . 'style_smp.css"/>';
$var_general_css   	   		   .= '<link type="text/css" rel="stylesheet" href="' . $var_path_css . 'jquery.fancybox.css"/>';

$var_general_js    			    =  '';
$var_general_js    			   .= '<script type="text/javascript" src="' . $var_path_js . 'jquery-1.7.2.js"></script>';
$var_general_js    			   .= '<script type="text/javascript" src="' . $var_path_js . 'functions.js"></script>';
$var_general_js    			   .= '<script type="text/javascript" src="' . $var_path_js . 'bootstrap.min.js"></script>';
$var_general_js    			   .= '<script type="text/javascript" src="' . $var_path_js . 'jquery.fancybox.pack.js"></script>';

$var_general_js				   .= '<script type="text/javascript" src="' . $var_path_js . 'jquery.media.js"></script>';
$var_general_js    			   .= '<script type="text/javascript" src="' . $var_path_js . 's3Slider.js"></script>';
$var_general_js    			   .= '<script type="text/javascript" src="' . $var_path_js . 's3SliderPacked.js"></script>';	

$var_general_js    			   .= '<script type="text/javascript" src="' . $var_path_media_player_js . 'jwplayer.js"></script>';
$var_general_js				   .= '<script type="text/javascript">jwplayer.key="IyBF3HN/WxYyCXbdjRCOrUH3C4FJGuzHP9SQ6mz/YQcKlam8eP/Fvm6VM6g=";</script>';
$var_general_js    			   .= '<script type="text/javascript" src="' . $var_path_js . 'slick/slick.min.js"></script>';
$var_general_js    			   .= '<script type="text/javascript" src="' . $var_path_js . 'slick/slick.css"></script>';

?>