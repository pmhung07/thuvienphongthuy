<?php
    $iCategory = getValue("iCategory","int","GET",0);  
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

<?

if($iCategory == 0){

$dbCate = new db_query("SELECT * FROM categories_multi WHERE cat_type = 2 AND cat_parent_id = 0 LIMIT 5");
$arrCate = $dbCate->resultArray();
?>
<?php foreach($arrCate as $key => $value) { ?>
<div class="main_home_details">
    <div class="content">
        <div class="content-main">
            <div class="main_home_details_left">
                <div class="main_home_details_left_title">
                    THÔNG TIN TUYỂN DỤNG
                </div>
                <div class="main_home_details_left_content">
                    <?php
                    $dbPost = new db_query("SELECT * FROM posts
                                            /*INNER JOIN categories_multi ON posts.post_cat_id=categories_multi.cat_id 
                                            WHERE post_cat_related_id = ".$value["cat_id"]."*/ LIMIT 5");
                    $arrpost = $dbPost->resultArray();
                    foreach($arrpost as $keyposts => $valueposts){
                    ?>
                        <div class="home_content_left_list_details_job">
                            <a href="<?=gen_news_list_details($valueposts['post_title'],$iCategory,$valueposts['post_id'])?>">
                                <div class="home_left_content_img_job">
                                    <img src="<?=$var_path_news.$valueposts['post_picture']?>">
                                </div>
                            </a>
                            <a href="<?=gen_news_list_details($valueposts['post_title'],$iCategory,$valueposts['post_id'])?>">
                                <div class="home_left_content_details_job">
                                    <div class="home_left_content_details_name_job"><?=$valueposts['post_title']?></div>
                                </div>
                            </a>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <div class="main_home_details_right">
                <div class="main_home_details_right_title">
                    <?//=$value["cat_name"]?>
                </div>
                <div class="main_home_details_right_content">
                    <?php  
                    $dbCateChild = new db_query("SELECT * FROM categories_multi WHERE cat_type = 2 AND cat_parent_id =".$value["cat_id"]);
                    $arrCVCateChild = $dbCateChild->resultArray();
                    ?>
                    <?php foreach($arrCVCateChild as $keyCV => $valueCV) { ?>
                    <div class="home_detail_right_details">
                        <div class="home_dtls_right_img">
                            <a href="<?=gen_cv_list($nLanguage,$valueCV['cat_id'],$valueCV['cat_name'])?>">
                                <? if($valueCV['cat_picture'] == 'NULL'){ ?>
                                    <img style="height:90px;" src="http://hamhoc.edu.vn/pictures/categories/jim1432029102.png">
                                <? }else{ ?>
                                    <img style="height:90px;" src="http://<?=$base_url?>/pictures/categories/<?=$valueCV['cat_picture']?>">
                                <? } ?>
                            </a>
                        </div>
                        <div class="home_dtls_right_name">
                            <a href="<?=gen_cv_list($nLanguage,$valueCV['cat_id'],$valueCV['cat_name'])?>">
                                <?=$valueCV['cat_name']?>
                            </a>
                        </div>
                        <!--<div class="home_dtls_right_author">
                            <?//=$value["cat_name"]?>
                        </div>-->
                    </div>
                    <?php } ?>
                </div>
            </div>

            <div class="main_home_url_category" style="background:<?=$arrayBgColor[$j-1]?>">
                <span>Hơn <?=count($arrCVCateChild)?> CV mẫu công việc cho <?=$value["cat_name"]?> </span>
                <a href="<?=gen_cv_list($nLanguage,$value['cat_id'],$value['cat_name'])?>">XEM NGAY</a>
            </div>
        </div>
    </div>
</div>
<?php } }else{ ?>

    <?php

    $sql= '';
    $sql_cate='';
    $sql_cate .= ' cat_id='.$iCategory;

    $dbCate = new db_query('SELECT * FROM categories_multi WHERE'.$sql_cate);
    $arrCate = $dbCate->resultArray();

    if($arrCate[0]['cat_parent_id'] != 0){
        $sql .= ' cv_cat_id ='.$iCategory;
    }else{
        $sql .= ' cv_cat_parent_id ='.$iCategory;
    }

    $dbCourses = new db_query('SELECT * FROM cover_letters 
                                INNER JOIN categories_multi ON cover_letters.cv_cat_id=categories_multi.cat_id 
                                WHERE'.$sql.' AND cv_language = '.$cv_language.' AND cv_active = 1 LIMIT 30');
    $arrCourses = $dbCourses->resultArray();

    ?>

    <div class="list-courses">
        <div class="list-courses-filter">
            <div class="content">
                <div class="content-main">
                    <div class="list-courses-filter-wrap">
                        <div class="list-courses-filter-title">
                            <div class="list-courses-filter-title-main">
                                <span><h1><?=$arrCate[0]['cat_name']?></h1></span>
                            </div>
                            <div class="list-description">
                                <?=$arrCate[0]['cat_description']?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="list-courses-main">
            <div class="content">
                <div class="content-main">
                    <div class="list-courses-main-content-list">
                        <div class="list-courses-main-content-show">
                            <?php foreach($arrCourses as $keyCourse => $valueCourse){ ?>
                            <div class="content-show-courses-list">
                                <div class="courses_list_wrap_content">
                                    <div class="content-show-courses-img">
                                        <a href="<?=gen_cv_list_details($valueCourse['cv_name'],$iCategory,$valueCourse['cv_id'])?>">
                                            <img src="<?=$var_path_cv.$valueCourse['cv_avatar']?>">
                                        </a>
                                    </div>
                                    <div class="content-show-cv-info">
                                        <a href="<?=gen_cv_list_details($valueCourse['cv_name'],$iCategory,$valueCourse['cv_id'])?>">
                                            <div class="content-show-courses-info-title-cv">
                                                <span><?=$valueCourse['cv_name']?></span>
                                            </div>
                                            <div class="nguoimua">Có <span style="color:rgb(214, 96, 96);"><?=$valueCourse['cv_downloads']?></span> người tải.</div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                            <?php
                            /* PAGING */
                            $num_new_list = 8;
                            $total = 0;
                            $page = 0;
                            $start = $page;
                            if(intval($start) == 0){
                               $page = 1;
                            }
                            $pageCount = (int)($total/$num_new_list);
                            $div = $total % $num_new_list;          
                            if($div!= 0){
                               $pageCount = $pageCount + 1;
                            }
                            $pageCount;
                            if($page > $pageCount){
                               $page = 1;
                            }
                            $start = ($page-1)*$num_new_list;
                            $str = '';
                            ?>
                            <div class="paging">
                                <div class="paging_listing">
                                    <ul>
                                    <?if($pageCount > 1){?>
                                        <?php if($page > 1){
                                            $str .= '<a title="'.($page-1).'" class="a_paging listing_page_pre"> < </a>';
                                        }?>
                                        <?php
                                        if($pageCount > 10){
                                            if($page < 9){
                                                if($page < 6){
                                                    for ($i=1; $i<=9; $i++) {
                                                        if($i == $page){
                                                            $str .= '<a class="active_listing_page" title="'.$page.'">'.$page.'</a>';
                                                        }else{
                                                            $str .= '<a class="a_paging" title="'.$i.'">'.$i.'</a>';
                                                        }
                                                    }
                                                }else{
                                                    for ($i=1; $i<$page+4; $i++) {
                                                        if($i == $page){
                                                            $str .= '<a class="active_listing_page" title="'.$page.'">'.$page.'</a>';
                                                        }else{
                                                            $str .= '<a class="a_paging" title="'.$i.'">'.$i.'</a>';
                                                        }
                                                    }
                                                }
                                                $str .= '<a>…</a>';
                                                for ($j = ($pageCount - 1); $j <= $pageCount; $j++) { 
                                                    $str .= '<a class="a_paging" title="'.$j.'">'.$j.'</a>';
                                                }
                                            }else{
                                                $go_page = $page + 4;
                                                if($pageCount - $page > 8 && $go_page < $pageCount - 3){
                                                    for ($i=1; $i<=2; $i++) { 
                                                        $str .= '<a class="a_paging" title="'.$i.'">'.$i.'</a>';
                                                    }
                                                    $str .= '<a>…</a>';
                                                    $go_page = ($page + 3 > $pageCount)?$pageCount - 2: $page + 3;
                                                    for($i = ($page - 3); $i <= $go_page; $i++){
                                                        if($i == $page){
                                                            $str .= '<a class="active_listing_page" title="'.$page.'">'.$page.'</a>';
                                                        }else{
                                                            $str .= '<a class="a_paging" title="'.$i.'">'.$i.'</a>';
                                                        }
                                                    }
                                                    $str .= '<span>…</span>';
                                                    for ($j = ($pageCount - 1); $j <= $pageCount; $j++) { 
                                                        $str .= '<a class="a_paging" title="'.$j.'">'.$j.'</a>';
                                                    }
                                                }else{
                                                    if($pageCount-$page < 6) {
                                                        for ($i=1; $i<=2; $i++) { 
                                                           $str .= '<a class="a_paging" title="'.$i.'">'.$i.'</a>';
                                                        }
                                                        $str .= '<span>…</span>';
                                                        for ($i= $pageCount - 8; $i<=$pageCount; $i++) {
                                                            if($i == $page){
                                                                $str .= '<a class="active_listing_page" title="'.$page.'">'.$page.'</a>';
                                                            }else{
                                                                $str .= '<a class="a_paging" title="'.$i.'">'.$i.'</a>';
                                                            }
                                                        }
                                                    }else{
                                                        for ($i=1; $i<=2; $i++) { 
                                                            $str .= '<a class="a_paging" title="'.$i.'">'.$i.'</a>';
                                                        }
                                                        $str .= '<span>…</span>';
                                                        for ($i= $page - 3;$i<=$pageCount; $i++) {
                                                            if($i == $page){
                                                                $str .= '<a class="active_listing_page" title="'.$page.'">'.$page.'</a>';
                                                            }else{
                                                                $str .= '<a class="a_paging" title="'.$i.'">'.$i.'</a>';
                                                            }
                                                        }
                                                    }
                                                }}}else{
                                                    for ($i= 1;$i<=$pageCount; $i++) {
                                                        if($i == $page){
                                                            $str .= '<a class="active_listing_page" title="'.$page.'">'.$page.'</a>';
                                                        }else{
                                                            $str .= '<a class="a_paging" title="'.$i.'">'.$i.'</a>';
                                                        }
                                                    }
                                                }
                                                ?>
                                                <?if($page < $pageCount){
                                                    $str .= '<a title="'.($page+1).'" class="a_paging listing_page_next"> > </a>';
                                                }?>
                                            <?}?>
                                        <?echo $str;?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="list-courses-main-sidebar">
                            <?php include_once('inc_sidebar_cv.php');?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php } ?>