<?php 
require_once('config.php');

$text          = getValue('searchtext','str','GET','');
$iCategory     = getValue('iCategory','int','GET',0);
$dbSelectCourses = new db_query("SELECT * FROM `courses` WHERE `cou_name` LIKE '%".$text."%' ORDER BY `cou_name` ASC LIMIT 15");
$arrCourses = $dbSelectCourses->resultArray();
unset($dbSelectCourses);
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title>Học Tiếng Anh Online, Tiếng Anh giao tiếp, thi TOEIC, IELTS, TOEFL</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="Học tiếng Anh Online, Tiếng Anh giao tiếp, luyện thi TOEFL, IELTS, TOEIC, kỹ năng Tiếng Anh, Tiếng Anh phổ thông, tiếng anh văn phòng, tiếng Anh trẻ em">
<meta name="keywords" content="Học tiếng Anh online, khóa học tiếng Anh, luyện thi TOEIC, IELTS, TOEFL, Ngữ pháp tiếng Anh, Từ vựng tiếng Anh, CLB tiếng Anh">
<meta property="og:url" content="http://<?=$base_url?>/">
<meta property="og:title" content="Tienganh2020.com - Học Tiếng Anh Online, học Tiếng Anh chất lượng cao">
<meta property="og:description" content="Học Tiếng Anh trực tuyến, học ngoại ngữ online, luyện giao tiếp Tiếng Anh, luyện thi TOEFL,IELTS,TOEIC, luyện kỹ năng Tiếng Anh">
<meta property="og:type" content="website">
<meta property="og:image" content="http://<?=$base_url?>/themes_v2/images/logo_fav.jpg">
<meta property="og:site_name" content="tienganh2020.com">

<link rel="icon" type="image/x-icon" href="http://<?=$base_url?><?=$var_path_img?>favicon.ico" />
<link rel="shortcut icon" href="http://<?=$base_url?><?=$var_path_img?>favicon.ico" />

<?=$var_general_css?>
<?=$var_general_js?>
<script>
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
</script>

</head>

<body>
<div class="wrap">
    <?php include_once('../includes/inc_header.php');?>
    <div class="main">
        <div class="module">
            <div class="list-courses">
    <div class="list-courses-filter">
        <div class="content">
            <div class="content-main">
                <div class="list-courses-filter-title">
                    <div class="list-courses-filter-title-main">
                        <span>TÌM KIẾM KHÓA HỌC</span>
                    </div>
                    <span class="list-courses-filter-title-breadcrumb">
                        <a>Trang chủ</a> 
                        <span></span>
                        <a>Tìm kiếm khóa học</a>
                    </span>
                </div>
                <div class="list-courses-filter-search">
                    <form method="get" id="courses-search" class="courses-search" action="#">
                        <input id="searchtext" class="searchtext-module" name="searchtext" type="text" value="" placeholder="Khóa học">
                        <input type="hidden" name="search-type" value="courses">
                        <input type="submit" class="search-searchtext-module" value="">
                    </form>
                </div>
                <div class="list-courses-filter-title-description"></div>
            </div>
        </div>
    </div>
    <div class="list-courses-main">
        <div class="content">
            <div class="content-main">
                <div class="list-courses-main-content">
                    <div class="list-courses-main-content-show">
                        <?php for($i = 0;$i <= 14;$i++){ ?>
                            <?php if(isset($arrCourses[$i]['cou_id'])){ ?>
                                <?php
                                $url    = gen_course_details($arrCourses[$i]['cou_id'],0);
                                $name   = truncateString_($arrCourses[$i]['cou_name'],20);
                                ?>
                                <div class="content-show-courses">
                                    <div class="content-show-courses-img">
                                        <a href="<?=$url?>">
                                            <img src="<?=$var_path_course_medium.$arrCourses[$i]['cou_avatar']?>" alt="<?=$name?>">
                                        </a>
                                    </div>
                                    <div class="content-show-courses-info">
                                        <a href="<?=$url?>">
                                            <div class="content-show-courses-info-title">
                                                <span><?=$name?></span>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            <?php } ?>
                        <?php } ?>
                    </div>
                </div>
                <div class="list-courses-main-sidebar">
                    <?php include_once('../includes/inc_sidebar_courses.php');?>
                </div>
            </div>
        </div>
    </div>
</div>
        </div>
    </div>
    <?php include_once('../includes/inc_footer.php');?>
</div>
</body>
</html>