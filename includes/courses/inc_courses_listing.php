<?php
    $iCategory = getValue('iCategory','int','GET',0);
    $sql= '';
    $sql_cate='';
    if($iCategory == 0){
        $sql .= ' 1';
        $sql_cate .= ' 1';
    }else{
        $sql .= ' cou_cat_id ='.$iCategory;
        $sql_cate .= ' cat_id='.$iCategory;
    }
    $dbCourses = new db_query('SELECT * FROM courses 
                                INNER JOIN categories_multi ON courses.cou_cat_id=categories_multi.cat_id 
                                WHERE'.$sql);
    $arrCourses = $dbCourses->resultArray();

    $dbCate = new db_query('SELECT * FROM categories_multi WHERE'.$sql_cate);
    $arrCate = $dbCate->resultArray();

?>

<div class="list-courses">
    <div class="list-courses-filter">
        <div class="content">
            <div class="content-main">
                <div class="list-courses-filter-wrap">
                    <div class="list-courses-filter-title">
                        <div class="list-courses-filter-title-main">
                            <?php if($iCategory == 0){ ?>
                                <span><h1>Danh sách Khóa Học</h1></span>
                            <?php }else{ ?>
                                <span><h1>Danh sách Khóa Học <?=$arrCate[0]['cat_name']?></h1></span>
                            <?php } ?>
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
                                    <a href="<?=gen_course_info($valueCourse['cou_id'],$valueCourse['cou_name'])?>">
                                <?php if($valueCourse['cou_avatar'] != ""){ ?>
                                    <img src="<?=$var_path_course.$valueCourse['cou_avatar']?>">
                                <?php }else{ ?>
                                    <img src="http://thuvienphongthuy.vn/themes/img/no-image.png">
                                <?php } ?>
                                    </a>
                                </div>
                                <div class="home_dtls_right_name">
                                    <a href="<?=gen_course_info($valueCourse['cou_id'],$valueCourse['cou_name'])?>">
                                    <span style="border-bottom: solid 3px;padding-bottom: 5px;" class="namecourse"><?=$valueCourse['cou_name']?></span></a>
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
                        <?php include_once('inc_sidebar_courses.php');?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>