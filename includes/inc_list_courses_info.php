<?php

$iCou    = getValue("iCourse","int","GET",""); //id khóa học

$sqlForm    = new db_query('SELECT * FROM courses WHERE cou_id = '.$iCou);
if($row_form     = mysql_fetch_assoc($sqlForm->result)){ 
    $cou_form       = $row_form['cou_form'];
    $cou_id         = $row_form['cou_id'];
    $cou_inf        = $row_form['cou_info']; 
    $cou_condition  = $row_form['cou_condition']; 
    $cou_goal       = $row_form['cou_goal']; 
    $cou_object     = $row_form['cou_object']; 
    $course_name    = $row_form['cou_name'];
    $course_avatar  = $row_form['cou_avatar'];
}unset($sqlForm);

$sqlcName = new db_query('SELECT com_id,com_name,com_num_unit FROM courses_multi WHERE com_cou_id = '.$iCou.' ORDER BY com_num_unit ASC');
if($row_cName = mysql_fetch_assoc($sqlcName->result)){
    $iUnit  = $row_cName['com_id'];
    $c_name = $row_cName['com_name'];
    $c_num  = $row_cName['com_num_unit']; 
}unset($sqlcName);

$sqlinfo = new db_query('SELECT cou_name,cat_name,cat_id,cat_parent_id,cou_lev_id FROM courses a,categories_multi b WHERE a.cou_cat_id = b.cat_id AND cou_id='.$iCou);
$rowInfo   = mysql_fetch_assoc($sqlinfo->result);
    $lev_id        = $rowInfo['cou_lev_id']; 
    $cat_id        = $rowInfo['cat_id'];
    $cat_parent_id = $rowInfo['cat_parent_id'];  
    $cat_name_inf  = $rowInfo['cat_name'];
    $cou_name_inf  = $rowInfo['cou_name'];
unset($sqlinfo);

// GET ARRAY CAT TOEIC,TOEFL,IELTS
// 9 - TOEFL ; 76,161,165,170 - TOEIC ; 35 IELTS
$arrCateTest    = array(9,76,161,165,170,35);

if($cou_form == 1 || $cou_form == 2){
    $urlCourse          =  "http://".$base_url."/khoa-hoc/". removeTitle($course_name) .   "/" . $iCou . "/" . $iUnit . "/main.html";
}elseif($cou_form == 3){
    $urlCourse          =  "http://".$base_url."/khoa-hoc/".removeTitle($course_name)  .   "/" . $iCou . "/" . $iUnit . "/strategy.html";  
}

$dbSelectRandomCourse = new db_query('SELECT * FROM courses WHERE cou_active = 1 AND cou_cat_id = '.$cat_id.' ORDER BY RAND() DESC LIMIT 3');
$arrRandomCourse = $dbSelectRandomCourse->resultArray();
unset($dbSelectRandomCourse);   

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
                        <h1><span><?=$course_name?></span></h1>
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
            </div>
        </div>
    </div>

    <div class="list-courses-filter-info">
        <div class="content">
            <div class="content-main">
                <div class="list-courses-filter-info-left">
                    <img src="<?=$var_path_course_medium.$course_avatar?>">
                </div>
                <div class="list-courses-filter-info-right">
                    <div class="course-info-right-title">
                        <?=$course_name?>
                    </div>
                    <div class="course-info-right-description">
                        <?=$cou_inf?>
                    </div>
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
                    <div class="course-info-right-button">
                        <a href="<?=$urlCourse?>">Bắt đầu học</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="list-courses-filter-des">
        <div class="content">
            <div class="content-main">
                <div class="course-filter-des">
                    <div class="list-courses-filter-des-left">
                        <div class="courses-des-left-title">
                            <h2>Giới thiệu</h2>
                        </div>
                        <div class="courses-des-left-content">
                            Khóa học cung cấp bài học liên quan đển các chủ đề như cách hướng dẫn, các nguyên tắc, trải nghiệm, training công việc mới,...Các chủ đề này đòi hỏi vốn từ vựng và ngữ pháp rộng hơn. Vì vậy khóa học cũng cung cấp đầy đủ nội dung ngữ pháp liên quan như thì tương lai, tiếp diễn,..Mỗi bài học, học viên luyện tập đầy đủ 4 kĩ năng nghe, nói, đọc, viết.
                        </div>
                        <div class="courses-des-left-teacher">
                            <div class="courses-des-left-teacher-title">Giảng viên</div>
                            <div class="courses-des-left-teacher-content">
                                <div class="teach-img">
                                    <img src="http://<?=$base_url?>/themes/img/logo.png">
                                </div>
                                <div class="teach-info">
                                    Để đáp ứng nhu cầu học Tiếng Anh ngày càng cao của phần lớn học sinh, sinh viên và người đi làm, Tienganh2020.com ra đời, mang đến nhiều khóa học hữu ích với mục đích khác nhau, phù hợp với nhiều đối tượng học.
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="courses-des-left-teacher-info">
                                <p>Với nhiều năm kinh nghiệm trong lĩnh vực giáo dục, đội ngũ giáo viên của trung tâm TiengAnh2020, cùng sự hỗ trợ của đông đảo giáo viên khối trung học cơ sở, trung học phổ thông, nhiều trường cao đẳng và đại học, đã cho ra đời hệ thống khóa học được thiết kế công phu, mỗi khóa học gồm nhiều bài học, phần học chi tiết, có bài tập đi kèm và hệ thống ghi âm, chấm bài cùng nhiều tính năng có tính tương tác cao.</p>
                                <p>Đội ngũ giáo viên của TiengAnh2020.com luôn tận tâm với học viên, chấm và gửi kết quả bài làm sớm, cùng những lời nhận xét, đóng góp quý báu để các bạn hoàn thiện kĩ năng hơn. Không chỉ trách nhiệm, đem tới kiến thức, phương pháp học, đội ngũ giáo viên của trung tâm TiengAnh2020 không ngừng khích lệ, động viên, cẩn thận chỉ ra những thiếu sót trong quá trình học viên theo học trực tuyến, làm bài.</p>
                                <p>Chúng tôi tin tưởng với đội ngũ giáo viên tận tâm, yêu nghề, nhiệt tình và đặc biệt luôn có đam mê với ngôn ngữ, mong mỏi học viên không ngừng tiến bộ, học viên của TiengAnh2020.com sẽ trau dồi thêm nhiều kiến thức bổ ích thật hiệu quả.</p>
                            </div>
                        </div>
                        <div class="courses-des-related">
                            <?foreach($arrRandomCourse as $key=>$value){?>
                                <div class="courses-des-related-content">
                                    <a href="<?=gen_course($value['cou_id'],$value['cou_name'])?>">
                                        <div class="courses-des-related-content-img">
                                            <img src="<?=$var_path_course_medium.$value['cou_avatar']?>">
                                        </div>
                                    </a>
                                    <div class="courses-des-related-content-title">
                                        <a href="<?=gen_course($value['cou_id'],$value['cou_name'])?>">
                                            <?=$value['cou_name']?>
                                        </a>
                                    </div>
                                    <div class="courses-des-related-content-cate">
                                        <?=$cat_name_inf?>
                                    </div>
                                </div>
                            <?}?>
                        </div>
                    </div>

                    <div class="list-courses-filter-des-right">
                        <div class="learn-condition-wrap">
                            <div class="learn-condition-title">
                                Điều kiện học
                            </div>
                            <div class="learn-condition-content">
                                <?=$cou_condition?>
                            </div>
                            <div class="learn-condition-title">
                                Mục tiêu khóa học
                            </div>
                            <div class="learn-condition-content">
                                <?=$cou_goal?>
                            </div>
                            <div class="learn-condition-title">
                               Đối tượng học
                            </div>
                            <div class="learn-condition-content">
                                <?=$cou_object?>
                            </div>
                        </div>
                        <div class="learn-content">
                            <div class="learn-content-title">
                                Nội dung khóa học
                            </div>
                            <div class="learn-content-main">
                                <ul>
                                    <?php
                                    $i = 0;
                                    $sqlUnitNum = new db_query("SELECT com_id,com_num_unit,com_name FROM courses_multi WHERE com_cou_id = ".$iCou." ORDER BY com_num_unit");
                                    while($rowUnitNum = mysql_fetch_assoc($sqlUnitNum->result)){
                                    $i++;
                                    $com_id = $rowUnitNum['com_id'];
                                    $com_name = $rowUnitNum['com_name'];
                                    $com_num_unit = $rowUnitNum['com_num_unit'];
                                    if($myuser->logged == 1){
                                        $checkCourseActive = check_course_active($myuser->u_id); 
                                        if($checkCourseActive == 1){
                                            $urlCourseActive = gen_course_details(0,$com_id);
                                            $confirmPay = '';
                                        }else{
                                            if($com_num_unit == 1){
                                                $urlCourseActive = gen_course_details(0,$com_id);
                                                $confirmPay = 'none-confirmPay-class';
                                            }else{
                                                $urlCourseActive = "#";
                                                $confirmPay = 'confirm-pay';
                                            }
                                        }
                                        $confirmLoggin = 'none-confirmLoggin-class';
                                    }else{
                                        $urlCourseActive = "#";
                                        $confirmLoggin = 'confirm-loggin';
                                    }
                                    ?>
                                        <li class="<?=($checkCourseActive == 0)?'activecourse':'none-activeCourse-class';?> <?=$confirmPay?> <?=$confirmLoggin?>">
                                            <a href="<?=$urlCourseActive?>">
                                                Bài <?=$rowUnitNum['com_num_unit']?> : <?=truncateString_($rowUnitNum['com_name'],25)?>
                                            </a>
                                        </li>
                                    <?php }unset($sqlUnitNum);?>        
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="list-courses-main">
        <div class="content">
            <div class="content-main">
                
            </div>
        </div>
    </div>
</div>