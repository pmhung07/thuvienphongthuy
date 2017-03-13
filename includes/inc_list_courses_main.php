<?php

$arrCategory        = array();
$arrCourses         = array();
$arrItemCourses     = array();

$iCou    = getValue("iCourse","int","GET",""); //id khóa học
$nCou    = getValue("nCourse","str","GET","");//tên khóa học
$iUnit   = getValue("iUnit","int","GET",""); // id của unit khóa học
$type    = getValue("type","str","GET",""); // kiểu bài hoc : main,voca,gram..
$med     = getValue("med","str","GET",""); // chữa bài

$str_cate = ""; //chuoi danh muc dat vao url
$c_num = 0;
$time = time();

$sqlForm    = new db_query('SELECT * FROM courses WHERE cou_id = '.$iCou);
if($row_form     = mysqli_fetch_assoc($sqlForm->result)){
    $cou_form     = $row_form['cou_form'];
    $cou_id       = $row_form['cou_id'];
    $cou_inf      = $row_form['cou_info'];
    $course_name  = $row_form['cou_name'];
}unset($sqlForm);

$sqlcName = new db_query('SELECT com_name,com_num_unit FROM courses_multi WHERE com_cou_id = '.$iCou.' AND com_id = '.$iUnit);
if($row_cName = mysqli_fetch_assoc($sqlcName->result)){
    $c_name = $row_cName['com_name'];
    $c_num  = $row_cName['com_num_unit'];
}unset($sqlcName);


$sqlinfo = new db_query('SELECT cou_name,cat_name,cat_id,cat_parent_id,cou_lev_id FROM courses a,categories_multi b WHERE a.cou_cat_id = b.cat_id AND cou_id='.$iCou);
$rowInfo   = mysqli_fetch_assoc($sqlinfo->result);
    $lev_id        = $rowInfo['cou_lev_id'];
    $cat_id        = $rowInfo['cat_id'];
    $cat_parent_id = $rowInfo['cat_parent_id'];
    $cat_name_inf  = $rowInfo['cat_name'];
    $cou_name_inf  = $rowInfo['cou_name'];
unset($sqlinfo);

$checkCourseActive = check_course_active($myuser->u_id);

?>

<div class="list-courses">
    <div class="list-courses-filter">
        <div class="content">
            <div class="content-main">
                <div class="list-courses-filter-title">
                    <div class="wrap-search-google-module">
                        <div class="search-google-module">
                            <script>
                            (function() {
                            var cx = '014392461875755904911:x7kjjrisdw4';
                            var gcse = document.createElement('script');
                            gcse.type = 'text/javascript';
                            gcse.async = true;
                            gcse.src = (document.location.protocol == 'https:' ? 'https:' : 'http:') +
                            '//www.google.com/cse/cse.js?cx=' + cx;
                            var s = document.getElementsByTagName('script')[0];
                            s.parentNode.insertBefore(gcse, s);
                            })();
                            </script>
                            <gcse:search></gcse:search>
                        </div>
                    </div>
                    <div class="list-courses-filter-title-main">
                        <h1>
                            <span><?=$course_name?></span>
                        </h1>
                    </div>
                    <span class="list-courses-filter-title-breadcrumb">
                        <?=breadcrumb_cate_page($cat_id);?>
                    </span>
                </div>
                <div class="list-courses-filter-search">
                    <form method="get" id="courses-search" class="courses-search" action="http://<?=$base_url?>/home/search.php">
                        <input type="submit" class="search-searchtext-module" value="">
                        <input id="searchtext" class="searchtext-module" name="searchtext" type="text" value="" placeholder="Khóa học">
                        <input type="hidden" name="search-type" value="courses">
                    </form>
                </div>
                <div class="list-courses-filter-title-description">
                    <?=removeHTML($cou_inf)?>
                </div>
            </div>
        </div>
    </div>

    <div class="list-courses-main">
        <div class="content">
            <div class="content-main">
                <div class="list-courses-main-content">
                    <div class="menu-course-unit">
                        <div class="menu-category-title-unit">
                            <span>DANH MỤC BÀI HỌC</span>
                        </div>
                        <div class="menu-category-content-unit">
                            <ul>
                                <?php
                                $i = 0;
                                $sqlUnitNum    = new db_query("SELECT com_id,com_num_unit,com_name FROM courses_multi WHERE com_cou_id = ".$iCou." ORDER BY com_num_unit");
                                while($rowUnitNum   = mysqli_fetch_assoc($sqlUnitNum->result)){
                                $i++;
                                $com_id = $rowUnitNum['com_id'];
                                $com_name = $rowUnitNum['com_name'];
                                $com_num_unit = $rowUnitNum['com_num_unit'];

                                $checkCourseActive = check_course_active($myuser->u_id);
                                if($checkCourseActive == 1){
                                    $logcourse = '';
                                }else{
                                    if($com_num_unit == 1){
                                        $logcourse = '';
                                    }else{
                                        $logcourse = 'logcourse';
                                    }
                                }

                                ?>
                                    <a href="<?=gen_course_details(0,$com_id)?>" class="item-parent-menu-courses <?=($rowUnitNum['com_id']==$iUnit)?'item-menu-active-unit':'';?>">
                                        <li class="<?=$logcourse?>">
                                            Bài <?=$rowUnitNum['com_num_unit']?> : <?=truncateString_($rowUnitNum['com_name'],25)?>
                                        </li>
                                    </a>
                                <?php }unset($sqlUnitNum);?>
                            </ul>
                        </div>
                    </div>
                    <div class="nav-menu-wrap">
                    	<div class="nav-menu">
                    		<ul>
                            <?php if($cou_form == 1 || $cou_form == 2){ ?>
                                <?php
                                $link_nav_main          =  "http://".$base_url."/khoa-hoc/". removeTitle($nCou)	.	"/" . $iCou . "/" . $iUnit . "/main.html";
                                $link_nav_grammar       =  "http://".$base_url."/khoa-hoc/". removeTitle($nCou)	.	"/" . $iCou . "/" . $iUnit . "/grammar.html";
                                $link_nav_vocabulary	=  "http://".$base_url."/khoa-hoc/". removeTitle($nCou)	.	"/" . $iCou . "/" . $iUnit . "/vocabulary.html";
                                $link_nav_quiz	        =  "http://".$base_url."/khoa-hoc/". removeTitle($nCou)	.	"/" . $iCou . "/" . $iUnit . "/quiz.html";
                                $link_nav_speak         =  "http://".$base_url."/khoa-hoc/". removeTitle($nCou)	.	"/" . $iCou . "/" . $iUnit . "/speak.html";
                                $link_nav_write         =  "http://".$base_url."/khoa-hoc/". removeTitle($nCou)	.	"/" . $iCou . "/" . $iUnit . "/write.html";
                                ?>

                                <?php if (checkLesson($iUnit,'main') == 1){ ?>
                                    <li class="nav-menu-item <?if($type=="main"){echo "active act_ho";}?>" data-url="main-lesson">
                                        <a href="<?=$link_nav_main?>" title="Bài nghe">
                                            <span>
                                            <?php   if($row_form['cou_cat_id'] == 42 || $row_form['cou_cat_id'] == 43)
                                                        echo 'Bài đọc';
                                                    else echo 'Bài nghe';?>
                                            </span>
                                        </a>
                                    </li>
                                <?php } ?>

                                <?php if (checkLearn($iUnit,'speaking') == 1){ ?>
                                    <!--<li class="nav-menu-item <?//if($type=="speak"){ echo "active act_ho";}?>" data-url="speaking-practice">
                                        <a href="<?//=$link_nav_speak?>" title="Bài nói">
                                            <span>Bài nói</span>
                                        </a>
                                    </li>-->
                                <?php } ?>

                                <?php if (checkLearn($iUnit,'writing') == 1) { ?>
                                   <li class="nav-menu-item <?if($type=="write"){echo "active act_ho";}?>" data-url="writting-practice">
                                        <a href="<?=$link_nav_write?>" title="Bài viết">
                                            <span>Bài viết</span>
                                        </a>
                                    </li>
                                <?php } ?>

                                <?php if (checkLesson($iUnit,'grammar') == 1){ ?>
                                   <li class="nav-menu-item <?if($type=="grammar"){echo "active act_ho";}?>" data-url="grammar">
                                        <a href="<?=$link_nav_grammar?>" title="Ngữ pháp">
                                            <span>Ngữ pháp</span>
                                        </a>
                                    </li>
                    		    <?php } ?>

                                <?php if (checkLesson($iUnit,'vocabulary') == 1){ ?>
                                    <li class="nav-menu-item <?if($type=="vocabulary"){echo "active act_ho";}?>" data-url="vocabulary">
                                        <a href="<?=$link_nav_vocabulary?>" title="Từ vựng">
                                            <span>Từ vựng</span>
                                        </a>
                                    </li>
                                <?php } ?>

                                <?php if($cou_form != 2){
                                    if(checkUnit($iUnit) == 1){ ?>
                                        <li class="nav-menu-item <?if($type=="quiz"){echo "active act_ho";}?>" data-url="quiz">
                                            <a href="<?=$link_nav_quiz?>" title="Bài tập">
                                                <span>Luyện tập</span>
                                            </a>
                                        </li>
                                    <?php } ?>
                                <?php } ?>

                            <?php } elseif($cou_form == 3){ ?>
                                <?php
                                $link_nav_stra          =  "http://".$base_url."/khoa-hoc/".removeTitle($nCou)  .   "/" . $iCou . "/" . $iUnit . "/strategy.html";
                                $link_nav_prac          =  "http://".$base_url."/khoa-hoc/".removeTitle($nCou)	.	"/" . $iCou . "/" . $iUnit . "/practice.html";
                                $link_nav_grammar	    =  "http://".$base_url."/khoa-hoc/".removeTitle($nCou)	.	"/" . $iCou . "/" . $iUnit . "/grammar.html";
                                $link_nav_vocabulary	=  "http://".$base_url."/khoa-hoc/".removeTitle($nCou)	.	"/" . $iCou . "/" . $iUnit . "/vocabulary.html";
                                ?>
                                <?php if(checkUnit_main($iUnit) == 1){ ?>
                                    <li class="nav-menu-item <?if($type=="strategy"){echo "active act_ho";}?>" data-url="strategy">
                                        <a href="<?=$link_nav_stra?>" title="Strategy">
                                            <span>Strategy</span>
                                        </a>
                                    </li>
                                <?php } ?>
                                <?php if (checkLesson($iUnit,'grammar') == 1){ ?>
                                    <li class="nav-menu-item <?if($type=="grammar"){echo "active act_ho";}?>" data-url="grammar">
                                        <a href="<?=$link_nav_grammar?>" title="Ngữ pháp">
                                            <span>Ngữ pháp</span>
                                        </a>
                                    </li>
                    			<?php } ?>
                                <?php if(checkLesson($iUnit,'vocabulary') == 1){ ?>
                                    <li class="nav-menu-item <?if($type=="vocabulary"){echo "active act_ho";}?>" data-url="vocabulary">
                                        <a href="<?=$link_nav_vocabulary?>" title="Từ vựng">
                                            <span>Từ vựng</span>
                                        </a>
                                    </li>
                                <?php } ?>
                                <?php if(checkUnit($iUnit) == 1){ ?>
                                    <li style="background: none!important;" class="nav-menu-item <?if($type=="practice"){echo "active act_ho";}?>" data-url="quiz">
                                        <a href="<?=$link_nav_prac?>" title="Bài tập">
                                            <span>Luyện tập</span>
                                        </a>
                                    </li>
                                <? } ?>
                             <?}?>
                             <?php $link_nav_result	   =  "http://".$base_url."/khoa-hoc/".removeTitle($str_cate)."/result/" . $iCou . "/" . $iUnit . "/" . removeTitle($nCou)	.	".html";   ?>
                    		</ul>
                    	</div>
                    </div>

                    <?php
                    /*-----------------------------------*/
                    if($type == "main" || $type == "strategy"){
                        if(checkLesson($iUnit,$type) != 1){
                            $type = "practice";
                        }
                    }
                    /*-----------------------------------*/
                    ?>

                    <!--CONTENT-->
                    <div id="main-content-area">
                        <div class="lesson-content" id="main-lesson">

                        <div class="social-tool">
                            <span class="fb-like-scl"><div class="fb-like" data-href="http://<?=$base_url.$_SERVER['REQUEST_URI']?>" data-width="450" data-layout="button_count" data-show-faces="false" data-send="false"></div></span>
                            <span class="fb-like-scl">
                                <div class="fb-share-button" data-href="http://<?=$base_url.$_SERVER['REQUEST_URI']?>" data-layout="button_count"></div>
                            </span>
                            <span class="google-like">
                                <script src="https://apis.google.com/js/platform.js" async defer></script>
                                <g:plusone></g:plusone>
                            </span>
                            <span class="google-share">
                                <div class="g-plus" data-action="share" data-annotation="none"></div>
                            </span>
                            <span class="twttr-like">
                                <a class="twitter-share-button" href="https://twitter.com/share"></a>
                                <script>
                                window.twttr=(function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],t=window.twttr||{};if(d.getElementById(id))return;js=d.createElement(s);js.id=id;js.src="https://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);t._e=[];t.ready=function(f){t._e.push(f);};return t;}(document,"script","twitter-wjs"));
                                </script>
                            </span>
                        </div>

                        <?php
                        if($med == 'edit'){
                            if($myuser->logged == 1){
                                if($checkCourseActive == 1 || $c_num == 1){
                                switch($type){
                                    case "main"       :
                                        lesson_main_edit($iUnit,$c_num,$c_name);
                                        break;
                                    case "grammar"    :
                                        lesson_grammar_edit($iUnit,$c_num,$c_name);
                                        break;
                                    case "vocabulary" :
                                        lesson_vocabulary_edit($iUnit,$c_num,$c_name);
                                        break;
                                    case "quiz"       :
                                        lesson_quiz_edit($iUnit,$c_num,$c_name);
                                        break;
                                    default           :
                                        redirect("http://".$base_url."/error404.html");
                                    break;
                                    }
                                }else{ ?>
                                    <div class="notice-payment">Bạn cần <a href="http://<?=$base_url?>/payment.html"><span>mua trọn gói</span></a> khóa học để có thể học được khóa học này.</div>
                                <?php }	?>
                            <?php }else{ ?>
                                <div class="notice-payment">Bạn cần <a href="http://<?=$base_url?>/dang-nhap.html"><span>đăng nhập</span></a> để có thể học thử được khóa học này.</div>
                            <?php }
                        }else{
                            if($myuser->logged == 1){
                                if($checkCourseActive == 1 || $c_num == 1){
                                    switch($type) {
                                      	case "main" :
                                      		lesson_main($iUnit,$c_num,$c_name);
                                      		break;
                                      	case "strategy"   :
                                            lesson_main_toeic($iUnit,$c_num,$c_name);
                                      		break;
                                      	case "practice"   :
                                      		if(checkUnit($iUnit) == 1){
                                      		    lesson_quiz($iUnit,$c_num,$c_name);
                                            }
                                      		if(checkLearn($iUnit,'writing') == 1){
                                      		    lesson_write($iUnit,$c_num,$c_name);
                                            }
                                      		if(checkLearn($iUnit,'speaking') == 1){
                                      		    lesson_speak($iUnit,$c_num,$c_name);
                                            }
                                      		break;
                                      	case "grammar"    :
                                            lesson_grammar($iUnit,$c_num,$c_name);
                                      		break;
                                      	case "vocabulary" :
                                            lesson_vocabulary($iUnit,$c_num,$c_name);
                                      		break;
                                      	case "quiz"       :
                                            lesson_quiz($iUnit,$c_num,$c_name);
                                      		break;
                                      	case "speak"      :
                                            lesson_speak($iUnit,$c_num,$c_name);
                                      		break;
                                      	case "write"      :
                                            lesson_write($iUnit,$c_num,$c_name);
                                      		break;
                                      	default           :
                                      		break;
                                    }
                                }else{ ?>
                                    <div class="notice-payment">Bạn cần <a href="http://<?=$base_url?>/payment.html"><span>mua trọn gói</span></a> khóa học để có thể học được khóa học này.</div>
                                <?php } ?>
                            <?php }else{ ?>
                                <div class="notice-payment">Bạn cần <a href="http://<?=$base_url?>/dang-nhap.html"><span>đăng nhập</span></a> để có thể học thử được khóa học này.</div>
                            <?php } ?>

                            <!--<div class="fb-wrap-comment">
                                <div class="fb-comments" data-href="http://tienganh2020.com" data-numposts="10" data-colorscheme="light"></div>
                            </div>-->

                        <?php } ?>
                       </div>
                    </div>
                </div>
                <div class="list-courses-main-sidebar">
                    <?php include_once('../includes/inc_sidebar_faq.php');?>
                </div>
            </div>
        </div>
    </div>
</div>