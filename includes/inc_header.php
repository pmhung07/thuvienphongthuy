<?php
$module = getValue("module","str","GET","");
$iCategory = getValue('iCategory','int','GET',0);

$nLanguage = getValue("nLanguage","str","GET",'vi');
$cv_language = 1;

if($nLanguage == "vi"){
    $cv_language = 1;
}elseif($nLanguage == "en"){
    $cv_language = 2;
}else{
    $cv_language = 1;
}  
?>
<!--HEADER-->
<div class="header-top-nav">
    <div class="content">
        <div class="content-main">
            <div class="header_top">
                <div class="header_top_left">
                    <ul>
                        <a href="http://facebook.com"><li class="social s_facebook"></li></a>
                        <a href="http://google.com"><li class="social s_google"></li></a>
                        <a href="https://twitter.com/"><li class="social s_tw"></li></a>
                    </ul>
                    <div class="contact">
                        tamnguyen@9119.vn
                    </div>
                    <a style="float: left;display: block;height: 40px;line-height: 40px;color: white;background-color: #4a4747;font-size: 12px;padding: 0px 10px;text-transform: uppercase;margin-left:5px;" href="http://<?=$base_url?>/news.htm">Tin tức</a>
                </div>
                <div class="header_top_right">
                    <div class="register">
                        <!--<a href="http://<?=$base_url?>/login">Đăng nhập | Đăng ký</a>-->
                        <?php if($myuser->logged != 1) { ?>
                        <a href="http://<?=$base_url?>/login.htm">
                            Đăng nhập | Đăng ký
                        </a>
                        <?php }else{ ?>
                            <div class="register_logged">
                                <a class="user_logged" href="http://<?=$base_url?>/user/info.html"><?=convertname($myuser->use_name)?></a> | 
                                <a href="http://<?=$base_url?>/logout.htm">Đăng xuất</a>
                                <div class="user_dropdown">
                                    <div class="listtool">Điểm kinh nghiệm : <?=$myuser->use_ex?></div>
                                    <?php
                                    $choosearm = 0;
                                    $armname = '';
                                    $armimg = '';
                                    $db_listarm = new db_query("SELECT * FROM listarm WHERE listarm_exp < ".$myuser->use_ex);
                                    $arr_listarm = $db_listarm->resultArray();

                                    if(count($arr_listarm) > 0){
                                        foreach($arr_listarm as $keyarm => $valuearm){
                                            if($valuearm['listarm_exp'] > $choosearm){
                                                $choosearm = $valuearm['listarm_exp'];
                                                $armname = $valuearm['listarm_name'];
                                                $armimg = $valuearm['listarm_img'];
                                            }elseif($valuearm['listarm_exp'] < $choosearm || $valuearm['listarm_exp'] == 0){
                                                $armname = 'Chưa có huy hiệu';
                                            }
                                        }
                                    }else{
                                        $armname = 'Chưa có huy hiệu';
                                    }
                                    ?>
                                    <div style="padding-left:<?=(count($arr_listarm) > 0)?'40px':'';?>;background: url('http://hamhoc.edu.vn/pictures/arm/<?=$armimg?>') 10px;background-size: 20px;background-repeat: no-repeat;" class="listtool">Huy hiệu : <?=$armname?></div>
                                    
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="search">
                        <input class="ipsearch" type="text" value="" placeholder="Mã thẻ học ...">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="header_logo"> 
    <div class="content">
        <div class="content-main">
            <a href="http://<?=$base_url?>">
                <img class="imglogo" src="http://phongthuyvuong.com/themes/tamnguyen/images/logo_home.png">
            </a>
        </div>
    </div>
</div>
<div class="header_nav"> 
    <div class="content">
        <div class="content-main">
            <ul>
                <li class="header_nal_parent header_nal_li_active">
                    <a>Khoá học</a>
                    <?php
                    $dbCateCourses = new db_query("SELECT * FROM categories_multi WHERE cat_type = 1 AND cat_parent_id = 0 AND cat_active = 1");
                    $arrCateCourses = $dbCateCourses->resultArray();
                    if(count($arrCateCourses) > 0){
                    ?>
                    <ul class="ul_child">
                        <?php foreach($arrCateCourses as $key => $value){ ?>
                            <li class="ul_child_li">
                                <a href="<?=gen_course_list($value['cat_id'],$value['cat_name'])?>"><?=$value['cat_name']?></a>
                            </li>
                        <?php } ?>
                    </ul>
                    <?php } ?>
                </li>
                <li class="header_nal_parent header_nal_li_active">
                    <a>Tài liệu</a>
                    <?php
                    $dbCateCourses = new db_query("SELECT * FROM categories_multi WHERE cat_type = 2 AND cat_parent_id = 0 AND cat_active = 1");
                    $arrCateCourses = $dbCateCourses->resultArray();
                    if(count($arrCateCourses) > 0){
                    ?>
                    <ul class="ul_child">
                        <?php foreach($arrCateCourses as $key => $value){ ?>
                            <li class="ul_child_li">
                                <a href="<?=gen_cv_list($value['cat_id'],$value['cat_name'])?>"><?=$value['cat_name']?></a>
                            </li>
                        <?php } ?>
                    </ul>
                    <?php } ?>
                </li>
            </ul>
        </div>
    </div>
</div>