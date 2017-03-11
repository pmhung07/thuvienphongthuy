<?php

/*------------------------------------------*/
$load_time = microtime(); 
$load_time = explode(' ',$load_time); 
$load_time = $load_time[1] + $load_time[0]; 
$page_start = $load_time;
/*------------------------------------------*/

require_once('config.php');
$module = getValue("module","str","GET","");
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" xmlns:fb="https://www.facebook.com/2008/fbml">
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
    <?=$var_general_css?>
    <?=$var_general_js?>
    <script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-78577108-1', 'auto');
    ga('send', 'pageview');

    </script>

    <?php
    /**
    *
    * CONFIG CSS HERE
    *
    */
    ?>
    <!--FACEBOOK-->
    <div id="fb-root"></div>
    <script>(function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/en_GB/sdk.js#xfbml=1&appId=783590098395911&version=v2.0";
    fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>
    
    <!--GOOGLE ANALYTICS-->
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
        <?php include_once('../includes/inc_header.php'); ?>
        <div class="main" <?=($module == 'courseinfo')?'style="background-color: #e0dddd;"':'';?>>
            <div class="module">
                <?php
                /**
                *
                * CONTROLLER HERE
                *
                */
                switch($module){
                    // TEMPLATE
                    case 'coursecategory':
                        include_once('../includes/courses/inc_courses_listing.php');
                    break;
                    case 'courseinfo':
                        include_once('../includes/courses/inc_courses_info.php');
                    break;
                    case 'courselesson':
                        include_once('../includes/courses/inc_courses_lesson.php');
                    break;
                    case 'cvcategory':
                        include_once('../includes/coverletters/inc_cv_listing.php');
                    break;
                    case 'cvcategorydetails':
                        include_once('../includes/coverletters/inc_cv_details.php');
                    break;
                    case 'newcategory':
                        include_once('../includes/news/inc_news_listing.php');
                    break;
                    case 'newcategorydetails':
                        include_once('../includes/news/inc_news_details.php');
                    break;
                    case 'introduce':
                        include_once('../includes/template/inc_introduce.php');
                    break;
                    case 'courseinfo':
                        include_once('../includes/template/inc_courses_info.php');
                    break;
                    case 'coursedetails':
                        include_once('../includes/template/inc_courses_details.php');
                    break;
                    // MAIN
                    case 'login':
                        include_once('../includes/inc_login.php');
                    break;
                    case 'logout':
                        include_once('../includes/inc_logout.php');
                    break;
                    case 'listCourses':
                        checkuserinfo($myuser->logged,$myuser->use_name,$myuser->use_phone);
                        include_once('../includes/inc_list_courses.php');
                    break;
                    case 'listCoursesInfo':
                        checkuserinfo($myuser->logged,$myuser->use_name,$myuser->use_phone);
                        include_once('../includes/inc_list_courses_info.php');
                    break;
                    case 'listCoursesMain':
                        checkuserinfo($myuser->logged,$myuser->use_name,$myuser->use_phone);
                        include_once('../includes/inc_list_courses_main.php');
                    break;
                    case 'listSkills':
                        checkuserinfo($myuser->logged,$myuser->use_name,$myuser->use_phone);
                        include_once('../includes/inc_list_skills.php');
                    break;
                    case 'listSkillsDetails':
                        checkuserinfo($myuser->logged,$myuser->use_name,$myuser->use_phone);
                        include_once('../includes/inc_list_skills_details.php');
                    break;
                    case 'listLibraries':
                        include_once('../includes/inc_list_libraries.php');
                    break;
                    case 'listLibrariesDetails':
                        include_once('../includes/inc_list_libraries_details.php');
                    break;
                    case 'listCommunity':
                        include_once('../includes/inc_list_community.php');
                    break;
                    case 'listCommunityDetails':
                        include_once('../includes/inc_list_community_details.php');
                    break;
                    //case 'listNews':
                        //include_once('../includes/inc_list_news.php');
                    //break;
                    case 'listNewsDetails':
                        include_once('../includes/inc_list_news_details.php');
                    break;
                    case 'payment':
                        include_once('../includes/payment/inc_payment.php');
                    break;
                    case 'paymentMethod':
                        include_once('../includes/payment/inc_payment_method.php');
                    break;
                    case 'user':
                        include_once('../includes/user/inc_user.php');
                    break;
                    case 'userViewInfo':
                        include_once('../includes/user/inc_courses_viewinfo.php');
                    break;
                }
                ?>
            </div>
        </div>
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
echo("<span style='font-size:11px; display: block; text-align: center;'>Page generated in " . $page_load_time . " seconds</span>");
/*------------------------------------------*/
?>