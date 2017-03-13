<?php
/*------------------------------------------*/
$load_time = microtime();
$load_time = explode(' ',$load_time);
$load_time = $load_time[1] + $load_time[0];
$page_start = $load_time;
/*------------------------------------------*/

//ini_set('zlib_output_compression','On');
require_once('config.php');

//if($myuser->logged == 1){
	//redirect('http://'.$base_url.'/khoa-hoc/2/tieng-anh-giao-tiep.html');
//}
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title>Thư viện phong thuỷ</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="Kiến thức phong thủy · Thiết kế Phong thủy · Câu chuyện Phong thủy · Kiến thức Tử vi · Phần mềm Phong thủy · Nhân Tướng Học · Tổng hợp · Sách...">
<meta name="keywords" content="">
<meta property="og:url" content="http://<?=$base_url?>/">
<meta property="og:title" content="Kiến thức phong thủy · Thiết kế Phong thủy · Câu chuyện Phong thủy · Kiến thức Tử vi · Phần mềm Phong thủy · Nhân Tướng Học · Tổng hợp · Sách...">
<meta property="og:description" content="Kiến thức phong thủy, Thiết kế Phong thủy,Câu chuyện Phong thủy,Kiến thức Tử vi, Phần mềm Phong thủy, Nhân Tướng Học, Tổng hợp, Sách...">
<meta property="og:type" content="website">
<meta property="og:image" content="http://<?=$base_url?>/themes_v2/images/logo_fav.jpg">
<meta property="og:site_name" content="http://thuvienphongthuy.vn/">

<link rel="icon" type="image/x-icon" href="http://<?=$base_url?><?=$var_path_img?>favicon.ico" />
<link rel="shortcut icon" href="http://<?=$base_url?><?=$var_path_img?>favicon.ico" />
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-78577108-1', 'auto');
  ga('send', 'pageview');

</script>

<?=$var_general_css?>
<?=$var_general_js?>
<!--<script>
  	window.fbAsyncInit = function() {
    FB.init({
      	appId      : '783590098395911',
      	xfbml      : true,
      	version    : 'v2.2'
    });
};
(function(d, s, id){
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) {return;}
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/en_US/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));
</script>

<script>
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
      ga('create', 'UA-59475247-1', 'auto');
      ga('send', 'pageview');
</script>-->

</head>

<body>
<div class="wrap">
    <?php include_once('../includes/inc_header.php');?>
    <?php include_once('../includes/inc_main.php');?>
    <?php include_once('../includes/inc_footer.php');?>
</div>
</body>
</html>

<?php
/*------------------------------------------*/
$load_time = microtime();
$load_time = explode(' ',$load_time);
$load_time = $load_time[1] + $load_time[0];
$page_end = $load_time;
$final_time = ($page_end - $page_start);
$page_load_time = number_format($final_time, 9, '.', '');
//echo("<span style='font-size:11px; display: block; text-align: center;'>Page generated in " . $page_load_time . " seconds</span>");
/*------------------------------------------*/
?>